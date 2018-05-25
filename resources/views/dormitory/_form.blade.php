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

                    <div :class="['form-group', formErrors.total_room ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_room">Total Room
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.total_room" class="form-control" placeholder="Total Room">
                            <span v-if="formErrors.total_room" class="help-block">@{{formErrors.total_room[0]}}</span>
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
