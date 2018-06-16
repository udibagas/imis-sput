<template>
    <div>
        <div style="border:1px solid #ddd; margin-bottom:10px;" v-for="j in jetties">
            <h1>{{j.name}}</h1>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div v-for="b in barges">
                    <h3>{{b.name}}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Container, Draggable } from "vue-smooth-dnd";

export default {
    name: "Game",
    components: { Container, Draggable },
    data: function() {
        return {
            units: [],
            areas: [],
            seams: [],
            barges: [],
            jetties: [],
            tugboats: [],
            customers: []
        }
    },
    methods: {
        getUnit: function() {
            var _this = this;
            axios.get('api/unit').then(function(r) {
                _this.units = r.data;
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
    },
    mounted: function() {
        this.getUnit();
        this.getArea();
        this.getBarge();
        this.getCustomer();
        this.getJetty();
        this.getSeam();
        this.getTugboat();
    }
}
</script>

<style lang="css">
</style>
