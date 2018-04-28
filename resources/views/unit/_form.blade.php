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

                    <div class="form-group" :class="formErrors.name ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.unit_category_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_category_id">Category
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.unit_category_id" data-placeholder="Category">
                                @foreach (\App\UnitCategory::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.unit_category_id" class="help-block">@{{formErrors.unit_category_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.owner_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="owner_id">Owner
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.owner_id" data-placeholder="Owner">
                                @foreach (\App\Owner::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.owner_id" class="help-block">@{{formErrors.owner_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.egi_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="egi_id">EGI
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.egi_id" data-placeholder="EGI">
                                @foreach (\App\Egi::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.egi_id" class="help-block">@{{formErrors.egi_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.alocation_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alocation_id">Alocation
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.alocation_id" data-placeholder="Alocation">
                                @foreach (\App\Alocation::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.alocation_id" class="help-block">@{{formErrors.alocation_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.fc ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fc">FC
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.fc" class="form-control" placeholder="Status">
                            <span v-if="formErrors.fc" class="help-block">@{{formErrors.fc[0]}}</span>
                        </div>
                    </div>

                    <!-- <div class="form-group" :class="formErrors.status ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.status" class="form-control" placeholder="Status">
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
                        </div>
                    </div> -->

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
