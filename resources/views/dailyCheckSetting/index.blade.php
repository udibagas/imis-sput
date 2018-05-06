@extends('layouts.app')

@section('content')

<div class="row" id="app">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-body">
                @can('create', App\DailyCheckSetting::class)
                <span class="pull-right" style="margin:15px 0 15px 10px;">
                    <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
                </span>
                @endcan
                <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
                    <thead>
                        <tr>
                            <th data-column-id="id">ID</th>
                            <th data-column-id="day" data-formatter="day">Day</th>
                            <th data-column-id="unit">Unit</th>
                            @can('updateOrDelete', App\DailyCheckSetting::class)
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

            @can('createOrUpdate', App\DailyCheckSetting::class)
            @include('dailyCheckSetting._form')
            @endcan

        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                DAILY CHECK SETTING
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th v-for="d in dailyCheckSettings" style="font-weight:bold;">@{{days[d.day]}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td v-for="d in dailyCheckSettings">
                            <div v-for="u in d.units.split(',')">
                                @{{u}}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                UNIT BELUM TERJADWAL (@{{unscheduled.length}} unit)
            </div>
            <div class="panel-body">
                <span v-for="u in unscheduled">@{{u.unit}}, </span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

    const app = new Vue({
        el: '#app',
        data: {
            formData    : {},
            formErrors  : {},
            formTitle   : '',
            error       : {},
            days        : ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            unscheduled : [],
            dailyCheckSettings: [],
        },
        filters: {
            addBr(str) {
                // return str;
                return str.replace(',', '<br />');
            },
        },
        methods: {
            getData: function() {
                var _this = this;
                axios.get('{{url("dailyCheckSetting/getData")}}').then(function(r) {
                    _this.dailyCheckSettings = r.data;
                })

                .catch(function(error) {
                    if (error.response.status == 500) {
                        var error = error.response.data;
                        toastr["error"](error.message + ". " + error.file + ":" + error.line)
                    }
                });
            },
            getUnscheduled: function() {
                var _this = this;
                axios.get('{{url("dailyCheckSetting/unScheduled")}}').then(function(r) {
                    _this.unscheduled = r.data;
                })

                .catch(function(error) {
                    if (error.response.status == 500) {
                        var error = error.response.data;
                        toastr["error"](error.message + ". " + error.file + ":" + error.line)
                    }
                });
            },
            add: function() {
                // reset the form
                this.formTitle = "ADD DAILY CHECK SETTING";
                this.formData = {};
                this.formErrors = {};
                this.error = {};
                // open form
                $('#modal-form').modal('show');
            },
            store: function() {
                block('form');
                var t = this;
                axios.post('{{url("dailyCheckSetting")}}', this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil ditambahkan");
                    $('#bootgrid').bootgrid('reload');
                    t.getData();
                    setTimeout(t.getUnscheduled, 300);
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
            edit: function(id) {
                var t = this;
                this.formTitle = "EDIT DAILY CHECK SETTING";
                this.formErrors = {};
                this.error = {};

                axios.get('{{url("dailyCheckSetting")}}/' + id).then(function(r) {
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
                axios.put('{{url("dailyCheckSetting")}}/' + this.formData.id, this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil diupdate");
                    $('#bootgrid').bootgrid('reload');
                    t.getData();
                    setTimeout(t.getUnscheduled, 300);
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
                            axios.delete('{{url("dailyCheckSetting")}}/' + id)

                            .then(function(r) {
                                if (r.data.success == true) {
                                    toastr["success"]("Data berhasil dihapus");
                                    $('#bootgrid').bootgrid('reload');
                                    t.getData();
                                    setTimeout(t.getUnscheduled, 300);
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
            this.getData();
            this.getUnscheduled();
            var t = this;

            var grid = $('#bootgrid').bootgrid({
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('dailyCheckSetting')}}',
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
                        var t = t;
                        return '@can("update", App\DailyCheckSetting::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                            '@can("delete", App\DailyCheckSetting::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                    },
                    "day": function(column, row) {
                        var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                        return days[row.day];
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
