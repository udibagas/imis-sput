<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="text-primary">{{header}}</span>
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>{{entity}}</th>
                    <th style="text-align:right;">Ritase</th>
                    <th style="text-align:right;">Tonase</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="s in summaries">
                    <td>{{s.entity}}</td>
                    <td style="text-align:right;">{{s.ritase | formatNumber}}</td>
                    <td style="text-align:right;">{{s.tonase | formatNumber}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>TOTAL</th>
                    <th style="text-align:right;">{{totalRitase | formatNumber}}</th>
                    <th style="text-align:right;">{{totalTonase | formatNumber}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props: ['header', 'entity', 'group', 'date'],
    data: function() {
        return {
            summaries: [],
            totalRitase: 0,
            totalTonase: 0
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                group_by: this.group,
                date: this.date
            };
            axios.get('stockDumping/summary', {params: params})

            .then(function(r) {
                _this.summaries = r.data;
                _this.totalRitase = 0;
                _this.totalTonase = 0;
                r.data.forEach(function(d) {
                    _this.totalRitase += parseInt(d.ritase);
                    _this.totalTonase += parseInt(d.tonase);
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
