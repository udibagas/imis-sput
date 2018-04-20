@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">COMPONENT CRITERIA <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
        </span>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="code">Code</th>
                    <th data-column-id="description">Description</th>
                    <th data-column-id="commands" data-width="5%"
                        data-formatter="commands"
                        data-sortable="false"
                        data-align="right"
                        data-header-align="right"></th>
                </tr>
            </thead>
        </table>
    </div>

    @include('componentCriteria._form')

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
            error: {}
        },
        methods: {
            add: function() {
                // reset the form
                this.formTitle = "ADD COMPONENT CRITERIA";
                this.formData = {};
                this.formErrors = {};
                this.error = {};
                // open form
                $('#modal-form').modal('show');
            },
            store: function() {
                block('form');
                var t = this;
                axios.post('{{url("componentCriteria")}}', this.formData).then(function(r) {
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
                    }

                    if (error.response.status == 500) {
                        t.error = error.response.data;
                    }
                });
            },
            edit: function(id) {
                var t = this;
                this.formTitle = "EDIT COMPONENT CRITERIA";
                this.formErrors = {};
                this.error = {};

                axios.get('{{url("componentCriteria")}}/' + id).then(function(r) {
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
                axios.put('{{url("componentCriteria")}}/' + this.formData.id, this.formData).then(function(r) {
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
                if (confirm('Anda yakin akan menghapus data ini?')) {
                    axios.delete('{{url("componentCriteria")}}/' + id)

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
            },
        },
        mounted: function() {

            var t = this;

            var grid = $('#bootgrid').bootgrid({
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('componentCriteria')}}',
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
                        return '<a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> ' +
                            '<a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a>';
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
