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

                    <div class="form-group" :class="formErrors.node_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="node_id">Node ID
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.node_id" class="form-control" placeholder="Node ID">
                            <span v-if="formErrors.node_id" class="help-block">@{{formErrors.node_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.capacity ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="capacity">Capacity (Ton)
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.capacity" class="form-control" placeholder="Capacity (Ton)">
                            <span v-if="formErrors.capacity" class="help-block">@{{formErrors.capacity[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.description ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="description">Description
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.description" class="form-control" placeholder="Description">
                            <span v-if="formErrors.description" class="help-block">@{{formErrors.description[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.order ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="order">Order
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.order" class="form-control" placeholder="Order">
                            <span v-if="formErrors.order" class="help-block">@{{formErrors.order[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.status ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.status" id="status_yes" value="1">
								<label for="status_yes">OK</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.status" id="status_no" value="0">
								<label for="status_no">BREAKDOWN</label>
							</div>
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            HOPPER
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-right">
                                        <a href="#" @click="addHopper" class="btn btn-primary"><i class="icon-plus"></i></a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(s,i) in formData.hoppers">
                                    <td>
                                        <input type="hidden" v-model="formData.hoppers[i].id">
                                        <input type="text" class="form-control" v-model="formData.hoppers[i].name">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="formData.hoppers[i].description">
                                    </td>
                                    <td class="text-right">
                                        <a href="#" @click="delHopper(i)" class="btn btn-danger"><i class="icon-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
