@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-body">
        <form class="pull-right form-inline" action="" method="post" style="margin-bottom:0;">
            <input type="text" name="" value="{{date('Y-m-d')}}" class="form-control" id="period">
        </form>
        <div class="clearfix"> </div>
        <h2 class="text-center">
            RESUME BARGING DAILY PER CUSTOMER <br>
            <small>{{date('Y-m-d')}}</small>
        </h2>

        <hr>

        <div class="row col-with-divider text-primary">
			<div class="col-xs-3 text-center stack-order">
				<h1 class="no-margins">90%</h1>
				<strong>PT. BRE - KPP</strong>
			</div>
			<div class="col-xs-3 text-center stack-order">
				<h1 class="no-margins">70%</h1>
				<strong>PT. BRE - HRS</strong>
			</div>
			<div class="col-xs-3 text-center stack-order">
				<h1 class="no-margins">97%</h1>
				<strong>PT. KPP - SALE</strong>
			</div>
			<div class="col-xs-3 text-center stack-order">
				<h1 class="no-margins">108%</h1>
				<strong>PT. PAMA</strong>
			</div>
		</div>
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
        // title: {
        //     text: 'RESUME BARGING DAILY PER CUSTOMER',
        //     subtext: '{{date("Y-m-d")}}',
        //     x: 'center'
        // },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            enabled: true,
            data:['PLAN', 'ACTUAL'],
            bottom: 'bottom',
        },
        grid: {
            left: '0%',
            right: '0%',
            bottom: '10%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            boundaryGap: true,
            data:['PT. BRE - KPP','PT. BRE - HRS', 'PT. KPP - SALE', 'PT. PAMA'],
        },
        yAxis: {
            type: 'value'
        },
        series: []
    });

    var requestData = function() {
        $.getJSON('{{url("barge/resume")}}', function(r) {
            chart.setOption({series: r});
            setTimeout(requestData, 3000);
        });
    };

    requestData();

</script>
@endpush
