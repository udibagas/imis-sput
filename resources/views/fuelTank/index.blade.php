@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">FUEL TANK <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
        </span>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="name">Name</th>
                    <th data-column-id="description">Description</th>
                    <th data-column-id="capacity">Capacity</th>
                    <th data-column-id="stock">Stock</th>
                    <th data-column-id="last_stock_time">Last Update Stock</th>
                    <th data-column-id="commands" data-width="8%"
                        data-formatter="commands"
                        data-sortable="false"
                        data-align="right"
                        data-header-align="right"></th>
                </tr>
            </thead>
        </table>
    </div>

    @include('fuelTank._form')

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
                this.formTitle = "ADD FUEL TANK";
                this.formData = {};
                this.formErrors = {};
                // open form
                $('#modal-form').modal('show');
            },
            store: function() {
                var t = this;
                axios.post('{{url("fuelTank")}}', this.formData).then(function(r) {
                    $('#modal-form').modal('hide');
                    $('#bootgrid').bootgrid('reload');
                })
                // validasi
                .catch(function(error) {
                    if (error.response.status == 422) {
                        t.formErrors = error.response.data.errors;
                    }

                    if (error.response.status == 500) {
                        t.error = error.response.data;
                        console.log(error.response.data);
                    }
                });
            },
            edit: function(id) {
                var t = this;
                this.formTitle = "EDIT FUEL TANK";
                axios.get('{{url("fuelTank")}}/' + id).then(function(r) {
                    t.formData = r.data;
                    $('#modal-form').modal('show');
                });
            },
            update: function() {
                var t = this;
                axios.put('{{url("fuelTank")}}/' + this.formData.id, this.formData).then(function(r) {
                    $('#modal-form').modal('hide');
                    $('#bootgrid').bootgrid('reload');
                })
                // validasi
                .catch(function(error) {
                    if (error.response.status == 422) {
                        t.formErrors = error.response.data.errors;
                    }

                    if (error.response.status == 500) {
                        t.error = error.response.data;
                        console.log(error.response.data);
                    }
                });
            },
            delete: function(id) {
                if (confirm('Anda yakin akan menghapus data ini?')) {
                    axios.delete('{{url("fuelTank")}}/' + id)
                        .then(function(r) {
                            $('#bootgrid').bootgrid('reload');
                        });
                }
            },
        },
        mounted: function() {

            var t = this;

            var grid = $('#bootgrid').bootgrid({
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('fuelTank')}}',
                ajaxSettings: {method: 'GET', cache: false},
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
