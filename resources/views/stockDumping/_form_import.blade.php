<div id="modal-form-import" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">IMPORT FROM EXCEL</h4>
            </div>
            <div class="modal-body">

                <strong>Pilih File:</strong> <input type="file" id="file-upload">
                <div style="min-height:200px;background-color:#333;color:#fff;margin-top:20px;padding:5px;">
                    <span v-for="(log, i) in logs" :key="i" v-html="log"></span>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
