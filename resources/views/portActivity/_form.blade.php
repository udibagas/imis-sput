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

                    <div class="form-group" :class="formErrors.time_start ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_start">Time Start
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.time_start" class="form-control" placeholder="Time Start">
                            <span v-if="formErrors.time_start" class="help-block">@{{formErrors.time_start[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.time_end ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_end">Time End
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.time_end" class="form-control" placeholder="Time End">
                            <span v-if="formErrors.time_end" class="help-block">@{{formErrors.time_end[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.unit_activity_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_activity_id">Activity
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="unit_activities" v-model="formData.unit_activity_id" data-placeholder="Activity">
                            </select2>
                            <span v-if="formErrors.unit_activity_id" class="help-block">@{{formErrors.unit_activity_id[0]}}</span>
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

                    <div class="form-group" :class="formErrors.hauler_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hauler_id">Hauler
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="haulers" v-model="formData.hauler_id" data-placeholder="Hauler">
                            </select2>
                            <span v-if="formErrors.hauler_id" class="help-block">@{{formErrors.hauler_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.stock_area_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock_area_id">Area
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="stock_areas" v-model="formData.stock_area_id" data-placeholder="Area">
                            </select2>
                            <span v-if="formErrors.stock_area_id" class="help-block">@{{formErrors.stock_area_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.hopper_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hopper_id">Hopper
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="hoppers" v-model="formData.hopper_id" data-placeholder="Hopper">
                            </select2>
                            <span v-if="formErrors.hopper_id" class="help-block">@{{formErrors.hopper_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.rit ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rit">Bucket
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.rit" class="form-control" placeholder="Bucket">
                            <span v-if="formErrors.rit" class="help-block">@{{formErrors.rit[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.volume ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume">Volume (Ton)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.volume" class="form-control" placeholder="Volume (Ton)">
                            <span v-if="formErrors.volume" class="help-block">@{{formErrors.volume[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.material_type ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="material_type">Material Type
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.material_type" id="material_type_hi" value="h">
								<label for="material_type_hi">HIGH</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.material_type" id="material_type_lo" value="l">
								<label for="material_type_lo">LOW</label>
							</div>
                            <span v-if="formErrors.material_type" class="help-block">@{{formErrors.material_type[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.seam_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="seam_id">Seam
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="seams" v-model="formData.seam_id" data-placeholder="Seam">
                            </select2>
                            <span v-if="formErrors.seam_id" class="help-block">@{{formErrors.seam_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.customer_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_id">Customer
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="customers" v-model="formData.customer_id" data-placeholder="Customer">
                            </select2>
                            <span v-if="formErrors.customer_id" class="help-block">@{{formErrors.customer_id[0]}}</span>
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
