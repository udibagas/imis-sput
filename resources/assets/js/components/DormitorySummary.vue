<template lang="html">
    <div :class="['panel', dormitory.status ? 'panel-success' : 'panel-danger']">
        <div class="panel-heading text-center">
            {{dormitory.name}}
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Room</th>
                    <th class="text-center">C</th>
                    <th class="text-center">R</th>
                    <th class="text-center">A</th>
                    <th v-if="dormitory.status != 0"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="r in dormitory.rooms" :class="r.available == 0 || r.status == 0 ? 'danger' : ''">
                    <td class="text-center">{{r.name}}</td>
                    <td class="text-center">{{r.capacity}}</td>
                    <td class="text-center">{{r.reserved}}</td>
                    <td class="text-center">{{r.available}}</td>
                    <td class="text-right" v-if="dormitory.status != 0">

                        <button v-show="r.reserved > 0" type="button" class="btn btn-primary btn-xs" @click="roomDetail(r,d)" title="Room Detail"><i class="icon-list"></i></button>

                        <button v-show="r.available > 0 && dormitory.status == 1 && r.status == 1" type="button" class="btn btn-primary btn-xs" @click="createReservation(r)" title="Create Reservation"><i class="icon-plus"></i></button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">{{dormitory.capacity}}</th>
                    <th class="text-center">{{dormitory.reserved}}</th>
                    <th class="text-center">{{dormitory.available}}</th>
                    <th v-if="dormitory.status != 0" class="text-center"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props: ['dormitory'],
    data: function() {
        return {
            formData: {},
            formErrors: {},
            error: {}
        }
    },
    methods: {
        createReservation: function(room) {
            this.formTitle = "ADD DORMITORY RESERVATION";
            this.formData = {};
            this.formErrors = {};
            this.error = {};

            this.formData.check_in = moment().format('YYYY-MM-DD');
            $('#modal-form').modal('show');
        },
        roomDetail: function(room, dormitry) {

        }
    },
    mounted: function() {

    }
}
</script>

<style lang="css">
</style>
