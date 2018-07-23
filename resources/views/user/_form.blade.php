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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.email ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="email" v-model="formData.email" class="form-control" placeholder="Email">
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password_confirmation">Confirm Password
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" v-model="formData.password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.customer_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="customer_id">Customer
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 data-allow-clear="true" :options="customers" v-model="formData.customer_id" data-placeholder="Customer">
                            </select2>
                            <span v-if="formErrors.customer_id" class="help-block">@{{formErrors.customer_id[0]}}</span>
                        </div>
                    </div>

                    <div v-show="formData.customer_id == 0 || formData.customer_id == undefined" class="form-group" :class="formErrors.super_admin ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="super_admin">Super Admin
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.super_admin" id="super_admin_yes" value="1">
								<label for="super_admin_yes">YES</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.super_admin" id="super_admin_no" value="0">
								<label for="super_admin_no">NO</label>
							</div>
                            <span v-if="formErrors.super_admin" class="help-block">@{{formErrors.super_admin[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.active ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="active">Active
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.active" id="active_yes" value="1">
								<label for="active_yes">YES</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.active" id="active_no" value="0">
								<label for="active_no">NO</label>
							</div>
                            <span v-if="formErrors.active" class="help-block">@{{formErrors.active[0]}}</span>
                        </div>
                    </div>

                    <br>

                    <table v-show="showAuth" class="table table-striped table-condensed table-bordered" style="margin-bottom:0;">
                        <thead>
                            <tr>
                                <th style="vertical-align:middle;" rowspan="2">Modules/Action</th>
                                <th class="text-center" v-for="a in actions" style="width:60px;">
                                    @{{a}}
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" v-model="selectAll.view" value="1">
                                </th>
                                <th class="text-center">
                                    <input type="checkbox" v-model="selectAll.create" value="1">
                                </th>
                                <th class="text-center">
                                    <input type="checkbox" v-model="selectAll.update" value="1">
                                </th>
                                <th class="text-center">
                                    <input type="checkbox" v-model="selectAll.delete" value="1">
                                </th>
                                <th class="text-center">
                                    <input type="checkbox" v-model="selectAll.export" value="1">
                                </th>
                                <th class="text-center">
                                    <input type="checkbox" v-model="selectAll.import" value="1">
                                </th>
                            </tr>
                        </thead>
                    </table>

                    <?php $index = 0; ?>
                    @foreach(\App\Authorization::getModule() as $m)
                    <table v-show="showAuth" class="table table-striped table-condensed table-bordered" style="margin-bottom:0;">
                        <thead>
                            <tr>
                                <th colspan="7">{{$m['text']}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m['children'] as $c)
                            <tr>
                                <td>
                                    <span v-html="formData.auth.controller[{{$index}}]"></span>
                                    <input type="hidden" v-model="formData.auth.controller[{{$index}}]">
                                </td>
                                <td class="text-center" style="width:60px;">
                                    <input type="checkbox" v-model="formData.auth.view[{{$index}}]" value="1">
                                </td>
                                <td class="text-center" style="width:60px;">
                                    <input type="checkbox" v-model="formData.auth.create[{{$index}}]" value="1">
                                </td>
                                <td class="text-center" style="width:60px;">
                                    <input type="checkbox" v-model="formData.auth.update[{{$index}}]" value="1">
                                </td>
                                <td class="text-center" style="width:60px;">
                                    <input type="checkbox" v-model="formData.auth.delete[{{$index}}]" value="1">
                                </td>
                                <td class="text-center" style="width:60px;">
                                    <input type="checkbox" v-model="formData.auth.export[{{$index}}]" value="1">
                                </td>
                                <td class="text-center" style="width:60px;">
                                    <input type="checkbox" v-model="formData.auth.import[{{$index}}]" value="1">
                                </td>
                            </tr>
                            <?php $index++ ?>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach

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
