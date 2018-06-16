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

                    <div :class="['form-group', formErrors.name ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.nrp ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="nrp">NRP
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.nrp" class="form-control" placeholder="NRP">
                            <span v-if="formErrors.nrp" class="help-block">@{{formErrors.nrp[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.department_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="department_id">Department
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="departments" v-model="formData.department_id" data-placeholder="Department">
                            </select2>
                            <span v-if="formErrors.department_id" class="help-block">@{{formErrors.department_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.position_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="position_id">Position
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="positions" v-model="formData.position_id" data-placeholder="Position">
                            </select2>
                            <span v-if="formErrors.position_id" class="help-block">@{{formErrors.position_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.owner_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="owner_id">Employer
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="employers" v-model="formData.owner_id" data-placeholder="Employer">
                            </select2>
                            <span v-if="formErrors.owner_id" class="help-block">@{{formErrors.owner_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.office_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="office_id">Office
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="offices" v-model="formData.office_id" data-placeholder="Office">
                            </select2>
                            <span v-if="formErrors.office_id" class="help-block">@{{formErrors.office_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.status ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.status" id="status_yes" value="1">
								<label for="status_yes">ACTIVE</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.status" id="status_no" value="0">
								<label for="status_no">NON ACTIVE</label>
							</div>
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
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
