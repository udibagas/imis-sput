<template>
    <div style="height: 150px;" :id="'barging-progress-'+id" v-model="jetty">
    </div>
</template>

<script>
export default {
    name: 'BargingProgress',
    props: ['id', 'jetty'],
    data: function() {
        return {
            chart: null
        }
    },
    methods: {

    },
    mounted: function() {
        var dataBarging = [];
        var xData = [];

        for (var i = 0; i <= 300; i++) {
            var rand = Math.random() * 10;
            xData.push(i);
            dataBarging.push(rand.toFixed(2));
        }

        var _this = this;
        var barge = _this.jetty.barge ? _this.jetty.barge.name : '';
        var tugboat = _this.jetty.tugboat ? ' - ' + _this.jetty.tugboat.name : '';

        _this.chart = echarts.init(document.getElementById('barging-progress-' + _this.id));
        _this.chart.setOption({
            title: {
                text: '80%',
                x: 'center',
                y: 'center',
                textStyle: {
                    fontWeight: 'normal',
                    color: '#722345',
                    fontSize: '20'
                }
            },
            color: ['rgba(176, 212, 251, 1)'],
            // legend: {
            //     show: true,
            //     itemGap: 12,
            //     data: ['01', '02']
            // },

            series: [{
                name: 'Line 1',
                type: 'pie',
                clockWise: true,
                radius: ['50%', '66%'],
                itemStyle: {
                    normal: {
                        label: {
                            show: false
                        },
                        labelLine: {
                            show: false
                        }
                    }
                },
                hoverAnimation: false,
                data: [{
                    value: 80,
                    name: '01',
                    itemStyle: {
                        normal: {
                            color: {
                                colorStops: [{
                                    offset: 0,
                                    color: '#00cefc'
                                }, {
                                    offset: 1,
                                    color: '#367bec'
                                }]
                            },
                            label: {
                                show: false
                            },
                            labelLine: {
                                show: false
                            }
                        }
                    }
                }, {
                    name: '02',
                    value: 20
                }]
            }]
        });
    }
}
</script>

<style scoped>

</style>
