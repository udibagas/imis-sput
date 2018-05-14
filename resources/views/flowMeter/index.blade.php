@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">FLOW METER <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            @can('create', App\FlowMeter::class)
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
            @endcan
            @can('export', App\FlowMeter::class)
            <a href="#" class="btn btn-primary"><i class="icon-download"></i> EXPORT</a>
            @endcan
            @can('import', App\FlowMeter::class)
            <a href="#" class="btn btn-primary"><i class="icon-upload"></i> IMPORT</a>
            @endcan
        </span>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="date">Date</th>
                    <th data-column-id="trx" data-formatter="trx">Trx</th>
                    <th data-column-id="status" data-formatter="status">Status</th>
                    <th data-column-id="fuel_tank">Fuel Tank</th>
                    <th data-column-id="flowmeter_start">Flowmeter Start</th>
                    <th data-column-id="flowmeter_end">Flowmeter End</th>
                    <th data-column-id="sounding_start">Sounding Start</th>
                    <th data-column-id="sounding_end">Sounding End</th>
                    <th data-column-id="volume_by_flowmeter" data-formatter="volume_by_flowmeter">Volume By FLow Meter</th>
                    <th data-column-id="volume_by_sounding">Volume By Sounding</th>
                    <th data-column-id="selisih" data-formatter="selisih">Selisih Volume</th>
                    @can('updateOrDelete', App\FlowMeter::class)
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

    @can('createOrUpdate', App\FlowMeter::class)
    @include('flowMeter._form')
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
            statuses: {
                'T': 'Transfer',
                'R': 'Receive',
                'I': 'Issued'
            },
            fuel_tanks: {!! App\FuelTank::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        },
        methods: {
            add: function() {
                this.formTitle = "ADD FLOW METER";
                this.formData = {
                    date: '{{date("Y-m-d")}}',
                };
                this.formErrors = {};
                this.error = {};
                $('#modal-form').modal('show');
            },
            store: function() {
                block('form');
                var _this = this;
                axios.post('{{url("flowMeter")}}', this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil ditambahkan");
                    $('#bootgrid').bootgrid('reload');
                })

                .catch(function(error) {
                    unblock('form');
                    if (error.response.status == 422) {
                        _this.formErrors = error.response.data.errors;
                        _this.error = {};

                    }

                    if (error.response.status == 500) {
                        _this.error = error.response.data;
                        _this.formErrors = {};
                    }
                });
            },
            edit: function(id) {
                var t = this;
                this.formTitle = "EDIT FLOW METER";
                this.formErrors = {};
                this.error = {};

                axios.get('{{url("flowMeter")}}/' + id).then(function(r) {
                    t.formData = r.data;
                    $('#modal-form').modal('show');
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                });
            },
            update: function() {
                block('form');
                var _this = this;
                axios.put('{{url("flowMeter")}}/' + this.formData.id, this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil diupdate");
                    $('#bootgrid').bootgrid('reload');
                })

                .catch(function(error) {
                    unblock('form');
                    if (error.response.status == 422) {
                        _this.formErrors = error.response.data.errors;
                        _this.error = {};
                    }

                    if (error.response.status == 500) {
                        _this.error = error.response.data;
                        _this.formErrors = {};
                    }
                });
            },
            delete: function(id) {
                bootbox.confirm({
                    title: "Konfirmasi",
                    message: "Anda yakin akan menghapus data ini?",
                    callback: function(r) {
                        if (r == true) {
                            axios.delete('{{url("flowMeter")}}/' + id)

                            .then(function(r) {
                                if (r.data.success == true) {
                                    toastr["success"]("Data berhasil dihapus");
                                    $('#bootgrid').bootgrid('reload');
                                } else {
                                    toastr["error"]("Data gagal dihapus. " + r.data.message);
                                }
                            })

                            .catch(function(error) {
                                var error = error.response.data;
                                toastr["error"](error.message + ". " + error.file + ":" + error.line)
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
                statusMapping: {
                    0: 'default',
                    1: 'default',
                },
                ajax: true, url: '{{url('flowMeter')}}',
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
                        return '@can("update", App\FlowMeter::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                            '@can("delete", App\FlowMeter::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                    },
                    "trx": function(column, row) {
                        return row.flowmeter_start - row.flowmeter_end > 0 ? 'IN' : 'OUT';
                    },
                    "volume_by_flowmeter": function(column, row) {
                        return row.flowmeter_end - row.flowmeter_start;
                    },
                    "selisih": function(column, row) {
                        return row.volume_by_sounding - (row.flowmeter_end - row.flowmeter_start);
                    },
                    "status": function(column, row) {
                        return t.statuses[row.status];
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
