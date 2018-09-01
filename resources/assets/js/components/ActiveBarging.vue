<template lang="html">
    <div>
        <div class="row" v-for="b in bargings">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        BARGING DETAIL - JETTY {{b.jetty}}
                    </div>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr><td>Customer</td><td>{{b.customer}}</td></tr>
                            <tr><td>Buyer</td><td>{{b.buyer}}</td></tr>
                            <tr><td>Jetty</td><td>{{b.jetty}}</td></tr>
                            <tr><td>Barge</td><td>{{b.barge}}</td></tr>
                            <tr><td>Tugboat</td><td>{{b.tugboat}}</td></tr>
                            <tr><td>Target Barging</td><td>{{b.volume | formatNumber}} TON</td></tr>
                            <tr>
                                <td>Progress</td>
                                <td>
                                    {{b.volume_by_bucket_ctrl | formatNumber}} TON ({{(b.volume_by_bucket_ctrl/b.volume*100).toFixed(2)}}%)
                                </td>
                            </tr>
                            <tr><td>Status</td>
                                <td>
                                    <span :class="['label', 'label-' + colors[b.status]]">
                                        {{statuses[b.status]}}
                                    </span>
                                </td>
                            </tr>
                            <tr><td>Description</td><td>{{b.description}}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8">
                <barging-progress :jetty="b.jetty_id" :title="'BARGING PROGRESS - JETTY ' + b.jetty"> </barging-progress>
            </div>
        </div>
    </div>
</template>

<script>
import BargingProgress from './BargingProgress';

export default {
    components: { BargingProgress },
    data: function() {
        return {
            bargings: [],
            statuses: ["Initiate", "Loading", "Breakdown", "Delay", "Idle", "Complete"],
            colors: ["info", "success", "danger", "warning", "default", "primary"],
        }
    },
    filters: {
        getPercentage: function(v) {
            return (parseInt(v.volume_by_bucket_ctrl) / parseInt(v.volume) * 100).toFixed(2);
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            axios.get(BASE_URL + '/barging/active')
                .then(function(r) {
                    _this.bargings = r.data;
                })
                .catch(function(error){
                    console.log(error);
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
</style>
