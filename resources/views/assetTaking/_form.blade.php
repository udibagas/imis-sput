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

                    <div class="form-group" :class="formErrors.date ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="date">Date
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <vue-datepicker v-model="formData.date" placeholder="Date">
                            </vue-datepicker>
                            <span v-if="formErrors.date" class="help-block">@{{formErrors.date[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.asset_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="asset_id">Asset
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="assets" v-model="formData.asset_id" data-placeholder="Asset">
                            </select2>
                            <span v-if="formErrors.asset_id" class="help-block">@{{formErrors.asset_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.asset_location_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="asset_location_id">Location
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="locations" v-model="formData.asset_location_id" data-placeholder="Location">
                            </select2>
                            <span v-if="formErrors.asset_location_id" class="help-block">@{{formErrors.asset_location_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.asset_status_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="asset_status_id">Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="statuses" v-model="formData.asset_status_id" data-placeholder="Status">
                            </select2>
                            <span v-if="formErrors.asset_status_id" class="help-block">@{{formErrors.asset_status_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="note">Note
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea v-model="formData.note" class="form-control" placeholder="Note" rows="3"></textarea>
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
