<template>
    <div id="water-level-chart" style="height:300px;">

    </div>
</template>

<script>
export default {
    data: function() {
        return {
            chart: null
        }
    },
    methods: {

    },
    mounted: function() {
        var _this = this;
        _this.chart = echarts.init(document.getElementById('water-level-chart'));
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
    }
}
</script>

<style scoped>
</style>
