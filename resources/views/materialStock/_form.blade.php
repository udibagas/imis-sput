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

                    <div class="form-group" :class="formErrors.dumping_date ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Dumping Date
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datepicker v-model="formData.dumping_date" placeholder="Dumping Date">
                            </vue-datepicker>
                            <span v-if="formErrors.dumping_date" class="help-block">@{{formErrors.dumping_date[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.stock_area_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock_area_id">Area
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="stock_areas" v-model="formData.stock_area_id" data-placeholder="Area" :disabled="formData.id">
                            </select2>
                            <span v-if="formErrors.stock_area_id" class="help-block">@{{formErrors.stock_area_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.material_type ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="material_type">Material Type
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.material_type" id="material_type_hi" value="h" :disabled="formData.id">
								<label for="material_type_hi">HIGH</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.material_type" id="material_type_lo" value="l":disabled="formData.id">
								<label for="material_type_lo">LOW</label>
							</div>
                            <span v-if="formErrors.material_type" class="help-block">@{{formErrors.material_type[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.seam_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="seam_id">Seam
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="seams" v-model="formData.seam_id" data-placeholder="Seam" :disabled="formData.id">
                            </select2>
                            <span v-if="formErrors.seam_id" class="help-block">@{{formErrors.seam_id[0]}}</span>
                        </div>
                    </div>

                    @if (!auth()->user()->customer_id)
                    <div class="form-group" :class="formErrors.customer_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_id">Customer
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="customers" v-model="formData.customer_id" data-placeholder="Customer" :disabled="formData.id">
                            </select2>
                            <span v-if="formErrors.customer_id" class="help-block">@{{formErrors.customer_id[0]}}</span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group" :class="formErrors.volume ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume">Volume (KG)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" v-model="formData.volume" class="form-control" placeholder="Volume (Ton)">
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
