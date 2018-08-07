@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">PORT ACTIVITY <small>Manage</small></h3>
        @can('create', App\PortActivity::class)
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
        </span>
        @endcan
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="date">Date</th>
                    <th data-column-id="shift">Shift</th>
                    <th data-column-id="time_start">Time Start</th>
                    <th data-column-id="time_end">Time End</th>
                    <th data-column-id="activity" data-formatter="activity" data-sortable="false">Activity</th>
                    <th data-column-id="unit">Unit</th>
                    <th data-column-id="hauler">Hauler</th>
                    <th data-column-id="area">Area</th>
                    <th data-column-id="stock_area">Stock Area</th>
                    <th data-column-id="jetty">Jetty</th>
                    <th data-column-id="hopper">Hopper</th>
                    <th data-column-id="rit">Bucket</th>
                    <th data-column-id="volume">Volume (Ton)</th>
                    <th data-column-id="material_type" data-formatter="material_type">Material Type</th>
                    <th data-column-id="seam">Seam</th>
                    <th data-column-id="customer">Customer</th>
                    <th data-column-id="employee">Employee</th>
                    @can('updateOrDelete', App\PortActivity::class)
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

    @can('createOrUpdate', App\PortActivity::class)
    @include('portActivity._form')
    @endcan

</div>

@endsection

@push('scripts')

<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        showHaulerList: false,
        showHopperList: false,
        showBucketInput: false,
        showVolumeInput: false,
        showMaterialStockList: false,
        formData: {},
        formErrors: {},
        formTitle: '',
        error: {},
        material_stocks: {!!App\MaterialStock::getList()!!},
        units: {!! App\Unit::selectRaw('id AS id, name AS text')
            ->where('name', 'LIKE', 'ld%')
            ->orWhere('name', 'LIKE', 'wl%')
            ->orderBy('name', 'ASC')->get() !!},
        haulers: {!! App\Unit::selectRaw('id AS id, name AS text')
            ->where('name', 'LIKE', 'ld%')
            ->orderBy('name', 'ASC')->get() !!},
        employees: {!! App\Employee::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        // stock_areas: {!! App\StockArea::selectRaw('stock_areas.id AS id, CONCAT(areas.name, " - ", stock_areas.name) AS text')
            ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
            ->orderBy('areas.name', 'ASC')->get() !!},
        hoppers: {!! App\Hopper::selectRaw('hoppers.id AS id, CONCAT(jetties.name, " - ", hoppers.name) AS text')
            ->join('jetties', 'jetties.id', '=', 'hoppers.jetty_id')
            ->orderBy('jetties.name', 'ASC')->get() !!},
        // seams: {!! App\Seam::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        // customers: {!! App\Customer::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        unit_activities: {!! json_encode(App\PortActivity::getActivityList()) !!},
    },
    watch: {
        'formData.unit_activity_id': function(v, o) {
            // dari stock area ke depan hopper
            if (v == {{App\PortActivity::ACT_HAULING}} || v == {{App\PortActivity::ACT_LOAD_AND_CARRY}}) {
                this.showHopperList = true;
                this.showBucketInput = true,
                this.showVolumeInput = true;
                this.showHaulerList = false;
                this.showMaterialStockList = true;
            }

            // oleh WA umpan dari Hauler, dari depan hoper
            else if (v == {{App\PortActivity::ACT_FEEDING}}) {
                this.showHopperList = true;
                this.showHaulerList = false;
                this.showMaterialStockList = false;
                this.showBucketInput = true,
                this.showVolumeInput = true;
            }

            // oleh WA ke hauler
            else if (v == {{App\PortActivity::ACT_LOADING}}) {
                this.showHopperList = false;
                this.showHaulerList = true;
                this.showMaterialStockList = true;
                this.showBucketInput = true,
                this.showVolumeInput = true;
            }

            // oleh WA
            else if (v == {{App\PortActivity::ACT_STOCKPILING}}) {
                this.showHopperList = false;
                this.showBucketInput = true,
                this.showVolumeInput = true;
                this.showHaulerList = false;
                this.showMaterialStockList = true;
            }

            else {
                this.showHopperList = false;
                this.showBucketInput = false,
                this.showVolumeInput = false;
                this.showHaulerList = false;
                this.showMaterialStockList = false;
            }
        }
    },
    methods: {
        add: function() {
            this.formTitle = "ADD PORT ACTIVITY";
            this.formData = {
                date: '{{date("Y-m-d")}}',
                shift: (moment().format('H') >= 6 && moment().format('H')) <= 18 ? 1 : 2,
                time_start: moment().format('HH:mm'),
                showHaulerList: false,
                showHopperList: false,
                showBucketInput: false,
                showVolumeInput: false,
                showMaterialStockList: false,
            };
            this.formErrors = {};
            this.error = {};
            $('#modal-form').modal('show');
        },
        store: function() {
            block('form');
            var t = this;
            axios.post('{{url("portActivity")}}', this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil ditambahkan");
                $('#bootgrid').bootgrid('reload');
            })
            .catch(function(error) {
                unblock('form');
                if (error.response.status == 422) {
                    t.formErrors = error.response.data.errors;
                }

                if (error.response.status == 500) {
                    t.error = error.response.data;
                }
            });
        },
        edit: function(id) {
            var t = this;
            this.formTitle = "EDIT PORT ACTIVITY";
            this.formErrors = {};
            this.error = {};

            axios.get('{{url("portActivity")}}/' + id).then(function(r) {
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
            axios.put('{{url("portActivity")}}/' + this.formData.id, this.formData).then(function(r) {
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
                }

                if (error.response.status == 500) {
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
                        axios.delete('{{url("portActivity")}}/' + id)

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
            statusMapping: {
                0: "default",
                1: "default"
            },
            rowCount: [10,25,50,100],
            ajax: true, url: '{{url('portActivity')}}',
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
                    return '@can("update", App\PortActivity::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                        '@can("delete", App\PortActivity::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                },
                material_type: function(c, r) {
                    return r.material_type == 'l' ? 'LOW' : 'HIGH';
                },
                activity: function(c, r) {
                    return t.unit_activities.filter(a => a.id == r.unit_activity_id)[0].text;
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
