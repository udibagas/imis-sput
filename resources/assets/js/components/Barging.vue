<template>
    <div style="height: 200px;" :id="'barging-'+id" v-model="jetty">
    </div>
</template>

<script>
export default {
    name: 'Barging',
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
            var rand = Math.random() * 1000;
            xData.push(i);
            dataBarging.push(rand.toFixed(2));
        }

        var _this = this;
        var barge = _this.jetty.barge ? _this.jetty.barge.name : '';
        var tugboat = _this.jetty.tugboat ? ' - ' + _this.jetty.tugboat.name : '';

        _this.chart = echarts.init(document.getElementById('barging-' + _this.id));
        _this.chart.setOption({
            title: {
                text: 'JETTY ' + _this.jetty.name,
                subtext: barge + tugboat,
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
            xAxis: {
                type: 'category',
                boundaryGap: true,
                data: xData
            },
            yAxis: {
                type: 'value',
                name: 'TPH'
            },
            series: [
                {
                    type: 'line',
                    data: dataBarging,
                    color: '#722345',
                }
            ]
        });

        // buat bikin efek progress
        setInterval(function() {
            var dataBarging = [];
            var xData = [];

            for (var i = 0; i <= 300; i++) {
                var rand = Math.random() * 1000;
                xData.push(i);
                dataBarging.push(rand.toFixed(2));
            }

            _this.chart.setOption({
                xAxis: {
                    data: xData
                },
                series: [{
                    type: 'line',
                    data: dataBarging,
                }]
            });

        }, 3000);
    }
}
</script>

<style scoped>

</style>
