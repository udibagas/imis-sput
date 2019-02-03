<template>
    <div>
        <form class="form-inline">
            <input type="number" v-model="year" placeholder="Year" class="form-control">
            <select v-model="selectedPeriod" placeholder="Period" class="form-control">
                <option v-for="(p, i) in periodList" :value="i" :key="i">{{p[0] | readableDate }} to {{ p[1] | readableDate}}</option>
            </select>
        </form>
        <div id="chart" style="height:300px;"></div>
    </div>
</template>

<script>
export default {
    // props: ['start', 'end'],
    filters: {
        readableDate(v) { return moment(v).format('DD-MMM-YY')}
    },
    computed: {
        periodList() { return this.getPeriodList(this.year) },
        dates() {
            let period = this.periodList[this.selectedPeriod]
            let start = new Date(period[0])
            let end = new Date(period[1])
            let dates = []

            for (let i = start.getTime(); i <= end.getTime(); i += 86400000) {
                dates.push(moment(new Date(i)).format('DD MMM'));
            }

            return dates
        },
    },
    data() {
        return {
            achievements: [],
            selectedPeriod: 0,
            plans: [],
            chart: null,
            year: moment().format('Y')
        }
    },
    watch: {
        selectedPeriod(v, o) {
            this.getPlan()
            this.getAchievement()
        }
    },
    methods: {
        getAchievement() {
            let params = {
                start: this.periodList[this.selectedPeriod][0],
                end: this.periodList[this.selectedPeriod][1]
            }

            axios.get(BASE_URL + '/bargingPlan/achievement', { params: params }).then(r => {
                this.achievements = []
                this.dates.forEach(d => {
                    this.achievements.push(r.data.filter(p => moment(p.date).format('DD MMM') == d).reduce((t, c) => { return t + c.volume }, 0))
                })
                this.updateChart()
            }).catch(e => {
                console.log(e);
            })
        },
        getPlan() {
            let params = {
                start: this.periodList[this.selectedPeriod][0],
                end: this.periodList[this.selectedPeriod][1]
            }

            axios.get(BASE_URL + '/bargingPlan', { params: params }).then(r => {
                this.plans = []
                this.dates.forEach(d => {
                    this.plans.push(r.data.filter(p => moment(p.date).format('DD MMM') == d).reduce((t, c) => { return t + c.volume }, 0))
                })
                this.updateChart()
            }).catch(e => {
                console.log(e);
            })
        },
        getPeriodList(year) {
            return [
                [year + '-01-01', year + '-01-25'],
                [year + '-01-26', year + '-02-25'],
                [year + '-02-26', year + '-03-25'],
                [year + '-03-26', year + '-04-25'],
                [year + '-04-26', year + '-05-25'],
                [year + '-05-26', year + '-06-25'],
                [year + '-06-26', year + '-07-25'],
                [year + '-07-26', year + '-08-25'],
                [year + '-08-26', year + '-09-25'],
                [year + '-09-26', year + '-10-25'],
                [year + '-10-26', year + '-11-25'],
                [year + '-11-26', year + '-12-31']
            ];
        },
        updateChart() {
            this.chartReport.setOption({
                xAxis: { data: this.dates },
                series: [
                    { name: 'PLAN', data: this.plans },
                    { name: 'ACTUAL', data: this.achievements }
                ]
            });
        }
    },
    mounted() {
        setTimeout(() => {
            this.chartReport = echarts.init(document.getElementById('chart'));
            this.chartReport.setOption({
                title: {
                    text: 'COAL BARGING ACHIEVEMENT',
                    x: 'center'
                },
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
                    left: '3%',
                    right: '3%',
                    bottom: '10%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: true,
                    // TODO : ini tanggal
                    data: this.dates,
                },
                yAxis: {
                    type: 'value',
                    name: 'TON'
                },
                series: [
                    {
                        name: 'PLAN',
                        type: 'line',
                        label: {
                            show: true,
                            position: 'top',
                            formatter: function(v) {
                                return parseFloat(v.value)
                                    .toFixed(0)
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        },
                        data: this.plans,
                        itemStyle: {
                            normal: {color: '#336E9A'}
                        }
                    },
                    {
                        name: 'ACTUAL',
                        type: 'bar',
                        label: {
                            show: true,
                            position: 'top',
                            formatter: function(v) {
                                let r = parseFloat(v.value)
                                    .toFixed(0)
                                    .toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                
                                if (v.value > 0 && this.plans[v.dataIndex] > 0) {
                                    r += ' (' + v.value/this.plans[v.dataIndex] + ')'
                                } else {
                                    r += ' (0%)'
                                }


                                return r 
                            }
                        },
                        data: this.achievements,
                        itemStyle: {
                            normal: {color: '#1D2959'}
                        }
                    }
                ]
            });

            this.getPlan()
            this.getAchievement()

        }, 1000)
    }
}
</script>

<style scoped>

</style>