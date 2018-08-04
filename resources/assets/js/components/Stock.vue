<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <div style="height: 200px;" :id="'stock-'+id" v-model="jetty"> </div>
        </div>
    </div>
</template>

<script>
import StockSummary from "./StockSummary"

export default {
    name: 'Stock',
    props: ['id', 'jetty'],
    data: function() {
        return {
            chart: null
        }
    },
    methods: {

    },
    mounted: function() {
        var stock_area = [];
        var dataStock = [];
        var dataCapacity = [];
        var dataAge = [];

        this.jetty.stock_area.forEach(function(s) {
            stock_area.push(s.name);
            dataStock.push(s.stock);
            dataCapacity.push(s.capacity);
            dataAge.push(s.age);
        });

        var _this = this;

        _this.chart = echarts.init(document.getElementById('stock-' + _this.id));
        _this.chart.setOption({
            title: {
                text: 'STOCK AREA JETTY ' + _this.jetty.name,
                x: 'center'
            },
            tooltip: {
                trigger: 'axis'
            },
            // legend: {
            //     enabled: true,
            //     data:['CAPACITY', 'STOCK'],
            //     bottom: 'bottom',
            // },
            grid: {
                left: '10%',
                right: '0%',
                bottom: '10%',
                // containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: true,
                data: stock_area,
            },
            yAxis: {
                type: 'value',
                name: 'TON'
            },
            series: [
                {
                    name: 'CAPACITY',
                    type: 'bar',
                    barGap: '-90%',
                    barWidth: '80%',
                    color: '#722345',
                    data: dataCapacity,
                    itemStyle: {
                       opacity: 0.5
                   },
                    label: {
                        show: true,
                        position: 'top',
                    }
                },
                {
                    name: 'STOCK',
                    type: 'bar',
                    data: dataStock,
                    barWidth: '65%',
                    color: '#722345',
                    label: {
                        show: true,
                        color: '#fff',
                        formatter: function(v) {
                            return v.value;
                        }
                    },
                }
            ]
        });
    }
}
</script>

<style scoped>

</style>
