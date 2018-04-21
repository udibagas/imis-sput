@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-body">
        <form class="pull-right form-inline" action="" method="post" style="margin-bottom:0;">
            <input type="text" name="" value="{{date('Y-m-d')}}" class="form-control" id="period">
        </form>
        <div class="clearfix"> </div>
        <div id="chart" style="height:350px;"> </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#period').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    Highcharts.chart('chart', {
        chart: {
            type: 'spline'
        },
        credits: {
            enabled: false
        },
        title: {
            text: 'ESTIMASI TINGGI AIR (meter)'
        },
        subtitle: {
            text: '{{date("Y-m-d")}}'
        },
        xAxis: {
            categories: [
                '05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00',
                '13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00',
                '21:00','22:00','23:00','00:00','01:00','02:00','03:00','04:00'
            ]
        },
        yAxis: {
            title: {
                text: 'meter'
            },
            labels: {
                formatter: function () {
                    return this.value + 'm';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Estimasi TInggi Air (m)',
            marker: {
                symbol: 'diamond'
            },
            data: [
                7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6,
                7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6
            ]

        }]
    });
</script>
@endpush
