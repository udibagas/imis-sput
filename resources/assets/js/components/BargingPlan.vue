<template>
    <div style="clear:both;">
        <hr>
        <form class="form-inline">
            <input type="number" v-model="year" placeholder="Year" class="form-control">
            <select v-model="selectedPeriod" placeholder="Period" class="form-control">
                <option v-for="(p, i) in periodList" :value="i" :key="i">{{p[0] | readableDate }} to {{ p[1] | readableDate}}</option>
            </select>
            <button class="btn btn-primary" @click.prevent="saveData">SAVE</button>
        </form>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th style="width:100px;">Tanggal</th>
                    <th v-for="c in contractors" :key="c.id">{{c.name}}</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(d, i) in dates" :key="i">
                    <td>{{d | readableDate}}</td>
                    <td v-for="c in contractors" :key="c.id">
                        <input v-model="formPlans[d][c.id]" class="form-control">
                    </td>
                    <td class="text-center">
                        <strong>{{ plans.filter(p => p.date == d).reduce((t, c) => { return t + c.volume }, 0) }}</strong>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td class="text-center" v-for="c in contractors" :key="c.id">
                        <strong>{{ plans.filter(p => p.contractor_id == c.id).reduce((t, c) => { return t + c.volume }, 0) }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ plans.reduce((t, c) => { return t + c.volume }, 0) }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    filters: {
        readableDate(v) { return moment(v).format('DD-MMM-YY')}
    },
    computed: {
        periodList() { return this.getPeriodList(this.year) },
        // looping dates dari selected period
        dates() {
            let period = this.periodList[this.selectedPeriod]
            let start = new Date(period[0])
            let end = new Date(period[1])
            let dates = []

            for (let i = start.getTime(); i <= end.getTime(); i += 86400000) {
                dates.push(moment(new Date(i)).format('YYYY-MM-DD'));
            }

            return dates
        },
        formPlans() {
            let formPlans = []
            this.dates.forEach(d => {
                formPlans[d] = []
                this.contractors.forEach(c => {
                    let plan = this.plans.find(p => p.contractor_id === c.id && p.date === d)
                    formPlans[d][c.id] = plan ? plan.volume : 0
                });
            })

            return formPlans
        }
    },
    watch: {
        selectedPeriod(v, o) {
            this.requestData()
        }
    },
    data() {
        return {
            plans: [],
            contractors: [],
            year: moment().format('YYYY'),
            selectedPeriod: 0
        }
    },
    methods: {
        saveData() {
            let period = this.periodList[this.selectedPeriod]
            let plans = []
            
            this.dates.forEach(d => {
                plans.push({
                    date: d,
                    plans: this.formPlans[d]
                })
            })

            let params = {
                plans: plans,
                start: period[0],
                end: period[1]
            };

            // console.log(plans)

            axios.post(BASE_URL + '/bargingPlan', params).then(r => {
                this.plans = r.data
            }).catch(e => console.log(e))
        },
        getContractor() { 
            axios.get(BASE_URL + '/api/contractor')
                .then(r => this.contractors = r.data)
                .catch(e => console.log(e))
        },
        requestData() {
            let params = { 
                start: this.periodList[this.selectedPeriod][0],
                end: this.periodList[this.selectedPeriod][1],
            }

            axios.get(BASE_URL + '/bargingPlan', { params: params })
                .then(r => this.plans = r.data)
                .catch(e => console.log(e))
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
        }
    },
    mounted() {
        this.getContractor()
        this.requestData()
    }
}
</script>

<style scoped>

</style>