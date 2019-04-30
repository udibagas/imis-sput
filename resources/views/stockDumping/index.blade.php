@extends('layouts.app')

@section('content')

<div class="row" id="app">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3 class="pull-left text-primary">STOCK DUMPING <small>Manage</small></h3>
            <span class="pull-right" style="margin:15px 0 15px 10px;">
                @can('create', App\StockDumping::class)
                <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
                @endcan
                @can('create', App\StockDumping::class)
                <a href="#" class="btn btn-primary"><i class="fa fa-upload"></i> IMPORT</a>
                @endcan
                <a href="{{url('stockDumping/downloadApp')}}" class="btn btn-primary"><i class="fa fa-android"></i> DOWNLOAD APLIKASI CHECKER</a>
                @can('export', App\StockDumping::class)
                <a href="#" @click="openExportForm" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> EXPORT</a>
                @endcan
            </span>
            <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
                <thead>
                    <tr>
                        <th data-column-id="id" data-width="3%">ID</th>
                        <th data-column-id="date">Date</th>
                        <th data-column-id="shift">Shift</th>
                        <th data-column-id="time">Time</th>
                        <th data-column-id="subcont">Subcont</th>
                        <th data-column-id="unit">Unit</th>
                        <th data-column-id="material_type" data-formatter="material_type">Material Type</th>
                        <th data-column-id="seam">Seam</th>
                        <th data-column-id="block_area">Block Area</th>
                        <th data-column-id="sa">Stock Area</th>
                        <th data-column-id="volume">Volume (KG)</th>
                        @if (!auth()->user()->customer_id)
                        <th data-column-id="customer">Customer</th>
                        @endif
                        @if (!auth()->user()->contractor_id)
                        <th data-column-id="contractor">Contractor</th>
                        @endif
                        <th data-column-id="register_number">Register Number</th>
                        <th data-column-id="user">User</th>
                        <th data-column-id="insert_via">Insert Via</th>
                        @can('updateOrDelete', App\StockDumping::class)
                        <th data-column-id="commands"
                            data-formatter="commands"
                            data-sortable="false"
                            data-align="right"
                            data-header-align="right"></th>
                        @endcan
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @can('createOrUpdate', App\StockDumping::class)
    @include('stockDumping._form')
    @endcan

    @can('export', App\StockDumping::class)
    @include('stockDumping._form_export')
    @endcan

</div>

@endsection

@push('scripts')

<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');

