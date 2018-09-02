<template lang="html">
    <div class="panel panel-primary">
        <div class="panel-heading">
            {{title}}
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time</th>
                    <th class="text-center">Duration</th>
                    <th class="text-center">Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in dwellingTimes">
                    <td class="text-center">{{d.time | readableDate}}</td>
                    <td class="text-center">{{d.time | readableTime}}</td>
                    <td class="text-center">{{d.duration | readableDuration}}</td>
                    <td class="text-center">
                        <span :class="['label', 'label-' + colors[d.status]]">
                            {{statuses[d.status]}}
                        </span>
                    </td>
                    <td>{{d.description}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'DwellingTime',
    props: ['barging', 'title'],
    data: function() {
        return {
            dwellingTimes: [],
            statuses: ["Initiate", "Loading", "Breakdown", "Delay", "Idle", "Complete"],
            colors: ["info", "success", "danger", "warning", "default", "primary"],
        }
    },
    filters: {
        readableDate: function(v) {
            return moment(v).format('DD-MMM-YYYY');
        },
        readableTime: function(v) {
            return moment(v).format('HH:mm');
        },
        readableDuration(v) {
            if (parseInt(v)) {
                var days = Math.floor(v/(60*24));
                var hours = Math.floor((v%(60*24)) / 60);
                var mins = Math.floor(v%60);
                return days+'d:'+hours+'h:'+mins+'m';
            }

            return '-';
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                barging_id: _this.barging
            };

            axios.get(BASE_URL + '/api/dwellingTime', {params:params})
                .then(function(r) {
                    _this.dwellingTimes = r.data;

                    for (var i in _this.dwellingTimes) {
                        if (_this.dwellingTimes[i].status == 0) {
                            _this.dwellingTimes[i].duration = '-';
                            continue;
                        }

                        var date1 = moment(_this.dwellingTimes[i].time)
                        var date2 = (i == 0) ? moment() : moment(_this.dwellingTimes[i-1].time);
                        var duration = moment.duration(date2.diff(date1));
                        _this.dwellingTimes[i].duration = duration.asMinutes();
                    }

                })
                .catch(function(e) {
                    console.log(e);
                });

            setTimeout(this.requestData, 5000);
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css">
</style>
