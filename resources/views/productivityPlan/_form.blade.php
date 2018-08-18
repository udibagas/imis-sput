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

                    <div class="form-group" :class="formErrors.egi_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="egi_id">EGI
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="egis" v-model="formData.egi_id" data-placeholder="EGI">
                            </select2>
                            <span v-if="formErrors.egi_id" class="help-block">@{{formErrors.egi_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.unit_activity_id ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="unit_activity_id">Activity
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="unit_activities" v-model="formData.unit_activity_id" data-placeholder="Activity">
                            </select2>
                            <span v-if="formErrors.unit_activity_id" class="help-block">@{{formErrors.unit_activity_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.hi_cv || formErrors.lo_cv ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hi_cv">CV
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="number" v-model="formData.hi_cv" class="form-control" placeholder="High">
                            <span v-if="formErrors.hi_cv" class="help-block">@{{formErrors.hi_cv[0]}}</span>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="number" v-model="formData.lo_cv" class="form-control" placeholder="Low">
                            <span v-if="formErrors.lo_cv" class="help-block">@{{formErrors.lo_cv[0]}}</span>
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
