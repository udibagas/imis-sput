@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ANCHORED BARGE</h3>
                <div class="clearfix">

                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item" v-for="b in barges">
                    <span class="pull-right text-muted">@{{b.updated_at}}</span>
                    <h3 style="margin-bottom:0;">@{{b.name}}</h3>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-body">
                <form class="pull-right form-inline" action="" method="post" style="margin-bottom:0;">
                    <input type="text" name="" value="{{date('Y-m-d')}}" class="form-control" id="period">
                </form>
                <div class="clearfix"> </div>
                <div id="chart" style="height:410px;"> </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

    $('#period').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    const app = new Vue({
        el: '#app',
        data: {
            chart: null,
            barges: []
        },
        methods: {
            getAnchoredBarges: function() {
                var _this = this;
                axios.get('{{url("barge/getAnchored")}}').then(function(r) {
                    _this.barges = r.data;
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });

                // recusrive
                setTimeout(this.getAnchoredBarges, 3000);
            },
            geBaseSurfaceData: function() {
                axios.get('{{url("baseSurface")}}').then(function(r) {
                    // parsing ke grafik
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });

                setTimeout(this.geBaseSurfaceData, 60000);
            },
            geTransSurfaceData: function() {
                axios.get('{{url("baseSurface")}}').then(function(r) {
                    // parsing ke grafik
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });

                setTimeout(this.geTransSurfaceData, 60000);
            },
        },
        mounted: function() {
            var _this = this;
            _this.getAnchoredBarges();
            _this.chart = echarts.init(document.getElementById('chart'));
            _this.chart.setOption({
                title: {
                    text: 'ESTIMASI TINGGI AIR (meter)',
                    // subtext: '{{date("Y-m-d")}}',
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
                    name: 'SUNGAI PUTING',
                    type: 'line',
                    color: '#00B8FF',
                    areaStyle: {
                        normal: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                offset: 0,
                                color: '#00B8FF'
                            }, {
                                offset: 1,
                                color: '#ffe'
                            }])
                        }
                    },
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

            $(window).on('resize', function(){
                if(_this.chart != null && _this.chart != undefined){
                    _this.chart.resize();
                }
            });

        }
    });

</script>
@endpush
