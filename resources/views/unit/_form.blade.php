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
                            <select2 :options="unit_categories" v-model="formData.unit_category_id" data-placeholder="Unit Category">
                            </select2>
                            <span v-if="formErrors.unit_category_id" class="help-block">@{{formErrors.unit_category_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.owner_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="owner_id">Owner
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="owners" v-model="formData.owner_id" data-placeholder="Owner">
                            </select2>
                            <span v-if="formErrors.owner_id" class="help-block">@{{formErrors.owner_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.egi_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="egi_id">EGI
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="egis" v-model="formData.egi_id" data-placeholder="EGI">
                            </select2>
                            <span v-if="formErrors.egi_id" class="help-block">@{{formErrors.egi_id[0]}}</span>
                        </div>
                    </div>

                    <div v-show="formData.id != undefined" class="form-group" :class="formErrors.status ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.status" id="yes" value="1">
								<label for="yes">OK</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.status" id="no" value="0">
								<label for="no">B/D</label>
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
