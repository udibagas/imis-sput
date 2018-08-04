<template lang="html">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>{{group}}</th>
                <th v-for="s in jetty.stock_area">{{s.name}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="s in summaries">
                <td>HIGH</td>
                <td v-for="s in jetty.stock_area">100T/12d</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <td v-for="s in jetty.stock_area">200T</td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
export default {
    name: 'StockSummary',
    props: ['stock_area_id'],
    data: function() {
        return {
            summaries: []
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            let params = {
                stock_area_id: _this.stock_area_id
            };

            axios.get('stockArea/stockSummary', {params: params})
                .then(function(r) {
                    _this.summaries = r.data
                })
                .catch(function(error) {
                    console.log(error);
                })
        }
    },
    mounted: function() {
        this.requestData()
    }
}
</script>

<style lang="css">
</style>
