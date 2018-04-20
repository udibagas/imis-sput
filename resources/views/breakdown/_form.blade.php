<div id="modal-form" class="modal fade" tabindex="-1" role="dialog">
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

                    <div class="form-group" :class="formErrors.km ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="km">KM
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.km" class="form-control" placeholder="KM">
                            <span v-if="formErrors.km" class="help-block">@{{formErrors.km[0]}}</span>
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
