<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="text-primary">{{header}}</span>
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>{{entity}}</th>
                    <th style="text-align:right;">Stock (KG)</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="s in summaries">
                    <td>{{s.entity}}</td>
                    <td style="text-align:right;">{{s.volume | formatNumber}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>TOTAL</th>
                    <th style="text-align:right;">{{totalVolume | formatNumber}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props: ['header', 'entity', 'group', 'customer'],
    data: function() {
        return {
            summaries: [],
            totalVolume: 0
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                group_by: this.group,
                customer_id: this.customer
            };
            axios.get('materialStock/summary', {params: params})

            .then(function(r) {
                _this.summaries = r.data;
                _this.totalVolume = 0;
                r.data.forEach(function(d) {
                    _this.totalVolume += parseInt(d.volume);
                });
                setTimeout(_this.requestData, 3000);
            })

            .catch(function(error) {
                console.log(JSON.stringify(error));
            });
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style scoped>
</style>
