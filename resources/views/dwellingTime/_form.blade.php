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

                    <div :class="['form-group', formErrors.time ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time">Time
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datetimepicker data-date-format="YYYY-MM-DD HH:mm" placeholder="Time" v-model="formData.time">
                            </vue-datetimepicker>
                            <span v-if="formErrors.time" class="help-block">@{{formErrors.time[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.barging_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="barging_id">Barging
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="bargings" v-model="formData.barging_id" data-placeholder="Barging" :disabled="formData.id">
                            </select2>
                            <span v-if="formErrors.barging_id" class="help-block">@{{formErrors.barging_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.jetty_id ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jetty_id">Jetty
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="jetties" v-model="formData.jetty_id" data-placeholder="Jetty">
                            </select2>
                            <span v-if="formErrors.jetty_id" class="help-block">@{{formErrors.jetty_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.status ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="statuses" v-model="formData.status" data-placeholder="Status">
                            </select2>
                            <span v-if="formErrors.status" class="help-block">@{{formErrors.status[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.description ? 'has-error' : '']">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 v-if="formData.status == 3 || formData.status == 4" :options="descriptions" v-model="formData.description" data-placeholder="Description">
                            </select2>
                            <input v-if="formData.status != 3 && formData.status != 4" type="text" v-model="formData.description" class="form-control" placeholder="Description">
                            <span v-if="formErrors.description" class="help-block">@{{formErrors.description[0]}}</span>
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
