<template lang="html">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>UNIT</th>
                <th>SHIFT</th>
                <th>FEEDING</th>
                <th>LOAD AND CARRY</th>
                <th>LOADING</th>
                <th>STOCK PILING</th>
                <th>HAULING</th>
                <th class="info">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="p in productivities">
                <td>{{p.unit}}</td>
                <td>{{p.shift}}</td>
                <td>{{p.feeding | formatNumber}}</td>
                <td>{{p.load_and_carry | formatNumber}}</td>
                <td>{{p.loading | formatNumber}}</td>
                <td>{{p.stock_piling | formatNumber}}</td>
                <td>{{p.hauling | formatNumber}}</td>
                <th class="info">{{p.total | formatNumber}}</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th class="info" colspan="2">TOTAL</th>
                <th class="info">{{totalFeeding | formatNumber}}</th>
                <th class="info">{{totalLoadAndCarry | formatNumber}}</th>
                <th class="info">{{totalLoading | formatNumber}}</th>
                <th class="info">{{totalStockPiling | formatNumber}}</th>
                <th class="info">{{totalHauling | formatNumber}}</th>
                <th class="info">{{totalTotal | formatNumber}}</th>
            </tr>
        </tfoot>
    </table>
</template>

<script>
export default {
    props: ['from', 'to'],
    data: function() {
        return {
            productivities: [],
            totalLoading: 0,
            totalLoadAndCarry: 0,
            totalFeeding: 0,
            totalHauling: 0,
            totalStockPiling: 0,
            totalTotal: 0
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            let params = {
                from: this.from,
                to: this.to,
            }
            axios.get('portActivity/productivity', {params: params}).then(function(r) {
                _this.productivities = r.data
                _this.totalLoading = 0
                _this.totalLoadAndCarry = 0
                _this.totalFeeding = 0
                _this.totalHauling = 0
                _this.totalStockPiling = 0
                _this.totalTotal = 0

                r.data.forEach(function(d) {
                    _this.totalLoading += parseInt(d.loading)
                    _this.totalLoadAndCarry += parseInt(d.load_and_carry)
                    _this.totalFeeding += parseInt(d.feeding)
                    _this.totalHauling += parseInt(d.hauling)
                    _this.totalStockPiling += parseInt(d.stock_piling)
                    _this.totalTotal += parseInt(d.total)
                })

            }).catch(function(error) {
                console.log(error);
            });

            setTimeout(this.requestData, 3000);
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
    th, td {
        vertical-align: middle;
        text-align: center;
    }
</style>
