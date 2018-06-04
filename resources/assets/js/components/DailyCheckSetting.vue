<template>
    <div class="panel panel-primary">
        <div class="panel-heading">
            DAILY CHECK SETTING
        </div>
        <Container>
            <table class="table table-bordered" style="margin-bottom:0;">
                <thead>
                    <tr>
                        <th class="text-center">UNIT BELUM TERJADWAL</th>
                        <th style="width:195px;" v-for="(d,i) in dailyCheckSettings" class="text-center">{{days[i]}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <Container group-name="day" :get-child-payload="getUnit(-1)">
                                <Draggable v-for="u in unscheduled" :key="u.id" class="label label-danger" style="margin-bottom:3px;text-align:left;">
                                    {{u.name}}
                                </Draggable>
                            </Container>
                        </td>
                        <td v-for="(d,i) in dailyCheckSettings">
                            <Container group-name="day" @drop="assign(i, $event)" :get-child-payload="getUnit(i)" style="min-height:200px;">
                                <Draggable v-for="s in d" :key="s.unit_id" class="label label-info" style="margin-bottom:3px;text-align:left;">
                                    <a href="#" class="pull-right" @click.prevent="del(s.id)"><i class="fa fa-remove"></i></a> {{s.unit}}
                                </Draggable>
                            </Container>
                        </td>
                    </tr>
                </tbody>
            </table>
        </Container>
    </div>
</template>

<script>
    import { Container, Draggable } from "vue-smooth-dnd";

    export default {
        name: "DailyCheckSetting",
        components: { Container, Draggable },
        data: function() {
            return {
                days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                unscheduled: [],
                dailyCheckSettings: [],
            }
        },
        methods: {
            getUnit: function(day) {
                var _this = this;
                return index => {
                    return day == -1  ? _this.unscheduled[index] : _this.dailyCheckSettings[day][index];
                }
            },
            assign: function(day, dropResult) {
                if (dropResult.addedIndex !== null) {

                    if (dropResult.payload.unit_id == undefined) {
                        this.create({
                            day: day,
                            unit_id: dropResult.payload.id
                        });
                    }

                    else {
                        this.update(dropResult.payload.id, {
                            day: day,
                            unit_id: dropResult.payload.unit_id
                        })
                    }

                }
            },
            create: function(data) {
                var _this = this;
                axios.post('dailyCheckSetting', data).then(function(r) {
                    _this.getData();
                    _this.getUnscheduled();
                })

                .catch(function(error) {
                    if (error.response.status == 422) {
                        toastr["error"](JSON.stringify(error.response.data.errors));
                    }

                    if (error.response.status == 500) {
                        var error = error.response.data;
                        toastr["error"](error.message + ". " + error.file + ":" + error.line);
                    }
                });
            },
            update: function(id, data) {
                var _this = this;
                axios.put('dailyCheckSetting/' + id, data).then(function(r) {
                    _this.getData();
                    _this.getUnscheduled();
                })

                .catch(function(error) {
                    if (error.response.status == 422) {
                        toastr["error"](JSON.stringify(error.response.data.errors));
                    }

                    if (error.response.status == 500) {
                        var error = error.response.data;
                        toastr["error"](error.message + ". " + error.file + ":" + error.line);
                    }
                });
            },
            del: function(id) {
                var _this = this;
                axios.delete('dailyCheckSetting/' + id).then(function(r) {
                    if (r.data.success == true) {
                        _this.getData();
                        _this.getUnscheduled();
                    } else {
                        toastr["error"]("Data gagal disimpan. " + r.data.message);
                    }
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });
            },
            getData: function() {
                var _this = this;
                axios.get('dailyCheckSetting').then(function(r) {
                    for (var i = 0; i <= 6; i++) {
                        _this.dailyCheckSettings[i] = r.data.filter(s => s.day === i);
                    }
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });
            },
            getUnscheduled: function() {
                var _this = this;
                axios.get('dailyCheckSetting/unScheduled').then(function(r) {
                    _this.unscheduled = r.data;
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });
            },
        },
        mounted: function() {
            this.getData();
            this.getUnscheduled();
        }
    }
</script>
