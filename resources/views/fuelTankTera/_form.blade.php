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

                    <div :class="['form-group', formErrors.fuel_tank_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="fuel_tank_id">Fuel Tank
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="fuel_tanks" v-model="formData.fuel_tank_id" data-placeholder="Fuel Tank">
                            </select2>
                            <span v-if="formErrors.fuel_tank_id" class="help-block">@{{formErrors.fuel_tank_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.depth ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="depth">Depth (CM)
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.depth" class="form-control" placeholder="Depth" step="any">
                            <span v-if="formErrors.depth" class="help-block">@{{formErrors.depth[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.volume ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="volume">Volume (Liter)
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.volume" class="form-control" placeholder="Volume">
                            <span v-if="formErrors.volume" class="help-block">@{{formErrors.volume[0]}}</span>
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
