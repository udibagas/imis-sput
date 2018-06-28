<template>
    <div>
        <div class="row">
            <div v-for="j in jetties" class="col-md-3">

                <div :class="['panel', j.status ? 'panel-success' : 'panel-danger']">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="#" @click.prevent="jettyAction(j)"><i class="icon-cog"></i></a>
                        </div>
                        JETTY {{j.name}}
                    </div>
                    <div class="panel-body text-center" style="height:500px;">
                        <button v-if="j.barge" type="button" class="btn btn-info btn-lg" style="margin-bottom:5px;" @click="bargeJettyAction(j.barge)">
                            {{j.barge.name}}
                        </button>

                        <div v-if="j.barge" class="progress" style="height:5px;">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>

                        <div class="" v-for="s in j.stock_area">
                            {{s.name}}
                        </div>

                        <div :id="'chart-' +j.id" style="height:200px;">
                            chart untuk jetty {{j.name}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="34%" class="success text-center">BARGES</th>
                    <th width="33%" class="success text-center">TUGBOATS</th>
                    <th width="33%" class="success text-center">UNITS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="b in barges" @click="bargeAction(b)">
                            <i class="fa fa-anchor"></i> {{b.name}}
                        </button>
                    </td>

                    <td>
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="t in tugboats" @click="tugboatAction(t)">
                            <i class="fa fa-ship"></i> {{t.name}}
                        </button>
                    </td>

                    <td>
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="u in units" @click="unitAction(u)">
                            <i class="fa fa-truck"></i> {{u.name}}
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
import { Container, Draggable } from "vue-smooth-dnd";

export default {
    name: "Game",
    components: { Container, Draggable },
    data: function() {
        return {
            charts: null,
            units: [],
            areas: [],
            seams: [],
            barges: [],
            jetties: [],
            tugboats: [],
            customers: []
        }
    },
    methods: {
        bargeAction: function(b) {
            alert(JSON.stringify(b));
        },
        unitAction: function(u) {
            alert(JSON.stringify(u));
        },
        tugboatAction: function(t) {
            alert(JSON.stringify(t));
        },
        jettyAction: function(j) {
            alert(JSON.stringify(j));
        },
        bargeJettyAction: function(b) {
            alert(JSON.stringify(b));
        },
        getUnit: function() {
            var _this = this;
            axios.get('api/unit').then(function(r) {
                _this.units = r.data.filter(u => u.name.toLowerCase().match('wl') || u.name.toLowerCase().match('ld'));
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getBarge: function() {
            var _this = this;
            axios.get('api/barge').then(function(r) {
                _this.barges = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getJetty: function() {
            var _this = this;
            axios.get('api/jetty').then(function(r) {
                _this.jetties = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getArea: function() {
            var _this = this;
            axios.get('api/area').then(function(r) {
                _this.areas = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getCustomer: function() {
            var _this = this;
            axios.get('api/customer').then(function(r) {
                _this.customers = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getSeam: function() {
            var _this = this;
            axios.get('api/seam').then(function(r) {
                _this.seams = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getTugboat: function() {
            var _this = this;
            axios.get('api/tugboat').then(function(r) {
                _this.tugboats = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        requestDataJetty: function() {

        },
        sync: function() {
            this.getUnit();
            this.getArea();
            this.getBarge();
            this.getCustomer();
            this.getJetty();
            this.getSeam();
            this.getTugboat();
        }
    },
    mounted: function() {
        this.sync();

        this.chart = echarts.init(document.getElementById('chart'));
        this.chart.setOption({
            title: {
                text: 'RESUME BARGING DAILY',
                subtext: '{{date("Y-m-d")}}',
                x: 'center'
            },
            tooltip: {
                trigger: 'axis'
            },
            grid: {
                left: '3%',
                right: '3%',
                bottom: '10%',
                containLabel: true
            },
            legend: {
                data:['JETTY H', 'JETTY J', 'JETTY K', 'JETTY U'],
                bottom: 'bottom',
            },
            xAxis: {
                type: 'category',
                boundaryGap: true,
                data: [
                    '00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00',
                    '08:00','09:00','10:00','11:00','12:00', '13:00','14:00','15:00',
                    '16:00','17:00','18:00','19:00','20:00', '21:00','22:00','23:00'
                ]
            },
            yAxis: {
                type: 'value'
            },
            series: []
        });

        this.requestDataJetty();
    }
}
</script>

<style lang="css">
</style>
