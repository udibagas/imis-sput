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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datepicker v-model="formData.date" placeholder="Date">
                            </vue-datepicker>
                            <span v-if="formErrors.date" class="help-block">@{{formErrors.date[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.fuel_tank_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fuel_tank_id">Fuel Tank
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="fuel_tanks" v-model="formData.fuel_tank_id" data-placeholder="Fuel Tank">
                            </select2>
                            <span v-if="formErrors.fuel_tank_id" class="help-block">@{{formErrors.fuel_tank_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.unit_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_id">Unit
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="units" v-model="formData.unit_id" data-placeholder="Unit">
                            </select2>
                            <span v-if="formErrors.unit_id" class="help-block">@{{formErrors.unit_id[0]}}</span>
                        </div>
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

                    <div class="form-group" :class="formErrors.hm ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hm">HM
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.hm" class="form-control" placeholder="HM Now">
                                    <span v-if="formErrors.hm" class="help-block">@{{formErrors.hm[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.hm_last" class="form-control" placeholder="HM Last" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.km ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hm">KM
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.km" class="form-control" placeholder="KM Now">
                                    <span v-if="formErrors.km" class="help-block">@{{formErrors.km[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.km_last" class="form-control" placeholder="KM Last" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.total_real ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hm">Total (Liter)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.total_real" class="form-control" placeholder="Real">
                                    <span v-if="formErrors.total_real" class="help-block">@{{formErrors.total_real[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.total_recommended" class="form-control" placeholder="Recommended" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.start_time || formErrors.finish_time ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hm">Time
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.start_time" class="form-control" placeholder="Start">
                                    <span v-if="formErrors.start_time" class="help-block">@{{formErrors.start_time[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.finish_time" class="form-control" placeholder="Finish">
                                    <span v-if="formErrors.finish_time" class="help-block">@{{formErrors.finish_time[0]}}</span>
                                </div>
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
