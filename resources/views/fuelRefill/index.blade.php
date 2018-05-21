@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">FUEL REFILL <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            @can('create', App\FuelRefill::class)
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
            @endcan
            <a href="{{url('fuelRefill/downloadApp')}}" class="btn btn-primary"><i class="fa fa-android"></i> DOWNLOAD APLIKASI</a>
            @can('export', App\FuelRefill::class)
            <a href="#" @click="openExportForm" class="btn btn-primary"><i class="icon-download"></i> EXPORT</a>
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

                    <th data-column-id="total_real"
                        data-align="right"
                        data-header-align="right"
                        data-formatter="total_real">QTY</th>

                    <th data-column-id="km"
                        data-align="right"
                        data-header-align="right"
                        data-formatter="km">KM</th>

                    <th data-column-id="hm"
                        data-align="right"
                        data-header-align="right"
                        data-formatter="hm">HM</th>

                    <th data-column-id="km_last"
                        data-align="right"
                        data-header-align="right"
                        data-formatter="km_last">KM Last</th>

                    <th data-column-id="hm_last"
                        data-align="right"
                        data-header-align="right"
                        data-formatter="hm_last">HM Last</th>

                    <th data-column-id="employee_name">Employee</th>
                    <th data-column-id="start_time"
                        data-align="center"
                        data-header-align="center"
                        data-formatter="time">Time</th>

                    <th data-column-id="duration"
                        data-align="center"
                        data-header-align="center"
                        data-sortable="false"
                        data-formatter="duration">Duration</th>

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

    @can('export', App\FuelRefill::class)
    @include('fuelRefill._form_export')
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
            exportRange: {
                from: '{{date("Y-m-d")}}',
                to: '{{date("Y-m-d")}}'
            },
            units: {!! App\Unit::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
            fuel_tanks: {!! App\FuelTank::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
            employees: {!! App\Employee::selectRaw('id AS id, CONCAT(nrp, " - ", name) AS text')->orderBy('name', 'ASC')->get() !!},
        },
        watch: {
            'formData.unit_id': function(val) {
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
            openExportForm: function() {
                $('#modal-form-export').modal('show');
            },
            doExport: function() {
                // TODO: validate input first
                $('#modal-form-export').modal('hide');
                window.location = '{{url("fuelRefill/export")}}?from=' + this.exportRange.from + '&to=' + this.exportRange.to;
            },
            formatNumber: function(v) {
                return parseFloat(v)
                    .toFixed(0)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            add: function() {
                this.formTitle = "ADD FUEL REFILL";
                this.formErrors = {};
                this.error = {};

                this.formData = {
                    date        : moment().format('YYYY-MM-DD'),
                    shift       : (moment().format('h') >= 7 && moment().format('h') <= 19) ? 1 : 2,
                    start_time  : moment().format('hh:mm'),
                    finish_time : moment().add(3, 'minutes').format('hh:mm'),
                    insert_via  : 'web',
                };

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
                        return row.start_time + "-" + row.finish_time;
                    },
                    duration: function(column, row) {
                        // masih salah
                        var start = moment(row.start_time, "hh:ii");
                        var finish = moment(row.finish_time, "hh:ii");
                        var duration = moment.duration(finish.diff(start));
                        return finish.utc(duration.asMilliseconds()).format("mm:ss");
                    },
                    total_real: function(column, row) {
                        return t.formatNumber(row.total_real);
                    },
                    km: function(column, row) {
                        return t.formatNumber(row.km);
                    },
                    hm: function(column, row) {
                        return t.formatNumber(row.hm);
                    },
                    km_last: function(column, row) {
                        return row.km_last ? t.formatNumber(row.km_last) : '';
                    },
                    hm_last: function(column, row) {
                        return row.hm_last ? t.formatNumber(row.hm_last) : '';
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
