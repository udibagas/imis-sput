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

                    <div :class="['form-group', formErrors.reg_no ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="reg_no">Registration Number
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.reg_no" class="form-control" placeholder="Registration Number">
                            <span v-if="formErrors.reg_no" class="help-block">@{{formErrors.reg_no[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.name ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.trademark ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="trademark">Trademark
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.trademark" class="form-control" placeholder="Trademark">
                            <span v-if="formErrors.trademark" class="help-block">@{{formErrors.trademark[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.version ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="version">Version
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.version" class="form-control" placeholder="Version">
                            <span v-if="formErrors.version" class="help-block">@{{formErrors.version[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.sn ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="sn">SN
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.sn" class="form-control" placeholder="SN">
                            <span v-if="formErrors.sn" class="help-block">@{{formErrors.sn[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.lifetime ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="lifetime">Lifetime
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.lifetime" class="form-control" placeholder="Lifetime">
                            <span v-if="formErrors.lifetime" class="help-block">@{{formErrors.lifetime[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.price ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="price">Price
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.price" class="form-control" placeholder="Price">
                            <span v-if="formErrors.price" class="help-block">@{{formErrors.price[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.year ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="year">Year
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.year" class="form-control" placeholder="Year">
                            <span v-if="formErrors.year" class="help-block">@{{formErrors.year[0]}}</span>
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
