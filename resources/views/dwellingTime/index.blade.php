@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">DWELLING TIME <small>Manage</small></h3>
        @can('create', App\DwellingTime::class)
        <span class="pull-right" style="margin:15px 0 15px 10px;">
            <a href="#" @click="add" class="btn btn-primary"><i class="icon-plus-circled"></i></a>
        </span>
        @endcan
        <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
            <thead>
                <tr>
                    <th data-column-id="id" data-width="3%">ID</th>
                    <th data-column-id="time">Time</th>
                    <th data-column-id="barging_id">Barging ID</th>
                    <th data-column-id="customer">Customer</th>
                    <th data-column-id="jetty">Jetty</th>
                    <th data-column-id="status" data-formatter="status">Status</th>
                    <th data-column-id="description">Description</th>
                    @can('updateOrDelete', App\DwellingTime::class)
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

    @can('createOrUpdate', App\DwellingTime::class)
    @include('dwellingTime._form')
    @endcan

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
        error: {},
        descriptions: [],
        customers: {!! App\Customer::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
        statuses: {!! json_encode(App\Barging::getStatusList()) !!},
        jetties: {!! App\Jetty::selectRaw('id AS id, name AS text') ->orderBy('name', 'ASC')->get() !!},
        bargings: {!! App\Barging::active()
                ->selectRaw('bargings.id AS id, bargings.jetty_id AS jetty_id, CONCAT("#", bargings.id, " - ", customers.name, ", ", barges.name, ", Jetty ", jetties.name) AS text')
                ->join('customers', 'customers.id', '=', 'bargings.customer_id')
                ->join('barges', 'barges.id', '=', 'bargings.barge_id')
                ->join('jetties', 'jetties.id', '=', 'bargings.jetty_id')
                ->orderBy('customers.name', 'ASC')->get() !!},
        delayDescriptions: [
            '',
            'P2H',
            'MOVING EQ.',
            'WAITING EQ.',
            'WAITING ENG.',
            'CLEANING EQ.',
            'MEAL & REST',
            'SAFETY CHECK',
            'STANBY BY REQUEST',
            'WAITING OPERATOR',
            'CHANGE SHIFT',
            'PRAYING',
            'IN & OUT JETTY',
            'DUSTY',
            'SHIFTING BARGE',
            'GESER BARGE',
            'STOCK CARGO',
            'UNSHIFTING BARGE'
        ],
        idleDescriptions: [
            '',
            'BARGE KANDAS',
            'RAIN',
            'FORCE MAJEURE',
            'STRIKE (DEMO)',
            'CUSTOMER PROBLEM',
            'BAD WEATHER',
        ]
    },
    watch: {
        'formData.barging_id': function(v, o) {
            if (!this.formData.id) {
                var barging = this.bargings.filter(function(b) {
                    return b.id == v;
                });

                if (barging.length > 0) {
                    this.formData.jetty_id = barging[0].jetty_id;
                }
            }
        },
        'formData.status': function(v, o) {
            var _this = this
            // delay : 3, idle : 4
            if (v == 3) {
                this.descriptions = []
                this.delayDescriptions.forEach(function(d) {
                    _this.descriptions.push({id: d, text: d})
                })
            }
            if (v == 4) {
                this.descriptions = []
                this.idleDescriptions.forEach(function(d) {
                    _this.descriptions.push({id: d, text: d})
                })
            }
        }
    },
    methods: {
        add: function() {
            // reset the form
            this.formTitle = "ADD DWELLING TIME";
            this.formData = {
                time: '{{date("Y-m-d H:i")}}'
            };
            this.formErrors = {};
            this.error = {};
            // open form
            $('#modal-form').modal('show');
        },
        store: function() {
            block('form');
            var t = this;

            axios.post('{{url("dwellingTime")}}', this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil ditambahkan");
                $('#bootgrid').bootgrid('reload');
            })
            // validasi
            .catch(function(error) {
                unblock('form');

                if (error.response.status == 422) {
                    t.error = {};
                    t.formErrors = error.response.data.errors;
                }

                if (error.response.status == 500) {
                    t.formErrors = {};
                    t.error = error.response.data;
                }
            });
        },
        edit: function(id) {
            var t = this;
            this.formTitle = "EDIT DWELLING TIME";
            this.formErrors = {};
            this.error = {};

            axios.get('{{url("dwellingTime")}}/' + id).then(function(r) {
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
            axios.put('{{url("dwellingTime")}}/' + this.formData.id, this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil diupdate");
                $('#bootgrid').bootgrid('reload');
            })
            // validasi
            .catch(function(error) {
                unblock('form');
                if (error.response.status == 422) {
                    t.error = {};
                    t.formErrors = error.response.data.errors;
                }

                if (error.response.status == 500) {
                    t.formErrors = {};
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
                        axios.delete('{{url("dwellingTime")}}/' + id)

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
                0: 'info',
                1: 'success',
                2: 'danger',
                3: 'warning',
                4: 'default',
                5: 'primary',
            },
            rowCount: [10,25,50,100],
            ajax: true, url: '{{url('dwellingTime')}}',
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
                    return '@can("update", App\DwellingTime::class) <a href="#" class="btn btn-info btn-xs c-edit" data-id="'+row.id+'"><i class="icon-pencil"></i></a> @endcan' +
                        '@can("delete", App\DwellingTime::class) <a href="#" class="btn btn-danger btn-xs c-delete" data-id="'+row.id+'"><i class="icon-trash"></i></a> @endcan';
                },
                status: function(column, row) {
                    return t.statuses.filter(function(s) {
                        return s.id == row.status;
                    })[0].text;
                },
            }
        }).on("loaded.rs.jquery.bootgrid", function(e) {
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
