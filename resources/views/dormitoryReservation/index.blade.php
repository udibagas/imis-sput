@extends('layouts.app')

@section('content')
<div id="app" class="row">
    <div class="col-md-3">

        <div class="panel minimal panel-primary">
            <div class="panel-heading text-center">
                ROOM AVAILABILITY
            </div>
            <div class="panel-body">
                <div class="row col-with-divider">
                    <div class="col-xs-4 text-center stack-order text-primary">
                        <h1 class="no-margins">@{{capacity}}</h1>
                        CAPACITY
                    </div>
                    <div class="col-xs-4 text-center stack-order text-danger">
                        <h1 class="no-margins">@{{reserved}}</h1>
                        RESERVED
                    </div>
                    <div class="col-xs-4 text-center stack-order text-success">
                        <h1 class="no-margins">@{{capacity - reserved}}</h1>
                        AVAILABLE
                    </div>
                </div>
            </div>
        </div>

        <div v-for="d in dormitories" :class="['panel', d.status ? 'panel-success' : 'panel-danger']">
            <div class="panel-heading text-center">
                @{{d.name}}
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Room</th>
                        <th class="text-center">C</th>
                        <th class="text-center">R</th>
                        <th class="text-center">A</th>
                        <th v-if="d.status != 0"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in d.rooms" :class="r.available == 0 || r.status == 0 ? 'danger' : ''">
                        <td class="text-center">@{{r.name}}</td>
                        <td class="text-center">@{{r.capacity}}</td>
                        <td class="text-center">@{{r.reserved}}</td>
                        <td class="text-center">@{{r.available}}</td>
                        <td class="text-right" v-if="d.status != 0">

                            <button v-show="r.reserved > 0" type="button" class="btn btn-primary btn-xs" @click="roomDetail(r,d)" title="Room Detail"><i class="icon-list"></i></button>

                            <button v-show="r.available > 0 && d.status == 1 && r.status == 1" type="button" class="btn btn-primary btn-xs" @click="add(r)" title="Add Reservation"><i class="icon-plus"></i></button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">@{{d.capacity}}</th>
                        <th class="text-center">@{{d.reserved}}</th>
                        <th class="text-center">@{{d.available}}</th>
                        <th v-if="d.status != 0" class="text-center"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="col-md-9">

        @include('dormitoryReservation._lewatMasaCuti')

        <div class="panel panel-default">
            <div class="panel-heading">
                DORMITORY RESERVATIONS <small> - Manage</small>
            </div>
            <div class="panel-body">
                <form class="form-inline pull-right" style="margin:15px 0 15px 10px;">
                    <select class="form-control" v-model="dataFilter">
                        <option value="current">Tampilkan Peghuni Saat Ini</option>
                        <option value="all">Tampilkan Semua Data</option>
                    </select>
                    @can('create', App\DormitoryReservation::class)
                    <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
                    @endcan
                    @can('export', App\DormitoryReservation::class)
                    <a href="#" @click="openExportForm" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> EXPORT</a>
                    @endcan
                </form>
                <table class="table table-striped table-hover" id="bootgrid" style="border-top:2px solid #ddd">
                    <thead>
                        <tr>
                            <!-- <th data-column-id="id">ID</th> -->
                            <th data-column-id="permit_number">Permit</th>
                            <th data-column-id="nrp">NRP</th>
                            <th data-column-id="name">Name</th>
                            <th data-column-id="department">Department</th>
                            <th data-column-id="position">Position</th>
                            <th data-column-id="dormitory">Dormitory</th>
                            <th data-column-id="room">Room</th>
                            <th data-column-id="need">Need</th>
                            <th data-column-id="check_in">Chek In</th>
                            <th data-column-id="check_out">Chek Out</th>
                            <th data-column-id="cuti" data-sortable="false" data-formatter="cuti">Cuti</th>
                            @can('updateOrDelete', App\DormitoryReservation::class)
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
    </div>

    @include('dormitoryReservation._roomDetail')

    @can('createOrUpdate', App\DormitoryReservation::class)
    @include('dormitoryReservation._form')
    @endcan

    @can('export', App\DormitoryReservation::class)
    @include('dormitoryReservation._form_export')
    @endcan

</div>
@endsection

@push('scripts')
<script type="text/javascript">

$('.page-container').addClass('sidebar-collapsed');

