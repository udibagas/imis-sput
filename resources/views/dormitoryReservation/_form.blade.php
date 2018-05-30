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

                    <div class="form-group" :class="formErrors.permit_number ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="permit_number">Permit Number
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.permit_number" class="form-control" placeholder="Permit Number">
                            <span v-if="formErrors.permit_number" class="help-block">@{{formErrors.permit_number[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.employee_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="employee_id">Employee
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 v-model="formData.employee_id" :options="employees" data-placeholder="Employee">
                            </select2>
                            <span v-if="formErrors.employee_id" class="help-block">@{{formErrors.employee_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.dormitory_room_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="dormitory_room_id">Room
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 v-model="formData.dormitory_room_id" :options="rooms" data-placeholder="Room">
                            </select2>
                            <span v-if="formErrors.dormitory_room_id" class="help-block">@{{formErrors.dormitory_room_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.check_in ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="check_in">Check In
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <vue-datepicker v-model="formData.check_in" placeholder="Check In">
                            </vue-datepicker>
                            <span v-if="formErrors.check_in" class="help-block">@{{formErrors.check_in[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.check_out ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="check_out">Check Out
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <vue-datepicker v-model="formData.check_out" placeholder="Check Out">
                            </vue-datepicker>
                            <span v-if="formErrors.check_out" class="help-block">@{{formErrors.check_out[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.need ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="need">Need
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.need" class="form-control" placeholder="Need">
                            <span v-if="formErrors.need" class="help-block">@{{formErrors.need[0]}}</span>
                        </div>
                    </div>

                    <div v-show="formData.id != undefined" :class="['form-group', formErrors.is_checked_out ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="is_checked_out">Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.is_checked_out" id="yes" value="1">
								<label for="yes">SUDAH CHECK OUT</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.is_checked_out" id="no" value="0">
								<label for="no">BELUM CHECK OUT</label>
							</div>
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
