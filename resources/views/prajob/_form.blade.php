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

                    <div class="form-group" :class="formErrors.tgl ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl">Date
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <vue-datepicker v-model="formData.tgl" placeholder="Date">
                            </vue-datepicker>
                            <span v-if="formErrors.tgl" class="help-block">@{{formErrors.tgl[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.employee_id ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="employee_id">Employee
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select2 :options="employees" v-model="formData.employee_id" data-placeholder="Employee">
                            </select2>
                            <span v-if="formErrors.employee_id" class="help-block">@{{formErrors.employee_id[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.shift ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shift">Shift
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.shift" id="shift_1" value="1">
								<label for="shift_1">1</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.shift" id="shift_2" value="2">
								<label for="shift_2">2</label>
							</div>
                            <span v-if="formErrors.shift" class="help-block">@{{formErrors.shift[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.jam_tidur ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jam_tidur">Jam Mulai Tidur
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.jam_tidur" class="form-control" placeholder="Jam mulai tidur hari ini">
                                    <span v-if="formErrors.jam_tidur" class="help-block">@{{formErrors.jam_tidur[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.jam_tidur_last" class="form-control" placeholder="Jam mulai tidur kemarin" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.jam_bangun ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jam_bangun">Jam Bangun
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.jam_bangun" class="form-control" placeholder="Jam bangun hari ini">
                                    <span v-if="formErrors.jam_bangun" class="help-block">@{{formErrors.jam_bangun[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.jam_bangun_last" class="form-control" placeholder="Jam bangun kemarin" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.bpm || formErrors.spo ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="BPM">BPM/SPO
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.bpm" class="form-control" placeholder="BPM">
                                    <span v-if="formErrors.bpm" class="help-block">@{{formErrors.bpm[0]}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" v-model="formData.spo" class="form-control" placeholder="SPO">
                                    <span v-if="formErrors.spo" class="help-block">@{{formErrors.spo[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.minum_obat ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="minum_obat">Minum Obat?
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.minum_obat" id="minum_obat_yes" value="1">
								<label for="minum_obat_yes">YA</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.minum_obat" id="minum_obat_no" value="0">
								<label for="minum_obat_no">TIDAK</label>
							</div>
                            <span v-if="formErrors.minum_obat" class="help-block">@{{formErrors.minum_obat[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.ada_masalah ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ada_masalah">Ada Masalah?
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.ada_masalah" id="ada_masalah_yes" value="1">
								<label for="ada_masalah_yes">YA</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.ada_masalah" id="ada_masalah_no" value="0">
								<label for="ada_masalah_no">TIDAK</label>
							</div>
                            <span v-if="formErrors.ada_masalah" class="help-block">@{{formErrors.ada_masalah[0]}}</span>
                        </div>
                    </div>

                    <div class="form-group" :class="formErrors.siap_bekerja ? 'has-error' : ''">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="siap_bekerja">Siap Bekerja?
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.siap_bekerja" id="siap_bekerja_yes" value="1">
								<label for="siap_bekerja_yes">YA</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.siap_bekerja" id="siap_bekerja_no" value="0">
								<label for="siap_bekerja_no">TIDAK</label>
							</div>
                            <span v-if="formErrors.siap_bekerja" class="help-block">@{{formErrors.siap_bekerja[0]}}</span>
                        </div>
                    </div>

                    <div v-if="formData.id !== undefined" class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="approval_status">Rekomendasi
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio radio-inline radio-replace radio-success">
								<input type="radio" v-model="formData.approval_status" id="approval_status_1" value="1">
								<label for="approval_status_1">Disetujui</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-warning">
								<input type="radio" v-model="formData.approval_status" id="approval_status_2" value="2">
								<label for="approval_status_2">Butuh Pengawasan</label>
							</div>
                            <div class="radio radio-inline radio-replace radio-danger">
								<input type="radio" v-model="formData.approval_status" id="approval_status_3" value="3">
								<label for="approval_status_3">Tidak Boleh Bekerja</label>
							</div>
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
