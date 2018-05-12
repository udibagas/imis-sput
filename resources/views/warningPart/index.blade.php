@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">WARNING PART <small>Manage</small></h3>
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            @can('export', App\WarningPart::class)
            <a href="#" class="btn btn-primary"><i class="icon-download"></i> EXPORT</a>
            @endcan
        </span>
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="unit">Unit</th>
                    <th data-column-id="unit_category">Unit Category</th>
                    <th data-column-id="breakdown_category">B/D Type</th>
                    <th data-column-id="location">Location</th>
                    <th data-column-id="warning_part">Warning Part</th>
                    <th data-column-id="time_in">Time In</th>
                    <th data-column-id="duration">Duration</th>
                    <th data-column-id="note">Note</th>
                    <th data-column-id="bd_status" data-formatter="bd_status">B/D Status</th>
                    <!-- <th data-column-id="status" data-formatter="status">Closed</th> -->
                    <th data-column-id="updated_at">Last Update</th>
                    <th data-column-id="user">Update By</th>
                    @can('update', App\WarningPart::class)
                    <th data-column-id="commands"  data-width="3%"
                        data-formatter="commands"
                        data-sortable="false"
                        data-align="right"
                        data-header-align="right"></th>
                    @endcan
                </tr>
            </thead>
        </table>
    </div>

    @can('update', App\WarningPart::class)
    @include('warningPart._form')
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
            units: {!! App\Unit::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
            component_criterias: {!!App\ComponentCriteria::selectRaw('id AS id, CONCAT(code, " - ", description) AS text')->orderBy('code', 'ASC')->get()!!},
            locations: {!! App\Location::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        },
        methods: {
            edit: function(id) {
                var t = this;
                this.formTitle = "EDIT WARNING PART";
                this.formErrors = {};
                this.error = {};

                axios.get('{{url("warningPart")}}/' + id).then(function(r) {
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
                var t = this;
                axios.put('{{url("warningPart")}}/' + this.formData.id, this.formData).then(function(r) {
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
        },
        mounted: function() {
            var t = this;
            var grid = $('#bootgrid').bootgrid({
                statusMapping: {
                    0: "danger",
                    1: "success"
                },
                rowCount: [10,25,50,100],
                ajax: true, url: '{{url('warningPart')}}',
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
                        return '@can("update", App\WarningPart::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan';
                    },
                    "status": function(column, row) {
                        return row.status
                            ? '<span class="label label-success">Y</span>'
                            : '<span class="label label-danger">N</span>';
                    },
                    "bd_status": function(column, row) {
                        return row.bd_status
                            ? '<span class="label label-success">C</span>'
                            : '<span class="label label-danger">O</span>';
                    },
                }
            }).on("loaded.rs.jquery.bootgrid", function() {
                grid.find(".c-edit").on("click", function(e) {
                    t.edit($(this).data("id"));
                });
            });

        }
    });

</script>

@endpush
