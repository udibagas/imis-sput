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

                    <div class="form-group" :class="formErrors.subcont_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="subcont_id">Subcont
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="subconts" v-model="formData.subcont_id" data-placeholder="Subcont">
                            </select2>
                            <span v-if="formErrors.subcont_id" class="help-block">@{{formErrors.subcont_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.code_number ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="code_number">Code Number
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.code_number" class="form-control" placeholder="Code Number">
                            <span v-if="formErrors.code_number" class="help-block">@{{formErrors.code_number[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.type ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="type">Type
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.type" class="form-control" placeholder="Type">
                            <span v-if="formErrors.type" class="help-block">@{{formErrors.type[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.model ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="model">Model
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input model="text" v-model="formData.model" class="form-control" placeholder="Model">
                            <span v-if="formErrors.model" class="help-block">@{{formErrors.model[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.empty_weight ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="empty_weight">Empty Weight
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.empty_weight" class="form-control" placeholder="Empty Weight">
                            <span v-if="formErrors.empty_weight" class="help-block">@{{formErrors.empty_weight[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.average_weight ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="average_weight">Average Weight
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.average_weight" class="form-control" placeholder="Average Weight">
                            <span v-if="formErrors.average_weight" class="help-block">@{{formErrors.average_weight[0]}}</span>
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
