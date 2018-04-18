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
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name" required>
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.email ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="email" v-model="formData.email" class="form-control" placeholder="Email" required>
                            <span v-if="formErrors.email" class="help-block">@{{formErrors.email[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.password ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password">Password
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" v-model="formData.password" class="form-control" placeholder="Password">
                            <span v-if="formErrors.password" class="help-block">@{{formErrors.password[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.password ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password_confirmation">Password Confirmation
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" v-model="formData.password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.role ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="role">Role
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.role">
                                @foreach (\App\User::getRoles() as $role)
                                <option value="{{$role}}">{{$role}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.role" class="help-block">@{{formErrors.role[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.active ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="active">Active
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.active">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <span v-if="formErrors.active" class="help-block">@{{formErrors.active[0]}}</span>
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
