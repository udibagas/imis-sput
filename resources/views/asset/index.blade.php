@extends('layouts.app')

@section('content')

<div id="app">
    <div class="panel minimal panel-default">
        <div class="panel-body">
            <div class="row col-with-divider">
                <div class="col-xs-3 text-center stack-order" v-for="s in summaries">
                    <h1 class="no-margins">@{{s.total}}</h1>
                    [@{{s.code}}] @{{s.description}}
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
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
                        <!-- <th data-column-id="id" data-width="3%">ID</th> -->
                        <th data-column-id="picture" data-formatter="picture">Picture</th>
                        <th data-column-id="reg_no">Registration Number</th>
                        <th data-column-id="name">Name</th>
                        <th data-column-id="trademark">Trademark</th>
                        <th data-column-id="version">Version</th>
                        <th data-column-id="sn">SN</th>

                        <th data-column-id="lifetime"
                            data-formatter="lifetime"
                            data-align="center"
                            data-header-align="center">Lifetime</th>

                        <th data-column-id="price"
                            data-formatter="price"
                            data-header-align="right"
                            data-align="right">Price (IDR)</th>

                        <th data-column-id="value"
                            data-formatter="value"
                            data-header-align="right"
                            data-align="right">Value (IDR)</th>

                        <th data-column-id="year"
                            data-align="center"
                            data-header-align="center">Year</th>

                        <th data-column-id="uselife"
                            data-align="center"
                            data-header-align="center">Uselife</th>

                        <th data-column-id="type"
                            data-align="center"
                            data-formatter="type"
                            data-header-align="center">Type</th>

                        <th data-column-id="category">Category</th>
                        <th data-column-id="vendor">Vendor</th>
                        <th data-column-id="location">Location</th>

                        <th data-column-id="status"
                            data-align="center"
                            data-header-align="center">Status</th>

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
        summaries: [],
        error: {},
        statuses: {!! App\AssetStatus::selectRaw('id AS id, CONCAT(code, " - ", description) AS text')->orderBy('code', 'ASC')->get() !!},
        locations: {!! App\AssetLocation::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        categories: {!! App\AssetCategory::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        vendors: {!! App\AssetVendor::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
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
        },
        formatNumber: function(v) {
            return parseFloat(v)
                .toFixed(0)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        getSummary: function() {
            var _this = this;
            axios.get('{{url("asset/summary")}}')
                .then(function(r) {
                    return _this.summaries = r.data;
                })
                .catch(function(e) {
                    console.log(e);
                });
        },
        handleFileUpload() {
            // https://serversideup.net/uploading-files-vuejs-axios/
            let _this = this
            let file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append('file', file)

            axios.post( '/asset/uploadPicture', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(function(r) {
                    if (r.data.success) {
                        _this.formData.picture = r.data.file
                        _this.formErrors.picture = false;
                        _this.$forceUpdate();
                    }
                    else {
                        _this.formErrors.picture = [r.data.message];
                        _this.$forceUpdate();
                    }
                }).catch(function(error) {
                    _this.error = error.response
                });
        }
    },
    mounted: function() {
        var t = this;
        t.getSummary();

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
                commands: function(column, row) {
                    return '@can("update", App\Asset::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                        '@can("delete", App\Asset::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan' +
                        '@can("view", App\Employee::class) <a href="#" title="Generate QR Code" class="btn btn-success btn-xs c-qrcode" data-id="'+row.id+'"><i class="fa fa-qrcode"></i></a> @endcan';
                },
                price: function(column, row) {
                    return t.formatNumber(row.price);
                },
                value: function(column, row) {
                    return t.formatNumber(row.value);
                },
                lifetime: function(column, row) {
                    return row.lifetime + ' tahun';
                },
                type: function(column, row) {
                    return row.type ? 'OWN' : 'RENT';
                },
                picture: function(column, row) {
                    return row.picture ? '<img src="'+ row.picture +'" />' : '';
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
