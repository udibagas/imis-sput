@extends('layouts.app')

@section('content')
<div id="app">
    <div class="panel panel-primary">
        <div class="panel-body">
            <form class="form-inline pull-right" action="" method="get" style="margin-bottom:0;">
                <input type="text" v-model="period" class="form-control" placeholder="Periode" id="period">
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">FUEL CONSUMPTION</h3>
                    <div class="clearfix"> </div>
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
                            @foreach ($egi as $e)
                            <tr>
                                <td>{{$e->name}}</td>
                                <td>{{''}}</td>
                                <td>{{''}}</td>
                            </tr>
                            @endforeach
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
        period: '{{date('Y-m-d')}}',
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
        requestDataRatio: function() {
            var _this = this;
            axios.get('{{url("fuelTank/ratio")}}').then(function(r) {
                _this.chartRatio.setOption({series: r.data});
                setTimeout(_this.requestDataRatio, 3000);
            })

            .catch(function(error) {
                if (error.response.status == 500) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                }
            });
        },
        requestDataFuelStok: function() {
            var _this = this;
            axios.get('{{url("fuelTank/dashboard")}}').then(function(r) {
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
                setTimeout(_this.requestDataFuelStok, 3000);
            })

            .catch(function(error) {
                if (error.response.status == 500) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                }
            });
        },
        requestDataFuelConsumption: function() {
            axios.get('{{url('')}}').then(function(r) {

            })

            .catch(function(error) {
                if (error.response.status == 500) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                }
            });
        }
    },
    mounted: function() {
        $('#period').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

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
                data:[@foreach ($fuelTanks as $f) '{{$f->name}}', @endforeach],
            },
            yAxis: {
                type: 'value',
                name: 'LITER'
            },
            series: []
        });

        this.requestDataRatio();
        this.requestDataFuelStok();
    }
});

</script>
@endpush
