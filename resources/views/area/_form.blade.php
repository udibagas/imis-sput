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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Name
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.name" class="form-control" placeholder="Name">
                            <span v-if="formErrors.name" class="help-block">@{{formErrors.name[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.capacity ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="capacity">Capacity (Ton)
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" v-model="formData.capacity" class="form-control" placeholder="Capacity">
                            <span v-if="formErrors.capacity" class="help-block">@{{formErrors.capacity[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.description ? 'has-error' : ''">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="description">Description
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" v-model="formData.description" class="form-control" placeholder="Description">
                            <span v-if="formErrors.description" class="help-block">@{{formErrors.description[0]}}</span>
                        </div>
                    </div>

                    <table class="table table-striped table-hover" style="margin-bottom:0;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subarea</th>
                                <th>Capacity</th>
                                <th>Description</th>
                                <th class="text-right">
                                    <a href="#" @click="addSubArea" class="btn btn-primary"><i class="icon-plus"></i></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(s,i) in formData.sub_area">
                                <td>@{{i+1}}</td>
                                <td>
                                    <input type="hidden" v-model="formData.sub_area[i].id">
                                    <input type="text" v-model="formData.sub_area[i].name" class="form-control">
                                </td>
                                <td>
                                    <input type="text" v-model="formData.sub_area[i].capacity" class="form-control">
                                </td>
                                <td>
                                    <input type="text" v-model="formData.sub_area[i].description" class="form-control">
                                </td>
                                <td class="text-right">
                                    <a href="#" @click="delSubArea(i)" class="btn btn-danger"><i class="icon-trash"></i></a>
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
