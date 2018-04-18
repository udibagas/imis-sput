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

        $('#fuel-ratio').highcharts({
            title: {
                text: 'FUEL RATIO PERIODE ' + this.period
            },
            xAxis: {
                categories: ['05.00','06.00','07.00','08.00','09.00','10.00','11.00','12.00','13.00','14.00','15.00','16.00','17.00','18.00','19.00','20.00','21.00','22.00','23.00','00.00','01.00','02.00','03.00','04.00'],
                gridLineWidth: 1,
                gridLineDashStyle: 'dot',
                labels: {
                    rotation  : -90,
                    align : 'right'
                }
            },
            yAxis: [{
                title: {
                    text: 'Liter / Tonase'
                } ,
                min: 0,
               // ,max:100
                opposite: true
            } , {
                gridLineWidth: 0,
                min: 0,
                max:6,
                title: {
                    text: 'Duration',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                }
            }

            ],
            legend: {
                align: 'center',
                // x: -20,
                verticalAlign: 'bottom',
                // y: 20,
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
                layout: 'horizontal'
            },
            tooltip: {
                formatter: function() {
                    return  this.series.name +': '+ this.y
                }
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true ,
                        color: "#505150",
                        y: 5,
                        crop: false,
                        overflow: 'none',
                        style: {
                            fontSize: '8px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                line: {
                    dataLabels: {
                        enabled: true  ,
                        color: "#505150",
                        y: -5,
                        crop: false,
                        overflow: 'none',
                        style: {
                            fontSize: '8px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }
            },
            credits: {
                enabled: false
            },
            series:  [{"name":"Fuel Ratio","type":"column","color":"#FFA07A","data":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]},{"name":"Duration","type":"line","yAxis":1,"data":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]}]

        });

        $('#fuel-stock').highcharts({
            credits: {
                enabled: false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'FUEL STOCK'
            },
            xAxis: {
                categories: [
                    @foreach ($fuelTanks as $f)
                    '{{$f->name}} ({{$f->last_stock_time}})',
                    @endforeach
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Stock Fuel dalam Liter'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> L<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Kapasitas',
                // color: 'rgba(165,170,217,1)',
                data: [
                    @foreach ($fuelTanks as $f)
                    {{$f->capacity}},
                    @endforeach
                ],
                pointPadding: 0.12,
                pointPlacement: -0.2
            }, {
                name: 'Stock',
                // color: 'rgba(126,86,134,.9)',
                data: [
                    @foreach ($fuelTanks as $f)
                    {{$f->stock}},
                    @endforeach
                ],
                pointPadding: 0.2,
                pointPlacement: -0.2
            }]
        });
    }
});

</script>
@endpush
