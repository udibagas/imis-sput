@extends('layouts.app')

@section('content')
<div id="app">
    <div class="panel panel-primary">
        <!-- <div class="panel-heading">
        <h3 class="panel-title">FUEL RATIO</h3>
        <div class="clearfix"> </div>
        </div> -->
        <div class="panel-body">
            <form class="form-inline pull-right" action="" method="get" style="margin-bottom:0;">
                <input type="text" v-model="period" class="form-control" placeholder="Periode" id="period">
                <button type="button" name="button" class="btn btn-primary" v-on:click="filter"><i class="icon icon-search"></i></button>
            </form>
            <div class="clearfix"> </div>
            <div class="" id="fuel-ratio" style="height:320px;">

            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-primary">
                <!-- <div class="panel-heading">
                <h3 class="panel-title">FUEL STOCK</h3>
                <div class="clearfix"> </div>
            </div> -->
            <div class="panel-body">
                <div class="" id="fuel-stock" style="height:300px;">

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary" style="height:330px;overflow:auto;">
            <div class="panel-heading">
                <h3 class="panel-title">FUEL CONSUMPTION</h3>
                <div class="clearfix"> </div>
            </div>
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
@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        period: '{{date('Y-m-d')}}'
    },
    // watch: {
    //     period: function(val) {
    //         alert(val);
    //     }
    // },
    methods: {
        filter: function() {
            // todo, refresh chart
            alert(this.period);
        }
    },
    mounted: function() {
        $('#period').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        var chart1 = echarts.init(document.getElementById('fuel-ratio'));
        chart1.setOption({
            title: {
                text: 'FUEL RATIO PERIODE ' + this.period
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
                axisPointer: {
                    type: 'shadow'
                }
                data: [
                    '05.00','06.00','07.00','08.00','09.00','10.00','11.00','12.00',
                    '13.00','14.00','15.00','16.00','17.00','18.00','19.00','20.00',
                    '21.00','22.00','23.00','00.00','01.00','02.00','03.00','04.00'
                ],
            },
            yAxis: [{
                type: 'value',
                name: 'AA',
                axisLabel: {
                    formatter: '{value} °C'
                }
            }, {
                type: 'value',
                name: 'BB'
            }],
            series: [
                {name: 'ss', type: 'line', yAxisIndex: 1, data: []}
            ]
        });

        var chart2 = echarts.init(document.getElementById('fuel-stock'));
        chart2.setOption({
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
                type: 'value'
            },
            series: []
        });

        labelOption = {
            show: true,
            position: 'top'
        };

        var requestData = function() {
            $.getJSON('{{url("fuelTank/dashboard")}}', function(r) {

                var dataCapacity = [];
                var dataStock = [];

                for (i in r) {
                    dataCapacity.push(r[i].capacity);
                    dataStock.push(r[i].stock);
                }

                chart2.setOption({
                    series: [{
                        name: 'CAPACITY',
                        type: 'bar',
                        barGap: 0,
                        label: labelOption,
                        data: dataCapacity
                    }, {
                        name: 'STOCK',
                        type: 'bar',
                        barGap: 0,
                        label: labelOption,
                        data: dataStock
                    }]
                });
                setTimeout(requestData, 3000);
            });
        };

        requestData();
    }
});

</script>
@endpush
