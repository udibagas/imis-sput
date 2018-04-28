@extends('layouts.app')

@section('content')
<div class="panel panel-primary" id="app">
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

const app = new Vue({
    el: '#app',
    data: {
        chart: null,
    },
    methods: {
        requestData: function() {
            var _this = this;
            axios.get('{{url("jetty/productivity")}}').then(function(r) {
                _this.chart.setOption({series: r.data});
                setTimeout(_this.requestData, 3000);
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

        this.requestData();
    }
});
</script>
@endpush
