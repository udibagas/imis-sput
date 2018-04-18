<div id="modal-form" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" role="form">
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.nrp ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="nrp">NRP
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.nrp" class="form-control" placeholder="NRP">
                            <span v-if="formErrors.nrp" class="help-block">@{{formErrors.nrp[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.department_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="department_id">Department
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.department_id">
                                @foreach (\App\Department::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.department_id" class="help-block">@{{formErrors.department_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.position_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="position_id">Position
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.position_id">
                                @foreach (\App\Position::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.position_id" class="help-block">@{{formErrors.position_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.owner_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="owner_id">Owner
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.owner_id">
                                @foreach (\App\Owner::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.owner_id" class="help-block">@{{formErrors.owner_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.office_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="office_id">Office
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.office_id">
                                @foreach (\App\Office::orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.office_id" class="help-block">@{{formErrors.office_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.status ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.status" class="form-control" placeholder="Status">
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" v-if="formData.id == undefined" class="btn btn-primary" @click="store"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" v-if="formData.id != undefined" class="btn btn-primary" @click="update"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
