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

                    <div class="form-group" :class="formErrors.unit_activity_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_activity_id">Activity
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="unit_activities" v-model="formData.unit_activity_id" data-placeholder="Activity">
                            </select2>
                            <span v-if="formErrors.unit_activity_id" class="help-block">@{{formErrors.unit_activity_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.time_start || formErrors.time_end ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_start">Time
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select2 :options="times"  v-model="formData.time_start" class="form-control" data-placeholder="Start">
                            </select2>
                            <span v-if="formErrors.time_start" class="help-block">@{{formErrors.time_start[0]}}</span>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select2 :options="times"  v-model="formData.time_end" class="form-control" data-placeholder="End">
                            </select2>
                            <span v-if="formErrors.time_end" class="help-block">@{{formErrors.time_end[0]}}</span>
                        </div>
                    </div>

                    <div v-show="showHaulerList" class="form-group" :class="formErrors.hauler_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hauler_id">Hauler
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="haulers" v-model="formData.hauler_id" data-placeholder="Hauler">
                            </select2>
                            <span v-if="formErrors.hauler_id" class="help-block">@{{formErrors.hauler_id[0]}}</span>
                        </div>
                    </div>

                    <div v-show="showMaterialStockList" class="form-group" :class="formErrors.material_stock_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="material_stock_id">Stock
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="material_stocks" v-model="formData.material_stock_id" data-placeholder="Stock">
                            </select2>
                            <span v-if="formErrors.material_stock_id" class="help-block">@{{formErrors.material_stock_id[0]}}</span>
                        </div>
                    </div>

                    <div v-show="showHopperList" :class="['form-group', formErrors.hopper_id ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jetty_id">Jetty
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="jetties" v-model="formData.jetty_id" data-placeholder="Jetty">
                            </select2>
                            <span v-if="formErrors.jetty_id" class="help-block">@{{formErrors.jetty_id[0]}}</span>
                        </div>
                    </div>

                    <div v-show="showHopperList" :class="['form-group', formErrors.hopper_id ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hopper_id">Hopper
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="hoppers.filter(h => h.jetty_id == formData.jetty_id)" v-model="formData.hopper_id" data-placeholder="Hopper">
                            </select2>
                            <span v-if="formErrors.hopper_id" class="help-block">@{{formErrors.hopper_id[0]}}</span>
                        </div>
                    </div>

                    <div v-show="showBucketInput" class="form-group" :class="formErrors.rit ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rit">Bucket
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.rit" class="form-control" placeholder="Bucket">
                            <span v-if="formErrors.rit" class="help-block">@{{formErrors.rit[0]}}</span>
                        </div>
                    </div>

                    <div v-show="showVolumeInput" class="form-group" :class="formErrors.volume ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume">Volume (KG)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.volume" class="form-control" placeholder="Volume (KG)">
                            <span v-if="formErrors.volume" class="help-block">@{{formErrors.volume[0]}}</span>
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
