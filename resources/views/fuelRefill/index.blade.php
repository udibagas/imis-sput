@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">FUEL REFILL <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            @can('create', App\FuelRefill::class)
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
            @endcan
            @can('export', App\FuelRefill::class)
            <a href="#" class="btn btn-primary"><i class="icon-download"></i> EXPORT</a>
            @endcan
            @can('import', App\FuelRefill::class)
            <a href="#" class="btn btn-primary"><i class="icon-upload"></i> IMPORT</a>
            @endcan
        </span>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="date">Date</th>
                    <th data-column-id="fuel_tank">Fuel Tank</th>
                    <th data-column-id="unit">Unit</th>
                    <th data-column-id="unit_category">Unit Category</th>
                    <th data-column-id="shift">Shift</th>
                    <th data-column-id="total_real">QTY</th>
                    <th data-column-id="km">KM</th>
                    <th data-column-id="hm">HM</th>
                    <th data-column-id="km_last">KM Last</th>
                    <th data-column-id="hm_last">HM Last</th>
                    <th data-column-id="employee_name">Employee</th>
                    <th data-column-id="start_time" data-formatter="time">Time</th>
                    <!-- <th data-column-id="finish_time">Finish Time</th> -->
                    <th data-column-id="duration">Duration</th>
                    <th data-column-id="insert_by">Insert By</th>
                    @can('updateOrDelete', App\FuelRefill::class)
                    <th data-column-id="commands" data-width="5%"
                        data-formatter="commands"
                        data-sortable="false"
                        data-align="right"
                        data-header-align="right"></th>
                    @endcan
                </tr>
            </thead>
        </table>
    </div>

    @can('createOrUpdate', App\FuelRefill::class)
    @include('fuelRefill._form')
    @endcan

</div>

@endsection

@push('scripts')

<script type="text/javascript">

    const app = new Vue({
        el: '#app',
        data: {
            formData: {},
            formErrors: {},
            formTitle: '',
            error: {},
            units: {!! App\Unit::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
            fuel_tanks: {!! App\FuelTank::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
            employees: {!! App\Employee::selectRaw('id AS id, CONCAT(nrp, " - ", name) AS text')->orderBy('name', 'ASC')->get() !!},
        },
        computed: {
            unitId: function() {
                return this.formData.unit_id;
            }
        },
        watch: {
            unitId: function(val) {
                if (!val) {
                    return;
                }

                var _this = this;
                axios.get('{{url("fuelRefill/getLastRefill")}}/' + val)
                .then(function(r) {
                    _this.formData.km_last = r.data.km;
                    _this.formData.hm_last = r.data.hm;
                    _this.$forceUpdate();
                })
                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                });
            }
        },
        methods: {
            add: function() {
                // reset the form
                this.formTitle = "ADD FUEL REFILL";
                this.formData = {
                    date: '{{date("Y-m-d")}}',
                    insert_via: 'web'
                };
                this.formErrors = {};
                this.error = {};
                // open form
                $('#modal-form').modal('show');
            },
            store: function() {
                block('form');
                var t = this;
                axios.post('{{url("fuelRefill")}}', this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil ditambahkan");
                    $('#bootgrid').bootgrid('reload');
                })
                // validasi
                .catch(function(error) {
                    unblock('form');
                    if (error.response.status == 422) {
                        t.formErrors = error.response.data.errors;
                        t.error = {};
                    }

                    if (error.response.status == 500) {
                        t.error = error.response.data;
                        t.formErrors = {};
                    }
                });
            },
            edit: function(id) {
                var t = this;
                this.formTitle = "EDIT FUEL REFILL";
                this.formErrors = {};
                this.error = {};

                axios.get('{{url("fuelRefill")}}/' + id).then(function(r) {
                    t.formData = r.data;
                    $('#modal-form').modal('show');
                })

                .catch(function(error) {
                    if (error.response.status == 500) {
                        var error = error.response.data;
                        toastr["error"](error.message + ". " + error.file + ":" + error.line)
                    }
                });
            },
            update: function() {
                block('form');
                var t = this;
                axios.put('{{url("fuelRefill")}}/' + this.formData.id, this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil diupdate");
                    $('#bootgrid').bootgrid('reload');
                })
                // validasi
                .catch(function(error) {
                    unblock('form');
                    if (error.response.status == 422) {
                        t.formErrors = error.response.data.errors;
                        t.error = {};
                    }

                    if (error.response.status == 500) {
                        t.error = error.response.data;
                        t.formErrors = {};
                    }
                });
            },
            delete: function(id) {
                bootbox.confirm({
                    title: "Konfirmasi",
                    message: "Anda yakin akan menghapus data ini?",
                    callback: function(r) {
                        if (r == true) {
                            axios.delete('{{url("fuelRefill")}}/' + id)

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

            var grid = $('#bootgrid').bootgrid({
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('fuelRefill')}}',
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
                        return '@can("update", App\FuelRefill::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                            '@can("delete", App\FuelRefill::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                    },
                    "time": function(column, row) {
                        return row.start_time + " - " + row.finish_time;
                    },
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
