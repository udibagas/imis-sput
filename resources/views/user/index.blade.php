@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">USERS <small>Manage users</small></h3>
        @can('create', App\User::class)
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
        </span>
        @endcan
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id">ID</th>
                    <th data-column-id="name">Name</th>
                    <th data-column-id="email">Email</th>

                    <th data-column-id="super_admin"
                        data-formatter="super_admin"
                        data-align="center"
                        data-header-align="center">Super Admin</th>

                    <th data-column-id="customer">Customer</th>

                    <th data-column-id="active"
                        data-formatter="active"
                        data-align="center"
                        data-header-align="center">Active</th>

                    @can('updateOrDelete', App\User::class)
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

    @can('createOrUpdate', App\User::class)
    @include('user._form')
    @endcan

</div>

@endsection

@push('scripts')

<script type="text/javascript">

    $('.select2').select2();

    const app = new Vue({
        el: '#app',
        data: {
            customers: {!! App\Customer::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
            showAuth: true,
            formData: {
                active: 0,
                super_admin: 0,
                customer_id: 0,
                auth: {
                    controller: [],
                    view: [],
                    create: [],
                    update: [],
                    delete: [],
                    export: [],
                    import: []
                }
            },
            formErrors: {},
            formTitle: '',
            error: {},
            selectAll: {
                view: 0,
                create: 0,
                update: 0,
                delete: 0,
                export: 0,
                import: 0
            },
            modules: {!! json_encode(App\Authorization::getModule()) !!},
            actions: ['view', 'create', 'update', 'delete', 'export', 'import'],
        },
        watch: {
            'formData.customer_id': function(v, o) {
                this.showAuth = v ? false : true;
            },
            'formData.super_admin': function(v, o) {
                this.showAuth = v ? false : true;
            },
            'selectAll.view': function(v, o) {
                for (i in this.formData.auth.view) {
                    this.formData.auth.view[i] = v;
                }
            },
            'selectAll.create': function(v, o) {
                for (i in this.formData.auth.create) {
                    this.formData.auth.create[i] = v;
                }
            },
            'selectAll.update': function(v, o) {
                for (i in this.formData.auth.update) {
                    this.formData.auth.update[i] = v;
                }
            },
            'selectAll.delete': function(v, o) {
                for (i in this.formData.auth.delete) {
                    this.formData.auth.delete[i] = v;
                }
            },
            'selectAll.export': function(v, o) {
                for (i in this.formData.auth.export) {
                    this.formData.auth.export[i] = v;
                }
            },
            'selectAll.import': function(v, o) {
                for (i in this.formData.auth.import) {
                    this.formData.auth.import[i] = v;
                }
            },
        },
        methods: {
            add: function() {
                this.formTitle = "ADD USER";

                this.selectAll = {
                    view: 0,
                    create: 0,
                    update: 0,
                    delete: 0,
                    export: 0,
                    import: 0
                };

                this.formData = {
                    active: 0,
                    super_admin: 0,
                    customer_id: 0,
                    auth: {
                        controller: [],
                        view: [],
                        create: [],
                        update: [],
                        delete: [],
                        export: [],
                        import: []
                    }
                };

                this.getDefaultAuth();
                this.formErrors = {};
                this.error = {};
                $('#modal-form').modal('show');

            },
            getDefaultAuth: function() {
                var idx = 0;

                for (i in this.modules) {
                    for (j in this.modules[i].children) {
                        if (this.modules[i].children[j].id != undefined) {
                            this.formData.auth.controller[idx] = this.modules[i].children[j].id;
                            this.formData.auth.view[idx] = 0;
                            this.formData.auth.create[idx] = 0;
                            this.formData.auth.update[idx] = 0;
                            this.formData.auth.delete[idx] = 0;
                            this.formData.auth.export[idx] = 0;
                            this.formData.auth.import[idx] = 0;
                            idx++;
                        }
                    }
                }
            },
            store: function() {
                block('form');
                var t = this;

                axios.post('{{url("user")}}', this.formData).then(function(r) {
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
                var _this = this;
                _this.formTitle = "EDIT USER";
                _this.formErrors = {};
                _this.error = {};

                _this.selectAll = {
                    view: 0,
                    create: 0,
                    update: 0,
                    delete: 0,
                    export: 0,
                    import: 0
                };

                axios.get('{{url("user")}}/' + id).then(function(r) {
                    _this.formData = r.data;
                    _this.formData.auth = {
                        controller: [],
                        view: [],
                        create: [],
                        update: [],
                        delete: [],
                        export: [],
                        import: []
                    }

                    axios.get('{{url("user/getAuth")}}/' + id).then(function(rr) {
                        _this.getDefaultAuth();

                        for (i in rr.data) {
                            _this.formData.auth.controller[i] = rr.data[i].controller;
                            _this.formData.auth.view[i] = rr.data[i].view;
                            _this.formData.auth.create[i] = rr.data[i].create;
                            _this.formData.auth.update[i] = rr.data[i].update;
                            _this.formData.auth.delete[i] = rr.data[i].delete;
                            _this.formData.auth.export[i] = rr.data[i].export;
                            _this.formData.auth.import[i] = rr.data[i].import;
                        }

                        $('#modal-form').modal('show');
                        _this.$forceUpdate();
                    })

                    .catch(function(error) {
                        var error = error.response.data;
                        toastr["error"](error.message + ". " + error.file + ":" + error.line)
                    });

                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                });

            },
            update: function() {
                block('form');
                var t = this;
                axios.put('{{url("user")}}/' + this.formData.id, this.formData).then(function(r) {
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
                            axios.delete('{{url("user")}}/' + id)

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
        },
        mounted: function() {

            var _this = this;

            var grid = $('#bootgrid').bootgrid({
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('user')}}',
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
                        return '@can("update", App\User::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                            '@can("delete", App\User::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                    },
                    "active": function(column, row) {
                        return row.active
                            ? '<span class="label label-success">Y</span>'
                            : '<span class="label label-default">N</span>';
                    },
                    "super_admin": function(column, row) {
                        return row.super_admin
                            ? '<span class="label label-success">Y</span>'
                            : '<span class="label label-default">N</span>';
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                grid.find(".c-delete").on("click", function(e) {
                    _this.delete($(this).data("id"));
                });

                grid.find(".c-edit").on("click", function(e) {
                    _this.edit($(this).data("id"));
                });
            });

        }
    });

</script>

@endpush
