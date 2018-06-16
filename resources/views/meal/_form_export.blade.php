<div id="modal-form-export" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">EXPORT TO EXCEL</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="input-group">
                        <vue-datepicker placeholder="From" v-model="exportRange.from">
                        </vue-datepicker>
                        <div class="input-group-addon">To</div>
                        <vue-datepicker placeholder="To" v-model="exportRange.to">
                        </vue-datepicker>
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
