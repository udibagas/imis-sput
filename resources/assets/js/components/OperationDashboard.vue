<template>
    <div class="row">
        <div class="col-md-2">
            <barging-progress v-for="j in jetties" :key="j.id" :id="j.id" :jetty="j"> </barging-progress>
        </div>
        <div class="col-md-6">
            <barging v-for="j in jetties" :key="j.id" :id="j.id" :jetty="j"> </barging>
        </div>
        <div class="col-md-4">
            <stock v-for="j in jetties" :key="j.id" :id="j.id" :jetty="j"> </stock>
        </div>
    </div>
</template>

<script>
import Barging from "./Barging.vue";
import BargingProgress from "./BargingProgress.vue";

export default {
    name: "OperationDashboard",
    components: {Barging, BargingProgress},
    data: function() {
        return {
            charts: [],
            wheelLoaders: [],
            dumpTrucks: [],
            jetties: [],
            chartStock: []
        }
    },
    methods: {
        getJetty: function() {
            var _this = this;
            axios.get('api/jetty').then(function(r) {
                _this.jetties = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        sync: function() {
            this.getJetty();
        }
    },
    mounted: function() {
        var _this = this;
        _this.sync();
    }
}
</script>

<style lang="css">
</style>
