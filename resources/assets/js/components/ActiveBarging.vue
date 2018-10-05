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
                            <tr>
                                <td>Progress By Beltscale</td>
                                <td>{{getBeltscaleData(b.node_id).Weight | formatNumber}} TON</td>
                            </tr>
                            <tr>
                                <td>Productivity</td>
                                <td>{{getBeltscaleData(b.node_id).TPH | formatNumber}} TPH</td>
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
                <barging-progress :barging="b.id" :title="'BARGING PROGRESS - JETTY ' + b.jetty"> </barging-progress>
                <dwelling-time :barging="b.id" :title="'DWELLING TIME - JETTY ' + b.jetty"> </dwelling-time>
            </div>
        </div>
    </div>
</template>

<script>
import BargingProgress from './BargingProgress';
import DwellingTime from './DwellingTime';
import store from '../store'

export default {
    store,
    components: { BargingProgress, DwellingTime },
    computed: {
        dataLiveBarging() {
            return this.$store.state.dataLiveBarging
        }
    },
    data: function() {
        return {
            bargings: [],
            statuses: ["Initiate", "Loading", "Breakdown", "Delay", "Idle", "Complete"],
            colors: ["info", "success", "danger", "warning", "default", "primary"],
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            _this.$store.commit('getLiveBargingData');
            axios.get(BASE_URL + '/barging/active')
                .then(function(r) {
                    _this.bargings = r.data;
                })
                .catch(function(error){
                    console.log(error);
                });

            setTimeout(this.requestData, 5000);
        },
        getBeltscaleData: function(nodeId) {
            return this.dataLiveBarging.find(function(d) {
                return d.NodeId === parseInt(nodeId)
            })
        },
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
</style>
