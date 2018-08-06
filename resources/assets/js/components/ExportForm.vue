<template lang="html">
    <div :id="id" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">EXPORT TO EXCEL</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="input-group">
                            <vue-datepicker placeholder="From" v-model="from_actual"> </vue-datepicker>
                            <div class="input-group-addon">To</div>
                            <vue-datepicker placeholder="To" v-model="to_actual"> </vue-datepicker>
                        </div>
                    </div>

                    <div class="clearfix"> </div>

                </div>
                <div class="modal-footer">
                    <button @click="doExport" type="button" class="btn btn-primary"><i class="fa fa-download"></i> Export</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['url', 'id', 'from', 'to'],
    data: function() {
        return {
            from_actual: this.from,
            to_actual: this.to
        }
    },
    methods: {
        doExport: function() {
            $('#'+ this.id).modal('hide');
            window.location = this.url + '?from=' + this.from_actual + '&to=' + this.to_actual;
        },
    }
}
</script>

<style lang="css" scoped>
</style>
