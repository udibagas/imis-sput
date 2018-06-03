@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">ASSET <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            @can('create', App\Asset::class)
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
            @endcan
            @can('export', App\Asset::class)
            <a href="{{url('asset/export')}}" target="_blank" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> EXPORT</a>
            @endcan
            @can('export', App\Asset::class)
            <a href="{{url('asset/generateQrCode')}}" class="btn btn-primary" target="_blank"><i class="fa fa-qrcode"></i> Generate QR Code</a>
            @endcan
        </span>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="reg_no">Registration Number</th>
                    <th data-column-id="name">Name</th>
                    <th data-column-id="trademark">Trademark</th>
                    <th data-column-id="version">Version</th>
                    <th data-column-id="sn">SN</th>
                    <th data-column-id="lifetime">Lifetime</th>
                    <th data-column-id="price">Price</th>
                    <th data-column-id="year">Year</th>
                    <th data-column-id="location">Location</th>
                    <th data-column-id="status">Status</th>
                    @can('updateOrDelete', App\Asset::class)
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

    @can('createOrUpdate', App\Asset::class)
    @include('asset._form')
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
            statuses: {!! App\AssetStatus::selectRaw('id AS id, CONCAT(code, " - ", description) AS text')->orderBy('code', 'ASC')->get() !!},
            locations: {!! App\AssetLocation::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        },
        methods: {
            add: function() {
                this.formTitle = "ADD ASSET";
                this.formData = {};
                this.formErrors = {};
                this.error = {};
                $('#modal-form').modal('show');
            },
            store: function() {
                block('form');
                var t = this;
                axios.post('{{url("asset")}}', this.formData).then(function(r) {
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
                this.formTitle = "EDIT ASSET";
                this.formErrors = {};
                this.error = {};

                axios.get('{{url("asset")}}/' + id).then(function(r) {
                    t.formData = r.data;
                    $('#modal-form').modal('show');
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });
            },
            update: function() {
                block('form');
                var t = this;
                axios.put('{{url("asset")}}/' + this.formData.id, this.formData).then(function(r) {
                    unblock('form');
                    $('#modal-form').modal('hide');
                    toastr["success"]("Data berhasil diupdate");
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
            delete: function(id) {
                bootbox.confirm({
                    title: "Konfirmasi",
                    message: "Anda yakin akan menghapus data ini?",
                    callback: function(r) {
                        if (r == true) {
                            axios.delete('{{url("asset")}}/' + id)

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
                                toastr["error"](error.message + ". " + error.file + ":" + error.line);
                            });
                        }
                    }
                });
            },
            generateQrCode: function(id) {
                window.open('{{url("asset/generateQrCode")}}/' + id, '_blank');
            }
        },
        mounted: function() {

            var t = this;

            var grid = $('#bootgrid').bootgrid({
                statusMapping: {
                    'BA': 'success',
                    'R1': 'warning',
                    'R2': 'danger',
                    'NO': 'disabled'
                },
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('asset')}}',
                ajaxSettings: {
                    method: 'GET', cache: false,
                    statusCode: {
                        500: function(e) {
                            var error = JSON.parse(e.responseText);
                            toastr["error"](error.message + ". " + error.file + ":" + error.line);
                        }
                    }
                },
                searchSettings: { delay: 100, characters: 3 },
                templates: {
                    header: '<div id="@{{ctx.id}}" class="pull-right @{{css.header}}"><div class="actionBar"><p class="@{{css.search}}"></p><p class="@{{css.actions}}"></p></div></div>'
                },
                formatters: {
                    "commands": function(column, row) {
                        return '@can("update", App\Asset::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                            '@can("delete", App\Asset::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan' +
                            '@can("view", App\Employee::class) <a href="#" title="Generate QR Code" class="btn btn-success btn-xs c-qrcode" data-id="'+row.id+'"><i class="fa fa-qrcode"></i></a> @endcan';
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                grid.find(".c-delete").on("click", function(e) {
                    t.delete($(this).data("id"));
                });

                grid.find(".c-edit").on("click", function(e) {
                    t.edit($(this).data("id"));
                });

                grid.find(".c-qrcode").on("click", function(e) {
                    t.generateQrCode($(this).data("id"));
                });
            });

        }
    });

</script>

@endpush
