<template>
    <div class="panel panel-primary">
        <div class="panel-heading">
            BARGING PROGRESS BY BUCKET CONTROL
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Contractor</th>
                    <th>Material Type</th>
                    <th>Seam</th>
                    <th>Target Barging (TON)</th>
                    <th>Progress (TON)</th>
                    <th>%</th>
                    <th>Draught Survey (TON)</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in progress">
                    <td>{{p.contractor}}</td>
                    <td>{{p.material_type == 'l' ? 'LOW' : 'HIGH'}}</td>
                    <td>{{p.seam}}</td>
                    <td>{{p.volume}}</td>
                    <td>{{p.volume_progress}}</td>
                    <td>{{(p.volume_progress/p.volume).toFixed(2) * 100}}%</td>
                    <td>{{p.volume_by_draught_survey}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['jetty'],
    data: function() {
        return {
            progress: []
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                jetty_id: _this.jetty
            };

            axios.get(BASE_URL + '/bargingMaterial', {params:params})
                .then(function(r) {
                    _this.progress = r.data;
                })
                .catch(function(e) {
                    console.log(e);
                });

            setTimeout(this.requestData, 3000);
        }
    },
    mounted: function() {
        setTimeout(this.requestData, 200);
    }
}
</script>

<style lang="css" scoped>
th, td {
    text-align: center;
}
</style>
