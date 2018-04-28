<div id="modal-form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form" @submit.prevent="update">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">UPDATE PCR</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger" v-if="error.message">
                        @{{error.message}}<br>
                        @{{error.file}}:@{{error.line}}
                    </div>

                    <div class="form-group" :class="formErrors.wo_number ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wo_number">WO Number
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.wo_number" class="form-control" placeholder="WO Number">
                            <span v-if="formErrors.wo_number" class="help-block">@{{formErrors.wo_number[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.unit_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_id">Unit
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.unit_id" data-placeholder="Unit">
                                @foreach (\App\Unit::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.unit_id" class="help-block">@{{formErrors.unit_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.breakdown_category_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="breakdown_category_id">B/D Type
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.breakdown_category_id" data-placeholder="B/D Type">
                                @foreach (\App\BreakdownCategory::selectRaw('id, CONCAT(name, " - ", description_en) AS code')->orderBy('code', 'ASC')->pluck('code', 'id') as $id => $code)
                                <option value="{{$id}}">{{$code}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.breakdown_category_id" class="help-block">@{{formErrors.breakdown_category_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.breakdown_status_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="breakdown_status_id">B/D Status
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.breakdown_status_id" data-placeholder="B/D Status">
                                @foreach (\App\BreakdownStatus::selectRaw('id, CONCAT(code, " - ", description) AS code')->orderBy('code', 'ASC')->pluck('code', 'id') as $id => $code)
                                <option value="{{$id}}">{{$code}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.breakdown_status_id" class="help-block">@{{formErrors.breakdown_status_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.location_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location_id">Location
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.location_id" data-placeholder="Location">
                                @foreach (\App\Location::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.location_id" class="help-block">@{{formErrors.location_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.hm ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hm">HM
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.hm" class="form-control" placeholder="HM">
                            <span v-if="formErrors.hm" class="help-block">@{{formErrors.hm[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.km ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="km">KM
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.km" class="form-control" placeholder="KM">
                            <span v-if="formErrors.km" class="help-block">@{{formErrors.km[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.time_in ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_in">Time In
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.time_in" class="form-control datetime-picker" placeholder="Time In" data-date-format="YYYY-MM-DD HH:mm">
                            <span v-if="formErrors.time_in" class="help-block">@{{formErrors.time_in[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.diagnosa ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="diagnosa">Diagnosa
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea v-model="formData.diagnosa" class="form-control" placeholder="Diagnosa" rows="5"></textarea>
                            <span v-if="formErrors.diagnosa" class="help-block">@{{formErrors.diagnosa[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.tindakan ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tindakan">Tindakan
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea v-model="formData.tindakan" class="form-control" placeholder="Tindakan" rows="5"></textarea>
                            <span v-if="formErrors.tindakan" class="help-block">@{{formErrors.tindakan[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.component_criteria_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="component_criteria_id">Component Criteria
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.component_criteria_id" data-placeholder="Component Criteria">
                                @foreach (\App\ComponentCriteria::selectRaw('id, CONCAT(code, " - ", description) AS code')->orderBy('code', 'ASC')->pluck('code', 'id') as $id => $code)
                                <option value="{{$id}}">{{$code}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.component_criteria_id" class="help-block">@{{formErrors.component_criteria_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.time_out ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_out">Time Out
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.time_out" class="form-control datetime-picker" placeholder="Time Out" data-date-format="YYYY-MM-DD HH:mm">
                            <span v-if="formErrors.time_out" class="help-block">@{{formErrors.time_out[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.warning_part ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warning_part">Warning Part
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea v-model="formData.warning_part" class="form-control" placeholder="Warning Part" rows="5"></textarea>
                            <span v-if="formErrors.warning_part" class="help-block">@{{formErrors.warning_part[0]}}</span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
