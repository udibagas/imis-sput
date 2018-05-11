<div id="modal-form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" @submit.prevent="formData.id == undefined ? store : update">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@{{formTitle}}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" v-if="error.message">
                        @{{error.message}}<br>
                        @{{error.file}}:@{{error.line}}
                    </div>
                    <div class="form-group" :class="formErrors.code ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Code
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.code" class="form-control" placeholder="Code">
                            <span v-if="formErrors.code" class="help-block">@{{formErrors.code[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.ip_address ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ip_address">IP Address
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.ip_address" class="form-control" placeholder="IP Address">
                            <span v-if="formErrors.ip_address" class="help-block">@{{formErrors.ip_address[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.location_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location_id">Location
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="locations" v-model="formData.location_id" data-placeholder="Location">
                            </select2>
                            <span v-if="formErrors.location_id" class="help-block">@{{formErrors.location_id[0]}}</span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" v-if="formData.id == undefined" class="btn btn-primary" @click="store"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="submit" v-if="formData.id != undefined" class="btn btn-primary" @click="update"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
