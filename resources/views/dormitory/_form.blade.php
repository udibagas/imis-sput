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

                    <div :class="['form-group', formErrors.name ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.description ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.description" class="form-control" placeholder="Description">
                            <span v-if="formErrors.description" class="help-block">@{{formErrors.description[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.pic ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">PIC
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" v-model="formData.pic" class="form-control" placeholder="PIC">
                            <span v-if="formErrors.pic" class="help-block">@{{formErrors.pic[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.status ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.status" id="yes" value="1">
								<label for="yes">AVAILABLE</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.status" id="no" value="0">
								<label for="no">NOT AVAILABLE</label>
							</div>
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
                        </div>
                    </div>

                    <br>

                    <table class="table table-striped table-hover" style="margin-bottom:0;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room Name</th>
                                <th>Capacity</th>
                                <th>PIC</th>
                                <th>Available</th>
                                <th><a href="#" @click="addRoom" class="btn btn-primary"><i class="icon-plus"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(r,i) in formData.rooms" :class="formData.rooms[i].status == 0 ? 'danger' : ''">
                                <td> @{{i+1}} </td>
                                <td>
                                    <input type="hidden" v-model="formData.rooms[i].id">
                                    <input type="text" class="form-control" v-model="formData.rooms[i].name">
                                </td>
                                <td>
                                    <input type="number" class="form-control" v-model="formData.rooms[i].capacity">
                                </td>
                                <td>
                                    <input type="text" class="form-control" v-model="formData.rooms[i].pic">
                                </td>
                                <td>
                                    <select class="form-control" v-model="formData.rooms[i].status">
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" @click="removeRoom(i)" class="btn btn-danger"><i class="icon-trash"></i></a>
                                </td>
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
