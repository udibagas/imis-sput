@extends('layouts.app')

@section('content')
<div id="app">
    <div class="panel panel-primary">
        <div class="panel-body">
            <form class="form-inline pull-right" action="" method="get" style="margin-bottom:0;">
                <vue-datepicker v-model="period" placeholder="Periode">
                </vue-datepicker>
                <button type="button" name="button" class="btn btn-primary"><i class="icon icon-search"></i></button>
            </form>
            <div class="clearfix"> </div>
            <div class="" id="fuel-ratio" style="height:320px;">

            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="" id="fuel-stock" style="height:300px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="text-primary">FUEL CONSUMPTION</span>
                </div>
                <div class="panel-body" style="height:285px;overflow:auto;">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>EGI</th>
                                <th>FC Today</th>
                                <th>FC Month to Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="f in fuelConsumptions">
                                <td>@{{f.egi}}</td>
                                <td>@{{(f.total_real/f.total_hm).toFixed(2)}}</td>
                                <td>@{{f.total_hm}}</td>
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

const app = new Vue({
    el: '#app',
    data: {
        chartRatio: null,
        chartStock: null,
        period: '{{date("Y-m-d")}}',
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
    methods: {
        requestDataFuelRatio: function() {
            var _this = this;
            axios.get('{{url("sm/fuelRatio")}}').then(function(r) {
                _this.chartRatio.setOption({series: r.data});
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

                for (i in r.data) {
                    dataCapacity.push(r.data[i].capacity);
                    dataStock.push(r.data[i].stock);
                }

                _this.chartStock.setOption({
                    series: [{
                        name: 'CAPACITY',
                        type: 'bar',
                        barGap: 0,
                        label: _this.labelOption,
                        data: dataCapacity
                    }, {
                        name: 'STOCK',
                        type: 'bar',
                        barGap: 0,
                        label: _this.labelOption,
                        data: dataStock
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
            axios.get('{{url("sm/fuelConsumption")}}').then(function(r) {
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

        this.chartRatio = echarts.init(document.getElementById('fuel-ratio'));
        this.chartRatio.setOption({
            title: {
                text: 'FUEL RATIO',
                subtext: 'Periode: ' + this.period,
                x: 'center'
            },
            grid: {
                left: '3%',
                right: '3%',
                bottom: '10%',
                containLabel: true
            },
            legend: {
                enabled: true,
                data:['Fuel Ratio', 'Duration'],
                bottom: 'bottom',
            },
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
                    '05.00','06.00','07.00','08.00','09.00','10.00','11.00','12.00',
                    '13.00','14.00','15.00','16.00','17.00','18.00','19.00','20.00',
                    '21.00','22.00','23.00','00.00','01.00','02.00','03.00','04.00'
                ],
            },
            yAxis: [{
                type: 'value',
                name: 'DURATION',
                min: 0,
                max: 10,
                interval: 2,
                axisLabel: {
                    formatter: '{value}'
                }
            }, {
                type: 'value',
                name: 'LITER/TONASE',
                min: 0,
                max: 5,
                interval: 1,
            }],
            series: []
        });

        this.chartStock = echarts.init(document.getElementById('fuel-stock'));
        this.chartStock.setOption({
            title: {
                text: 'FUEL STOCK',
                subtext: '{{date("Y-m-d")}}',
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

        this.requestDataFuelRatio();
        this.requestDataFuelStock();
        this.requestDataFuelConsumption();
    }
});

</script>
@endpush