const app = new Vue({
    el: '#app',
    data: {
        dormitories: [],
        rooms: {!! \App\DormitoryRoom::getSelect(); !!},
        employees: {!! App\Employee::selectRaw('id AS id, CONCAT(nrp, " - ", name) AS text')->orderBy('name', 'ASC')->get() !!},
        lewatMasaCuti: [],
        reservations: [],
        formTitle: '',
        roomTitle: '',
        error: {},
        formErrors: {},
        formData: {},
        exportRange: {
            from: '{{date("Y-m-d")}}',
            to: '{{date("Y-m-d")}}'
        },
        statusMapping: {
            0: 'danger',
            1: 'warning',
            2: 'success',
            3: 'default'
        },
        dataFilter: 'current',
        capacity: 0,
        reserved: 0
    },
    methods: {
        getDormitoryData: function() {
            var _this = this;

            axios.get('{{url("dormitory/getAllData")}}').then(function(r) {
                _this.dormitories = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });
        },
        getLewatMasaCuti: function() {
            var _this = this;

            axios.get('{{url("dormitoryReservation/lewatMasaCuti")}}').then(function(r) {
                _this.lewatMasaCuti = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });
        },
        openExportForm: function() {
            $('#modal-form-export').modal('show');
        },
        doExport: function() {
            // TODO: validate input first
            $('#modal-form-export').modal('hide');
            window.location = '{{url("dormitoryReservation/export")}}?from=' + this.exportRange.from + '&to=' + this.exportRange.to;
        },
        roomDetail: function(room, dormitory) {
            var _this = this;

            axios.get('{{url("dormitoryRoom/getCurrentReservation")}}/' + room.id).then(function(r) {
                _this.reservations = r.data;
                _this.roomTitle = dormitory.name + ' / ' + room.name;
                $('#modal-room-detail').modal('show');
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });
        },
        add: function(room = null) {
            this.formTitle = "ADD DORMITORY RESERVATION";
            this.formData = {};
            this.formErrors = {};
            this.error = {};

            if (room) {
                this.formData.dormitory_room_id = room.id;
            }

            this.formData.check_in = '{{date("Y-m-d")}}';
            this.$forceUpdate();
            $('#modal-form').modal('show');
        },
        store: function() {
            block('form');
            var _this = this;
            axios.post('{{url("dormitoryReservation")}}', _this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil ditambahkan");
                $('#bootgrid').bootgrid('reload');
                _this.getDormitoryData();
            })

            .catch(function(error) {
                unblock('form');
                if (error.response.status == 422) {
                    _this.formErrors = error.response.data.errors;
                }

                if (error.response.status == 500) {
                    _this.error = error.response.data;
                }
            });
        },
        edit: function(id) {
            var t = this;
            this.formTitle = "EDIT DORMITORY RESERVATION";
            this.formErrors = {};
            this.error = {};

            axios.get('{{url("dormitoryReservation")}}/' + id).then(function(r) {
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
            axios.put('{{url("dormitoryReservation")}}/' + this.formData.id, this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil diupdate");
                $('#bootgrid').bootgrid('reload');
                _this.getDormitoryData();
            })

            .catch(function(error) {
                unblock('form');
                if (error.response.status == 422) {
                    _this.formErrors = error.response.data.errors;
                }

                if (error.response.status == 500) {
                    _this.error = error.response.data;
                }
            });
        },
        remove: function(id) {
            var _this = this;

            bootbox.confirm({
                title: "Konfirmasi",
                message: "Anda yakin akan menghapus data ini?",
                callback: function(r) {
                    if (r == true) {
                        axios.delete('{{url("dormitoryReservation")}}/' + id)

                        .then(function(r) {
                            if (r.data.success == true) {
                                toastr["success"]("Data berhasil dihapus");
                                $('#bootgrid').bootgrid('reload');
                                _this.getDormitoryData();
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
        t.getDormitoryData();
        t.getLewatMasaCuti();

        var grid = $('#bootgrid').bootgrid({
            statusMapping: t.statusMapping,
            rowCount: [10,25,50,100],
            ajax: true, url: '{{url('dormitoryReservation')}}',
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
                commands: function(column, row) {
                    return '@can("update", App\DormitoryReservation::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                        '@can("delete", App\DormitoryReservation::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                },
                cuti: function(column, row) {
                    return row.cuti + ' hari';
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function() {
            grid.find(".c-delete").on("click", function(e) {
                t.remove($(this).data("id"));
            });

            grid.find(".c-edit").on("click", function(e) {
                t.edit($(this).data("id"));
            });
        });
    }
});

</script>
@endpush