const app = new Vue({
    el: '#app',
    data: {
        formData: {},
        formErrors: {},
        formTitle: '',
        error: {},
        date: '{{date("Y-m-d")}}',
        exportRange: {
            from: '{{date("Y-m-d")}}',
            to: '{{date("Y-m-d")}}'
        },
        ritase: 0,
        tonase: 0,
        stock_areas: [],
        subconts: {!! App\Subcont::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        seams: {!! App\Seam::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        customers: {!! App\Customer::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        contractors: {!! App\Contractor::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        areas: {!! App\Area::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        subcont_units: {!! App\SubcontUnit::selectRaw('id AS id, code_number AS text, subcont_id')->orderBy('code_number', 'ASC')->get() !!},
        allStockAreas: {!! App\StockArea::selectRaw('id AS id, name AS text, area_id')->orderBy('name', 'ASC')->get() !!},
        default_material: {!! App\DefaultMaterial::all() !!},
    },
    watch: {
        'formData.subcont_unit_id': function(v, o) {
            if (v) {
                this.formData.subcont_id = this.subcont_units.filter(function(s) {
                    return s.id == v;
                })[0].subcont_id;
            }
        },
        'formData.area_id': function(v, o) {
            var _this = this;

            if (this.formData.id) {
                return;
            }

            if (v) {
                this.stock_areas = this.allStockAreas.filter(function(u) {
                    return u.area_id == v;
                });

                setTimeout(function() {
                    _this.formData.stock_area_id = _this.stock_areas[0].id;
                }, 10);
            } else {
                this.stock_areas = [];
            }
        },
        'formData.contractor_id': function(v, o) {
            if (this.formData.id) {
                return;
            }

            if (v && this.formData.customer_id) {
                var _this = this;
                var dm = this.default_material.filter(function(d) {
                    return d.contractor_id == v && d.customer_id == _this.formData.customer_id;
                });

                if (dm.length > 0) {
                    this.formData.material_type = dm[0].material_type;
                    this.formData.seam_id = dm[0].seam_id;
                } else {
                    this.formData.material_type = '';
                    this.formData.seam_id = 0;
                }
            }
        },
        'formData.customer_id': function(v, o) {
            if (this.formData.id) {
                return;
            }

            if (v) {
                var dm = this.default_material.filter(function(d) {
                    return d.customer_id == v;
                });

                if (dm.length > 0) {
                    this.formData.contractor_id = dm[0].contractor_id;
                    this.formData.material_type = dm[0].material_type;
                    this.formData.seam_id = dm[0].seam_id;
                } else {
                    this.formData.contractor_id = 0;
                    this.formData.material_type = '';
                    this.formData.seam_id = 0;
                }
            }
        }
    },
    methods: {
        getTonase: function() {
            var _this = this;

            axios.get('{{url("stockDumping/tonase")}}?from=' + _this.date + '&to=' + _this.date)
                .then(function(r) {
                    _this.tonase = r.data[0].tonase ? r.data[0].tonase : 0;
                    _this.ritase = r.data[0].ritase ? r.data[0].ritase : 0;
                })
                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                });

            setTimeout(this.getTonase, 3000);
        },
        openExportForm: function() {
            $('#modal-form-export').modal('show');
        },
        doExport: function() {
            // TODO: validate input first
            $('#modal-form-export').modal('hide');
            window.location = '{{url("stockDumping/export")}}?from=' + this.exportRange.from + '&to=' + this.exportRange.to;
        },
        add: function() {
            // reset the form
            this.formTitle = "ADD STOCK DUMPING";

            this.formData = {
                date: moment().format('YYYY-MM-DD'),
                time: moment().format('HH:mm'),
                shift: (moment().format('H') >= 5 && moment().format('H') < 17) ? 1 : 2,
                customer_id: '{{auth()->user()->customer_id}}',
            };

            var customer_id = '{{auth()->user()->customer_id}}';

            if (customer_id) {
                var dm = this.default_material.filter(function(d) {
                    return d.customer_id == customer_id;
                });

                if (dm.length > 0) {
                    this.formData.contractor_id = dm[0].contractor_id;
                    this.formData.material_type = dm[0].material_type;
                    this.formData.seam_id = dm[0].seam_id;
                } else {
                    this.formData.contractor_id = 0;
                    this.formData.material_type = '';
                    this.formData.seam_id = 0;
                }
            }

            this.formErrors = {};
            this.error = {};
            // open form
            $('#modal-form').modal('show');
        },
        store: function() {
            block('form');
            var t = this;
            axios.post('{{url("stockDumping")}}', this.formData)
                .then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil ditambahkan");
                    $('#bootgrid').bootgrid('reload');
                })
                .catch(function(error) {
                    unblock('form');
                    if (error.response.status == 422) {
                        t.error = {};
                        t.formErrors = error.response.data.errors;
                    }

                    if (error.response.status == 500) {
                        t.formErrors = {};
                        t.error = error.response.data;
                    }
                });
        },
        edit: function(id) {
            var t = this;
            this.formTitle = "EDIT STOCK DUMPING";
            this.formErrors = {};
            this.error = {};
            this.stock_areas = this.allStockAreas;

            axios.get('{{url("stockDumping")}}/' + id).then(function(r) {
                t.formData = r.data;
                t.formData.subcont_id = r.data.subcont_unit.subcont_id;
                t.formData.area_id = r.data.stock_area.area_id;
                $('#modal-form').modal('show');
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });
        },
        update: function() {
            block('form');
            var t = this;
            axios.put('{{url("stockDumping")}}/' + this.formData.id, this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil diupdate");
                $('#bootgrid').bootgrid('reload');
            })
            // validasi
            .catch(function(error) {
                unblock('form');
                if (error.response.status == 422) {
                    t.error = {};
                    t.formErrors = error.response.data.errors;
                }

                if (error.response.status == 500) {
                    t.formErrors = {};
                    t.error = error.response.data;
                }
            });
        },
        delete: function(id) {
            bootbox.confirm({
                title: "Konfirmasi",
                message: "Anda yakin akan menghapus data ini?",
                callback: function(r) {
                    if (r == true) {
                        axios.delete('{{url("stockDumping")}}/' + id)

                        .then(function(r) {
                            if (r.data.success == true) {
                                toastr["success"]("Data berhasil dihapus");
                                $('#bootgrid').bootgrid('reload');
                            } else {
                                toastr["error"]("Data gagal dihapus. " + r.data.message);
                            }
                        })

                        .catch(function(error) {
                            if (error.response.status == 500) {
                                var error = error.response.data;
                                toastr["error"](error.message + ". " + error.file + ":" + error.line)
                            }
                        });
                    }
                }
            });
        },
    },
    mounted: function() {
        var t = this;
        t.getTonase();

        var grid = $('#bootgrid').bootgrid({
            statusMapping: {
                0: "default",
                1: "default"
            },
            rowCount: [10,25,50,100],
            ajax: true, url: '{{url('stockDumping')}}',
            ajaxSettings: {
                method: 'GET', cache: false,
                statusCode: {
                    500: function(e) {
                        var error = JSON.parse(e.responseText);
                        toastr["error"](error.message + ". " + error.file + ":" + error.line)
                    }
                }
            },
            searchSettings: { delay: 100, characters: 3 },
            templates: {
                header: '<div id="@{{ctx.id}}" class="pull-right @{{css.header}}"><div class="actionBar"><p class="@{{css.search}}"></p><p class="@{{css.actions}}"></p></div></div>'
            },
            formatters: {
                "commands": function(column, row) {
                    return '@can("update", App\StockDumping::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                        '@can("delete", App\StockDumping::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                },
                material_type: function(c, r) {
                    return r.material_type == 'l' ? 'LOW' : 'HIGH';
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function() {
            grid.find(".c-delete").on("click", function(e) {
                t.delete($(this).data("id"));
            });

            grid.find(".c-edit").on("click", function(e) {
                t.edit($(this).data("id"));
            });
        });

    }
});

</script>

@endpush
