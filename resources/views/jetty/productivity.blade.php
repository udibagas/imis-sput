@extends('layouts.app')

@section('content')
<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <form class="pull-right form-inline" action="" method="post" style="margin-bottom:0;">
            <vue-datepicker v-model="date" placeholder="Date">
            </vue-datepicker>
        </form>
        <div class="clearfix"> </div>
        @foreach ($jetties as $j)
        <div id="chart-{{$j->id}}" style="height:190px;"> </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$('.page-container').addClass('sidebar-collapsed');

const app = new Vue({
    el: '#app',
    data: {
        date: '{{date("Y-m-d")}}',
        chart: [],
    },
    methods: {
        requestData: function(id) {
            var _this = this;
            axios.get('{{url("jetty/productivity")}}?id=' + id).then(function(r) {
                _this.chart[id].setOption({series: r.data});
                setTimeout(function() {
                    _this.requestData(id);
                }, 3000);
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
        var _this = this;
        setTimeout(function() {
            @foreach ($jetties as $j)
            _this.chart[{{$j->id}}] = echarts.init(document.getElementById('chart-{{$j->id}}'));
            _this.chart[{{$j->id}}].setOption({
                title: {
                    text: 'JETTY {{$j->name}}',
                    // subtext: '{{date("Y-m-d")}}',
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
                // legend: {
                //     data:['JETTY H', 'JETTY J', 'JETTY K', 'JETTY U'],
                //     bottom: 'bottom',
                // },
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

            _this.requestData({{$j->id}});
            @endforeach
        }, 1000);

    }
});
</script>
@endpush
