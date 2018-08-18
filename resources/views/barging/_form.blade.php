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

                    <div :class="['form-group', formErrors.customer_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="customer_id">Customer
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="customers" v-model="formData.customer_id" data-placeholder="Customer">
                            </select2>
                            <span v-if="formErrors.customer_id" class="help-block">@{{formErrors.customer_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.tugboat_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="tugboat_id">Tugboat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="tugboats" v-model="formData.tugboat_id" data-placeholder="Tugboat">
                            </select2>
                            <span v-if="formErrors.tugboat_id" class="help-block">@{{formErrors.tugboat_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.barge_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="barge_id">Barge
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="barges" v-model="formData.barge_id" data-placeholder="Barge">
                            </select2>
                            <span v-if="formErrors.barge_id" class="help-block">@{{formErrors.barge_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.buyer_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="buyer_id">Buyer
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="buyers" v-model="formData.buyer_id" data-placeholder="Buyer">
                            </select2>
                            <span v-if="formErrors.buyer_id" class="help-block">@{{formErrors.buyer_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.jetty_id ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="jetty_id">Jetty
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select2 :options="jetties" v-model="formData.jetty_id" data-placeholder="Jetty">
                            </select2>
                            <span v-if="formErrors.jetty_id" class="help-block">@{{formErrors.jetty_id[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.volume ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="volume">Volume (KG)
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.volume" class="form-control" placeholder="Volume (KG)">
                            <span v-if="formErrors.volume" class="help-block">@{{formErrors.volume[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.description ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="description">Description
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.description" class="form-control" placeholder="Description">
                            <span v-if="formErrors.description" class="help-block">@{{formErrors.description[0]}}</span>
                        </div>
                    </div>

                    <div :class="['form-group', formErrors.start ? 'has-error' : '']">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="start">Start
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <vue-datetimepicker data-date-format="YYYY-MM-DD HH:mm" placeholder="Start" v-model="formData.start">
                            </vue-datetimepicker>
                            <span v-if="formErrors.start" class="help-block">@{{formErrors.start[0]}}</span>
                        </div>
                    </div>

                    <table class="table table-striped" style="margin: 20px 0 0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Material Type</th>
                                <th>Seam</th>
                                <th>Volume (KG)</th>
                                <th>
                                    <button type="button" class="btn btn-info" @click="addCargo"><i class="icon-plus"></i></button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(c,i) in formData.barging_material">
                                <td>
                                    <input type="hidden" v-model="formData.barging_material[i].id">
                                    <select2 :options="customers" v-model="formData.barging_material[i].customer_id" data-placeholder="Customer">
                                    </select2>
                                </td>
                                <td>
                                    <select class="form-control" v-model="formData.barging_material[i].material_type">
                                        <option value="l">LOW</option>
                                        <option value="h">HIGH</option>
                                    </select>
                                </td>
                                <td>
                                    <select2 :options="seams" v-model="formData.barging_material[i].seam_id" data-placeholder="Seam">
                                    </select2>
                                </td>
                                <td>
                                    <input type="text" v-model="formData.barging_material[i].volume" class="form-control" placeholder="Volume">
                                </td>
                                <td>
                                    <button type="button" @click="delCargo(i)" class="btn btn-danger"><i class="icon-trash"></i></button>
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
