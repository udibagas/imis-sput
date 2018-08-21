<template lang="html">
    <div class="">
        <div class="panel panel-primary" style="margin-bottom:0;">
            <div class="panel-heading">
                ACTIVE BARGING
            </div>
        </div>
        <div class="panel panel-default"  v-for="b in bargings" style="margin-bottom:0;">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th colspan="2">
                            <div class="pull-right">
                                <a href="#" class="btn btn-info btn-sm btn-outline">Show Dwelling Time</a>
                            </div>
                            {{b.customer}}
                        </th>
                    </tr>
                    <tr><td>Customer</td><td>{{b.customer}}</td></tr>
                    <tr><td>Buyer</td><td>{{b.buyer}}</td></tr>
                    <tr><td>Jetty</td><td>{{b.jetty}}</td></tr>
                    <tr><td>Barge</td><td>{{b.barge}}</td></tr>
                    <tr><td>Tugboat</td><td>{{b.tugboat}}</td></tr>
                    <tr><td>Cargo</td><td v-html="b.cargo"></td></tr>
                    <tr><td>Volume</td><td>{{b.volume | formatNumber}} TON</td></tr>
                    <tr><td>Volume by Bucket Control</td><td>{{b.volume_by_bucket_ctrl | formatNumber}} TON</td></tr>
                    <tr><td>Progress</td><td>{{b | getPercentage}}%</td></tr>
                    <tr><td>Status</td>
                        <td>
                            <span :class="['label', 'label-' + statuses.filter(s => s.id == b.status)[0].color]">
                                {{statuses.filter(s => s.id == b.status)[0].text}}
                            </span>
                        </td>
                    </tr>
                    <tr><td>Description</td><td>{{b.description}}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            bargings: [],
            statuses: [
                {"id":0,"text":"Initiate","color":"info"},
                {"id":1,"text":"Loading","color":"success"},
                {"id":2,"text":"Breakdown","color":"danger"},
                {"id":3,"text":"Delay","color":"warning"},
                {"id":4,"text":"Idle","color":"default"},
                {"id":5,"text":"Complete","color":"primary"}
            ]
        }
    },
    filters: {
        getPercentage: function(v) {
            return (parseInt(v.volume_by_bucket_ctrl) / parseInt(v.volume) * 100).toFixed(2);
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            axios.get('barging/active').then(function(r) {
                _this.bargings = r.data;
            })
            .catch(function(error){
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
</style>
