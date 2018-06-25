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

                    <div :class="['form-group', formErrors.shift ? 'has-error' : '']">
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

                    <div :class="['form-group', formErrors.fuel_tank_id || formErrors.sadp_id ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fuel_tank_id">Fuel Tank / SADP
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select2 data-allow-clear="true" :options="fuel_tanks" v-model="formData.fuel_tank_id" data-placeholder="Fuel Tank">
                            </select2>
                            <span v-if="formErrors.fuel_tank_id" class="help-block">@{{formErrors.fuel_tank_id[0]}}</span>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select2 :options="sadps" v-model="formData.sadp_id" data-placeholder="SADP">
                            </select2>
                            <span v-if="formErrors.sadp_id" class="help-block">@{{formErrors.sadp_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.status || formErrors.transfer_to_fuel_tank_id ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.status" id="status_s" value="S">
								<label for="status_s">Stock Awal</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.status" id="status_t" value="T">
								<label for="status_t">Transfer To </label>
							</div>
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
                        </div>
                        <div v-show="formData.status == 'T'" class="col-md-4 col-sm-4 col-xs-12">
                            <select2 :options="fuel_tanks" data-allow-clear="true" v-model="formData.transfer_to_fuel_tank_id" data-placeholder="Fuel Tank">
                            </select2>
                            <span v-if="formErrors.transfer_to_fuel_tank_id" class="help-block">@{{formErrors.transfer_to_fuel_tank_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.flowmeter_start || formErrors.flowmeter_end ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flowmeter_start">Flow Meter
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.flowmeter_start" class="form-control" placeholder="Flow Meter Start">
                                    <span v-if="formErrors.flowmeter_start" class="help-block">@{{formErrors.flowmeter_start[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.flowmeter_end" class="form-control" placeholder="Flow Meter End">
                                    <span v-if="formErrors.flowmeter_end" class="help-block">@{{formErrors.flowmeter_end[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.sounding_start || formErrors.sounding_end ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sounding_start">Sounding
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.sounding_start" class="form-control" placeholder="Sounding Start">
                                    <span v-if="formErrors.sounding_start" class="help-block">@{{formErrors.sounding_start[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" v-model="formData.sounding_end" class="form-control" placeholder="Sounding End">
                                    <span v-if="formErrors.sounding_end" class="help-block">@{{formErrors.sounding_end[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.volume_by_sounding ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume_by_sounding">Volume By Sounding (Liter)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" v-model="formData.volume_by_sounding" placeholder="Volume By Sounding (Liter)">
                            <span v-if="formErrors.volume_by_sounding" class="help-block">@{{formErrors.volume_by_sounding[0]}}</span>
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
