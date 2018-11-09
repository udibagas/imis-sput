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

                    <div class="form-group" :class="formErrors.employee_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="employee_id">Employee
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="employees" v-model="formData.employee_id" data-placeholder="Employee">
                            </select2>
                            <span v-if="formErrors.employee_id" class="help-block">@{{formErrors.employee_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.date ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datepicker v-model="formData.date" placeholder="Date">
                            </vue-datepicker>
                            <span v-if="formErrors.date" class="help-block">@{{formErrors.date[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.shift ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shift">Shift
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.shift" id="shift_1" value="1">
								<label for="shift_1">1</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.shift" id="shift_2" value="2">
								<label for="shift_2">2</label>
							</div>
                            <span v-if="formErrors.shift" class="help-block">@{{formErrors.shift[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.in ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="in">Time In
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datetimepicker data-date-format="YYYY-MM-DD HH:mm" placeholder="Time In" v-model="formData.in">
                            </vue-datetimepicker>
                            <span v-if="formErrors.in" class="help-block">@{{formErrors.in[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.out ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="out">Time Out
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datetimepicker data-date-format="YYYY-MM-DD HH:mm" placeholder="Time Out" v-model="formData.out">
                            </vue-datetimepicker>
                            <span v-if="formErrors.out" class="help-block">@{{formErrors.out[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.zona_no ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zona_no">Zona No.
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.zona_no" class="form-control" placeholder="Zona No.">
                            <span v-if="formErrors.zona_no" class="help-block">@{{formErrors.zona_no[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.terminal_no ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="terminal_no">Terminal No.
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.terminal_no" class="form-control" placeholder="Terminal No.">
                            <span v-if="formErrors.terminal_no" class="help-block">@{{formErrors.terminal_no[0]}}</span>
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
