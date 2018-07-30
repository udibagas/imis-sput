<template>
    <div class="row">
        <div class="col-md-4">
            <div v-for="j in jetties" :class="['panel', j.status ? 'panel-success' : 'panel-danger']">
                <div  class="panel-heading">
                    <div class="pull-right">
                        <a href="#" @click.prevent="jettyAction(j)"><i class="icon-cog"></i></a>
                    </div>
                    JETTY {{j.name}}
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <barging-progress :id="j.id" :jetty="j"> </barging-progress>
                            <h4>Barging Progress</h4>
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-success" type="button" v-for="u in j.units" style="margin:0 5px 5px 0" @click="unitJettyAction(u)">
                                <i class="fa fa-truck"></i> {{u.name}}
                            </button>
                            <br>
                            <button v-if="j.barge" type="button" class="btn btn-info" @click="bargeJettyAction(j.barge)">
                                {{j.barge.name}}
                            </button>
                            <button v-if="j.tugboat" type="button" class="btn btn-warning">
                                {{j.tugboat.name}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <barging v-for="j in jetties" :key="j.id" :id="j.id" :jetty="j"> </barging>
        </div>
        <div class="col-md-4">
            <stock v-for="j in jetties" :key="j.id" :id="j.id" :jetty="j"> </stock>
        </div>
    </div>
</template>

<script>
import { Container, Draggable } from "vue-smooth-dnd";
import Stock from "./Stock.vue";
import Barging from "./Barging.vue";
import BargingProgress from "./BargingProgress.vue";

export default {
    name: "OperationDashboard",
    components: {Container, Draggable, Stock, Barging, BargingProgress},
    data: function() {
        return {
            charts: [],
            wheelLoaders: [],
            dumpTrucks: [],
            areas: [],
            seams: [],
            barges: [],
            jetties: [],
            tugboats: [],
            customers: [],
            chartStock: []
        }
    },
    methods: {
        bargeAction: function(b) {
            alert(JSON.stringify(b));
        },
        unitAction: function(u) {
            alert(JSON.stringify(u));
        },
        unitJettyAction: function(u) {
            alert(JSON.stringify(u));
        },
        tugboatAction: function(t) {
            alert(JSON.stringify(t));
        },
        jettyAction: function(j) {
            alert(JSON.stringify(j));
        },
        bargeJettyAction: function(b) {
            alert(JSON.stringify(b));
        },
        getUnit: function() {
            var _this = this;

            axios.get('api/unit').then(function(r) {
                _this.wheelLoaders = r.data.filter(u => u.name.toLowerCase().match('wl'));
                _this.dumpTrucks = r.data.filter(u => u.name.toLowerCase().match('ld'));
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getBarge: function() {
            var _this = this;
            axios.get('api/barge').then(function(r) {
                _this.barges = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
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
        getArea: function() {
            var _this = this;
            axios.get('api/area').then(function(r) {
                _this.areas = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getCustomer: function() {
            var _this = this;
            axios.get('api/customer').then(function(r) {
                _this.customers = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getSeam: function() {
            var _this = this;
            axios.get('api/seam').then(function(r) {
                _this.seams = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getTugboat: function() {
            var _this = this;
            axios.get('api/tugboat').then(function(r) {
                _this.tugboats = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        requestDataJetty: function() {

        },
        sync: function() {
            this.getUnit();
            this.getArea();
            this.getBarge();
            this.getCustomer();
            this.getJetty();
            this.getSeam();
            this.getTugboat();
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
