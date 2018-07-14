<template>
    <div>
        <div class="row">
            <div v-for="j in jetties" class="col-md-3">
                <div :id="'chart-' +j.id" style="height:200px;">
                    chart untuk jetty {{j.name}}
                </div>

                <div :id="'chartStock-' +j.id" style="height:200px;">
                    chartStock untuk jetty {{j.name}}
                </div>

                <div :class="['panel', j.status ? 'panel-success' : 'panel-danger']">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="#" @click.prevent="jettyAction(j)"><i class="icon-cog"></i></a>
                        </div>
                        JETTY {{j.name}}
                    </div>
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Barge/Tugboat</td>
                                <td>
                                    <button v-if="j.barge" type="button" class="btn btn-info" @click="bargeJettyAction(j.barge)">
                                        {{j.barge.name}}
                                    </button>

                                    <button v-if="j.tugboat" type="button" class="btn btn-info">
                                        {{j.tugboat.name}}
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Unit on Location</td>
                                <td>
                                    <button class="btn btn-success" type="button" v-for="u in j.units" style="margin-right:5px;" @click="unitJettyAction(u)">
                                        <i class="fa fa-truck"></i> {{u.name}}
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Barging Progress</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        BARGES
                    </div>
                    <div class="panel-body">
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="b in barges" @click="bargeAction(b)">
                            <i class="fa fa-anchor"></i> {{b.name}}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        TUGBOATS
                    </div>
                    <div class="panel-body">
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="t in tugboats" @click="tugboatAction(t)">
                            <i class="fa fa-ship"></i> {{t.name}}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        WHEEL LOADERS
                    </div>
                    <div class="panel-body">
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="wl in wheelLoaders" @click="unitAction(wl)">
                            <i class="fa fa-truck"></i> {{wl.name}}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        DUMP TRUCKS
                    </div>
                    <div class="panel-body">
                        <button type="button" style="margin:0 5px 5px 0" class="btn btn-info" v-for="dt in dumpTrucks" @click="unitAction(dt)">
                            <i class="fa fa-truck"></i> {{dt.name}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Container, Draggable } from "vue-smooth-dnd";

export default {
    name: "Game",
    components: { Container, Draggable },
    data: function() {
        return {
            charts: [],
            wheelLoaders: [],
            dumpTrucks: [],
            areas: [],
            seams: [],
            barges: [],
            jetties: [],
            tugboats: [],
            customers: [],
            chartStock: []
        }
    },
    methods: {
        bargeAction: function(b) {
            alert(JSON.stringify(b));
        },
        unitAction: function(u) {
            alert(JSON.stringify(u));
        },
        unitJettyAction: function(u) {
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
                _this.wheelLoaders = r.data.filter(u => u.name.toLowerCase().match('wl'));
                _this.dumpTrucks = r.data.filter(u => u.name.toLowerCase().match('ld'));
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
        var _this = this;
        _this.sync();

        setTimeout(function() {
            // untuk chart barging per jetty
            _this.jetties.forEach(function(j) {
                var barge = j.barge ? ' - ' + j.barge.name : '';
                var tugboat = j.tugboat ? ' - ' + j.tugboat.name : '';
                _this.charts[j.id] = echarts.init(document.getElementById('chart-' + j.id));
                _this.charts[j.id].setOption({
                    title: {
                        text: 'JETTY ' + j.name + barge + tugboat,
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
                    xAxis: {
                        type: 'category',
                        boundaryGap: true,
                        // data: [
                        //     '00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00',
                        //     '08:00','09:00','10:00','11:00','12:00', '13:00','14:00','15:00',
                        //     '16:00','17:00','18:00','19:00','20:00', '21:00','22:00','23:00'
                        // ]
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {type: 'line', data: [3,4,5,6,3,4,5,7,4,2,1,8,9,3,4,6,2,7]}
                    ]
                });
            });

            // untuk chart stock
            _this.jetties.forEach(function(j) {
                var stock_area = []
                var dataStock = []

                j.stock_area.forEach(function(s) {
                    stock_area.push(s.name);
                    var rand = Math.random() * 10;
                    dataStock.push(rand.toFixed(2));
                });

                _this.chartStock[j.id] = echarts.init(document.getElementById('chartStock-' + j.id));
                _this.chartStock[j.id].setOption({
                    title: {
                        text: 'STOCK AREA JETTY ' + j.name,
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
                    xAxis: {
                        type: 'category',
                        boundaryGap: true,
                        data: stock_area,
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            type: 'bar',
                            data: dataStock,
                            color: '#722345',
                            label: {
                                show: true,
                                position: 'top',
                                formatter: function(v) {
                                    return v.value + 'T/4d'
                                }
                            }
                        }
                    ]
                });
            });

        }, 1000);
    }
}
</script>

<style lang="css">
</style>
