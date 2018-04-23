@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-body">
        <form class="pull-right form-inline" action="" method="post" style="margin-bottom:0;">
            <input type="text" name="" value="{{date('Y-m-d')}}" class="form-control" id="period">
        </form>
        <div class="clearfix"> </div>
        <div id="chart" style="height:500px;"> </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

    $('#period').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    var chart = echarts.init(document.getElementById('chart'));
    chart.setOption({
        title: {
            text: 'ESTIMASI TINGGI AIR (meter)',
            subtext: '{{date("Y-m-d")}}',
            x: 'center'
        },
        xAxis: {
            type: 'category',
            boundaryGap: true,
            data: [
                '05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00',
                '13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00',
                '21:00','22:00','23:00','00:00','01:00','02:00','03:00','04:00'
            ]
        },
        yAxis: {
            type: 'value'
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
        series: [{
            name: 'Estimasi TInggi Air (meter)',
            type: 'line',
            color: '#00B8CE',
            label: {
                show: true,
                position: 'top'
            },
            data: [
                4.8, 4.7, 4.5, 4.3, 4.2, 3.9, 3.9, 3.8, 3.7, 3.65, 3.6, 3.6,
                3.5, 3.5, 3.6, 3.6, 3.8, 4, 4.1, 4.2, 4.2, 4.3, 4.5, 4.7
            ]

        }]
    });

    // var requestData = function() {
    //     $.getJSON('{{url("jetty/productivity")}}', function(r) {
    //         chart.setOption({series: r});
    //         setTimeout(requestData, 3000);
    //     });
    // };
    //
    // requestData();

</script>
@endpush
