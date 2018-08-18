@extends('layouts.app')

@section('content')

<div id="app">
    <form class="form-inline pull-right">
        <div class="input-group">
            <vue-datepicker placeholder="From" v-model="summary_from"> </vue-datepicker>
            <div class="input-group-addon">To</div>
            <vue-datepicker placeholder="To" v-model="summary_to"> </vue-datepicker>
        </div>
    </form>
    <h3>PRODUCTIVITY SUMMARY</h3>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <port-activity-summary :from="summary_from" :to="summary_to"></port-activity-summary>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <productivity :from="summary_from" :to="summary_to"></productivity>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-body">
            <h3 class="pull-left text-primary">PORT ACTIVITY <small>Manage</small></h3>
            <span class="pull-right" style="margin:15px 0 15px 10px;">
                @can('create', App\PortActivity::class)
                <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
                @endcan
                @can('export', App\PortActivity::class)
                <a href="#" @click="openExportForm" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> EXPORT</a>
                @endcan
            </span>
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
                        <th data-column-id="hpr">Hopper</th>
                        <th data-column-id="rit">Bucket</th>
                        <th data-column-id="volume">Volume (KG)</th>
                        <th data-column-id="material_type" data-formatter="material_type">Material Type</th>
                        <th data-column-id="seam">Seam</th>
                        <th data-column-id="customer">Customer</th>
                        <th data-column-id="employee">Employee</th>
                        <th data-column-id="user">User</th>
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

        @can('export', App\PortActivity::class)
        @include('portActivity._form_export')
        @endcan

    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({
    el: '#app',
    data: {
        times: [
            {id: '00:00', text: '00:00'},
            {id: '01:00', text: '01:00'},
            {id: '02:00', text: '02:00'},
            {id: '03:00', text: '03:00'},
            {id: '04:00', text: '04:00'},
            {id: '05:00', text: '05:00'},
            {id: '06:00', text: '06:00'},
            {id: '07:00', text: '07:00'},
            {id: '08:00', text: '08:00'},
            {id: '09:00', text: '09:00'},
            {id: '10:00', text: '10:00'},
            {id: '11:00', text: '11:00'},
            {id: '12:00', text: '12:00'},
            {id: '13:00', text: '13:00'},
            {id: '14:00', text: '14:00'},
            {id: '15:00', text: '15:00'},
            {id: '16:00', text: '16:00'},
            {id: '17:00', text: '17:00'},
            {id: '18:00', text: '18:00'},
            {id: '19:00', text: '19:00'},
            {id: '20:00', text: '20:00'},
            {id: '21:00', text: '21:00'},
            {id: '22:00', text: '22:00'},
            {id: '23:00', text: '23:00'},
        ],
        exportRange: {
            from: '{{date("Y-m-d")}}',
            to: '{{date("Y-m-d")}}'
        },
        showHaulerList: false,
        showHopperList: false,
        showBucketInput: false,
        showVolumeInput: false,
        showMaterialStockList: false,
        formData: {},
        formErrors: {},
        formTitle: '',
        error: {},
        summary_from: '{{date("Y-m-01")}}',
        summary_to: '{{date("Y-m-d")}}',
        material_stocks: {!!App\MaterialStock::getList()!!},
        units: {!! App\Unit::selectRaw('units.id AS id, units.name AS text, egis.mt_per_bucket_hi AS mt_per_bucket_hi, egis.mt_per_bucket_lo AS mt_per_bucket_lo')
            ->join('egis', 'egis.id', '=', 'units.egi_id')
            ->where('units.name', 'LIKE', 'ld%')
            ->orWhere('units.name', 'LIKE', 'wl%')
            ->orderBy('units.name', 'ASC')->get() !!},
        haulers: {!! App\Unit::selectRaw('id AS id, name AS text')
            ->where('name', 'LIKE', 'ld%')
            ->orderBy('name', 'ASC')->get() !!},
        employees: {!! App\Employee::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        jetties: {!! App\Jetty::selectRaw('id AS id, name AS text') ->orderBy('name', 'ASC')->get() !!},
        hoppers: {!! App\Hopper::selectRaw('id AS id, name AS text, jetty_id AS jetty_id') ->orderBy('name', 'ASC')->get() !!},
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
        },
        'formData.jetty_id': function(v, o) {
            this.formData.hopper_id = null
        },
        // 'formData.bucket': function(v, o) {
        //     var unit = this.units.filter(u => u.id == this.formData.unit_id)[0];
        //     var mt_per_bucket = (this.formData.material_type == 'l') ? unit.mt_per_bucket_lo :  unit.mt_per_bucket_hi;
        //     this.formData.volume = v * mt_per_bucket;
        // }
    },
    methods: {
        openExportForm: function() {
            $('#modal-form-export').modal('show');
        },
        doExport: function() {
            // TODO: validate input first
            $('#modal-form-export').modal('hide');
            window.location = '{{url("portActivity/export")}}?from=' + this.exportRange.from + '&to=' + this.exportRange.to;
        },
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

                if (r.data.hopper) {
                    t.formData.jetty_id = r.data.hopper.jetty_id;
                    t.formData.hopper_id = r.data.hopper_id;
                }

                setTimeout(function() {
                    $('#modal-form').modal('show');
                }, 100);

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
