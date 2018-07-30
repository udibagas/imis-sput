<template>
    <div id="stock-dumping-chart1" style="height:250px;margin-bottom:15px;"> </div>
</template>

<script>

export default {
    props: ['range'],
    data: function() {
        return {
            chart: null,
            ritase: 0,
            tonase: 0
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            let params = {
                from: _this.range[0],
                to: _this.range[1],
            };

            axios.get('stockDumping/chart', {params: params}).then(function(r) {
                let xAxis = [];
                let dataRitase = [];
                let dataTonase = [];
                _this.tonase = 0;
                _this.ritase = 0;

                r.data.forEach(function(d) {
                    xAxis.push(d.date);
                    dataRitase.push(d.ritase);
                    dataTonase.push(parseInt(d.tonase));
                    _this.ritase += d.ritase;
                    _this.tonase += parseInt(d.tonase);
                });

                _this.chart.setOption({
                    xAxis: { data: xAxis },
                    series: [
                        {name: 'RITASE', type: 'line', yAxisIndex: 1, data: dataRitase},
                        {name: 'TONASE', type: 'bar', data: dataTonase},
                    ]
                });

                setTimeout(_this.requestData, 3000);
            })

            .catch(function(error) {
                console.log(JSON.stringify(error));
            });
        },
        initChart: function() {
            let _this = this;
            _this.chart = echarts.init(document.getElementById('stock-dumping-chart1'));
            _this.chart.setOption({
                // title: {
                //     text: _this.from + ' to ' + _this.to,
                //     x: 'center'
                // },
                grid: {
                    left: '1%',
                    right: '1%',
                    bottom: '10%',
                    containLabel: true
                },
                legend: {
                    enabled: true,
                    data:['TONASE', 'RITASE'],
                    bottom: 'bottom',
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        crossStyle: {
                            color: '#999'
                        }
                    }
                },
                xAxis: {
                    type: 'category',
                    data: [],
                },
                yAxis: [{
                    type: 'value',
                    name: 'TONASE',
                    // min: 0,
                    // max: 50000,
                    // interval: 10000,
                    axisLabel: {
                        formatter: '{value}'
                    }
                }, {
                    type: 'value',
                    name: 'RITASE',
                    // min: 0,
                    // max: 100,
                    // interval: 20,
                }],
                series: []
            });
        }
    },
    mounted: function() {
        this.initChart();
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
</style>
