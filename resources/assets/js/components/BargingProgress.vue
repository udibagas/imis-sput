<template>
    <div class="panel panel-primary">
        <div class="panel-heading">
            {{title}}
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align:middle;">Contractor</th>
                    <th rowspan="2" style="vertical-align:middle;">Material Type</th>
                    <th rowspan="2" style="vertical-align:middle;">Seam</th>
                    <th rowspan="2" style="vertical-align:middle;">Target Barging (TON)</th>
                    <th colspan="2">Progress</th>
                    <th colspan="2">Draught Survey</th>
                </tr>
                <tr>
                    <th>VOLUME (TON)</th>
                    <th>%</th>
                    <th>VOLUME (TON)</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in progress">
                    <td>{{p.contractor}}</td>
                    <td>{{p.material_type == 'l' ? 'LOW' : 'HIGH'}}</td>
                    <td>{{p.seam}}</td>
                    <td>{{p.volume | formatNumber}}</td>
                    <td>{{p.volume_progress | formatNumber}}</td>
                    <td>{{(p.volume_progress/p.volume).toFixed(4) * 100}}%</td>
                    <td>{{p.volume_by_draught_survey | formatNumber}}</td>
                    <td>{{(p.volume_by_draught_survey/p.volume).toFixed(4) * 100}}%</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" colspan="3">TOTAL</th>
                    <th>{{totalVolume | formatNumber}}</th>
                    <th>{{totalProgress | formatNumber}}</th>
                    <td>{{(totalProgress/totalVolume).toFixed(4) * 100}}%</td>
                    <th>{{totalDraughtSurvey | formatNumber}}</th>
                    <td>{{(totalDraughtSurvey/totalVolume).toFixed(4) * 100}}%</td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    name: 'BargingProgress',
    props: ['jetty', 'title'],
    data: function() {
        return {
            progress: [],
            totalVolume: 0,
            totalProgress: 0,
            totalDraughtSurvey: 0,
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
                    _this.totalVolume = 0;
                    _this.totalProgress = 0;
                    _this.totalDraughtSurvey = 0;

                    _this.progress.forEach(function(p) {
                        _this.totalVolume += p.volume;
                        _this.totalProgress += p.volume_progress;
                        _this.totalDraughtSurvey += p.volume_by_draught_survey;
                    });
                })
                .catch(function(e) {
                    console.log(e);
                });

            setTimeout(this.requestData, 5000);
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
th, td {
    text-align: center;
}
</style>
