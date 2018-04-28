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
                    <div class="form-group" :class="formErrors.module ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="module">Module
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.module" class="form-control" placeholder="Name">
                            <span v-if="formErrors.module" class="help-block">@{{formErrors.module[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.status ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" v-model="formData.status" data-placeholder="Select Status">
                                <option value="1">Show</option>
                                <option value="0">Hide</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.text ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="text">Text
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea v-model="formData.text" class="form-control" placeholder="Description" rows="10"></textarea>
                            <span v-if="formErrors.text" class="help-block">@{{formErrors.text[0]}}</span>
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
