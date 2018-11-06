@extends('layouts.app')

@section('content')
<div id="app">
    <div class="panel panel-primary">
        <div class="panel-body">
            <form class="form-inline pull-right" action="" method="get" style="margin-bottom:0;">
                <vue-datepicker v-model="date" placeholder="Date">
                </vue-datepicker>
            </form>
            <div class="clearfix"> </div>
            <div class="" id="fuel-ratio" style="height:320px;">

            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-7">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="" id="fuel-stock" style="height:300px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="text-primary">FUEL CONSUMPTION</span>
                    <div class="pull-right">
                        Date : @{{date}}
                    </div>
                </div>
                <div style="height:285px;overflow:auto;">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>EGI</th>
                                <th class="text-center">FC STANDARD</th>
                                <th class="text-center">FC TODAY</th>
                                <th class="text-center">FC MONTH TO DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="f in fuelConsumptions">
                                <td>@{{f.egi}}</td>
                                <td class="text-center">@{{f.fc_standard | toInt}}</td>
                                <td class="text-center">@{{f.fc | toFixed}}</td>
                                <td class="text-center">@{{f.fc_month | toFixed}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$('.page-container').addClass('sidebar-collapsed');

const app = new Vue({
    el: '#app',
    data: {
        chartRatio: null,
        chartStock: null,
        date: '{{date("Y-m-d")}}',
        fuelConsumptions: [],
        labelOption: {
            show: true,
            position: 'top',
            formatter: function(v) {
                return parseFloat(v.value)
                    .toFixed(0)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }
    },
    filters: {
        toFixed: function(v) {
            return parseFloat(v).toFixed(2);
        },
        toInt: function(v) {
            return parseFloat(v).toFixed(0);
        }
    },
    methods: {
        requestDataFuelRatio: function() {
            var _this = this;
            axios.get('{{url("sm/fuelRatio")}}', {params: {date:_this.date}}).then(function(r) {
                _this.chartRatio.setOption({
                    title: {
                        subtext: 'Periode: ' + _this.date,
                    },
                    series: [
                        {
                            type: 'bar',
                            name: 'Fuel Ratio',
                            label: {
                                show: true,
                                position: 'top',
                                formatter: function(v) {
                                    return parseFloat(v.value)
                                        .toFixed(2)
                                        .toString()
                                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            },
                            data: r.data
                        }
                    ]
                });
            })

            .catch(function(error) {
                if (error.response.status == 500) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                }
            });

            setTimeout(_this.requestDataFuelRatio, 3000);
        },
        requestDataFuelStock: function() {
            var _this = this;
            axios.get('{{url("sm/fuelStock")}}').then(function(r) {
                var dataCapacity = [];
                var dataStock = [];

                r.data.forEach(function(d) {
                    dataCapacity.push(d.capacity);
                    dataStock.push(d.stock);
                });

                _this.chartStock.setOption({
                    series: [{
                        name: 'CAPACITY',
                        type: 'bar',
                        barGap: '-90%',
                        barWidth: '50%',
                        label: _this.labelOption,
                        data: dataCapacity,
                        // itemStyle: {
                        //     normal: {color: '#334B5C'}
                        // }
                    }, {
                        name: 'STOCK',
                        type: 'bar',
                        barWidth: '40%',
                        label: {
                            show: true,
                            color: '#000',
                            formatter: function(v) {
                                return parseFloat(v.value)
                                    .toFixed(0)
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        },
                        data: dataStock,
                        itemStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(
                                    0, 0, 0, 1, [{
                                            offset: 0,
                                            color: '#00feff'
                                        },
                                        {
                                            offset: 0.5,
                                            color: '#027eff'
                                        },
                                        {
                                            offset: 1,
                                            color: '#0286ff'
                                        }
                                    ]
                                )
                            }
                        },
                    }]
                });

                setTimeout(_this.requestDataFuelStock, 3000);
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });
        },
        requestDataFuelConsumption: function() {
            var _this = this;
            axios.get('{{url("sm/fuelConsumption")}}', {params:{date:_this.date}}).then(function(r) {
                _this.fuelConsumptions = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });

            setTimeout(_this.requestDataFuelConsumption, 3000);
        }
    },
    mounted: function() {
        var _this = this;
        setTimeout(function() {
            _this.chartRatio = echarts.init(document.getElementById('fuel-ratio'));
            _this.chartRatio.setOption({
                title: {
                    text: 'FUEL RATIO',
                    subtext: 'Periode: ' + _this.date,
                    x: 'center'
                },
                grid: {
                    left: '3%',
                    right: '3%',
                    bottom: '10%',
                    containLabel: true
                },
                // legend: {
                //     enabled: false,
                //     data:['Fuel Ratio'],
                //     bottom: 'bottom',
                // },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: '#999'
                        }
                    }
                },
                xAxis: {
                    type: 'category',
                    data: [
                        '07.00','08.00','09.00','10.00','11.00','12.00',
                        '13.00','14.00','15.00','16.00','17.00','18.00','19.00','20.00',
                        '21.00','22.00','23.00','00.00','01.00','02.00','03.00','04.00', '05.00','06.00'
                    ],
                },
                yAxis: [{
                    type: 'value',
                    name: 'LITER/TONASE',
                    // min: 0,
                    // max: 5,
                    // interval: 1,
                }],
                series: []
            });

            _this.chartStock = echarts.init(document.getElementById('fuel-stock'));
            _this.chartStock.setOption({
                title: {
                    text: 'FUEL STOCK',
                    // subtext: '{{date("Y-m-d")}}',
                    x: 'center'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    enabled: true,
                    data:['CAPACITY', 'STOCK'],
                    bottom: 'bottom',
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
                    data:{!! App\FuelTank::orderBy('name', 'ASC')->pluck('name') !!},
                },
                yAxis: {
                    type: 'value',
                    name: 'LITER'
                },
                series: []
            });

            _this.requestDataFuelRatio();
            _this.requestDataFuelStock();
            _this.requestDataFuelConsumption();

        }, 1000);
    }
});

</script>
@endpush
