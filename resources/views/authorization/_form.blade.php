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
                    <div class="form-group" :class="formErrors.user_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id">User
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" v-model="formData.user_id" placeholder="User">
                                @foreach (App\User::where('super_admin', 0)->orderBy('name', 'ASC')->pluck('name', 'id') as $id => $name):
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                            <span v-if="formErrors.user_id" class="help-block">@{{formErrors.user_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.controller ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="controller">Controller
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.controller" class="form-control" placeholder="Controller">
                            <span v-if="formErrors.controller" class="help-block">@{{formErrors.controller[0]}}</span>
                        </div>
                    </div>

                    <table class="table table-striped" style="border-top:2px solid #ddd">
                        <thead>
                            <tr>
                            @foreach (['view', 'create', 'update', 'delete', 'export', 'import', 'dashboard'] as $a)
                                <th class="text-center">{{$a}}</th>
                            @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach (['view', 'create', 'update', 'delete', 'export', 'import', 'dashboard'] as $a)
                                    <td class="text-center">
                                        <input type="checkbox" v-model="formData.{{$a}}">
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>

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
