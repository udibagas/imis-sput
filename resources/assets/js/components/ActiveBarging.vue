<template lang="html">
    <div class="">
        <div class="panel panel-primary">
            <div class="panel-heading">
                BARGING DETAIL
            </div>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr><td>Customer</td><td>{{barging.customer}}</td></tr>
                    <tr><td>Buyer</td><td>{{barging.buyer}}</td></tr>
                    <tr><td>Jetty</td><td>{{barging.jetty}}</td></tr>
                    <tr><td>Barge</td><td>{{barging.barge}}</td></tr>
                    <tr><td>Tugboat</td><td>{{barging.tugboat}}</td></tr>
                    <tr><td>Cargo</td><td v-html="barging.cargo"></td></tr>
                    <tr><td>Target Barging</td><td>{{barging.volume | formatNumber}} TON</td></tr>
                    <tr>
                        <td>Progress</td>
                        <td>
                            {{barging.volume_by_bucket_ctrl | formatNumber}} TON ({{barging | getPercentage}}%)
                        </td>
                    </tr>
                    <tr><td>Status</td>
                        <td>
                            <span :class="['label', 'label-' + colors[barging.status]]">
                                {{statuses[barging.status]}}
                            </span>
                        </td>
                    </tr>
                    <tr><td>Description</td><td>{{barging.description}}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['jetty'],
    data: function() {
        return {
            barging: {},
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
            var params = {
                jetty_id: _this.jetty
            };

            axios.get(BASE_URL + '/barging/active/', {params:params})
                .then(function(r) {
                    _this.barging = r.data;
                })
                .catch(function(error){
                    console.log(error);
                });

            setTimeout(this.requestData, 5000);
        }
    },
    mounted: function() {
        setTimeout(this.requestData, 200);
    }
}
</script>

<style lang="css" scoped>
</style>
