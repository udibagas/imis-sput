@extends('layouts.app')

@section('content')
<div class="panel panel-default" id="app">
    <div class="panel-heading">
        <div class="pull-right">
            <a href="#"><i class="fa fa-filter"></i></a>
        </div>
        <span class="text-primary">DAILY BREADOWN REPORT</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Unit</th>
                    <th>Unit Category</th>
                    <th>B/D Type</th>
                    <th>B/D Status</th>
                    <th>Location</th>
                    <th>HM</th>
                    <th>KM</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Duration</th>
                    <th>Problem</th>
                    <th>Component Criteria</th>
                    <th>Tindakan</th>
                    <th>WO Number</th>
                    @can('updateOrDelete', App\Breakdown::class)
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                <tr v-for="(b, i) in breakdowns" :class="rowClass[b.breakdown_category]">
                    <td>@{{i+1}}</td>
                    <td>@{{b.unit}}</td>
                    <td>@{{b.unit_category}}</td>
                    <td>@{{b.breakdown_category}}</td>
                    <td>@{{b.breakdown_status}}</td>
                    <td>@{{b.location}}</td>
                    <td>@{{b.hm}}</td>
                    <td>@{{b.km}}</td>
                    <td>@{{b.time_in}}</td>
                    <td>@{{b.time_out}}</td>
                    <td></td>
                    <td>@{{b.diagnosa}}</td>
                    <td>@{{b.component_criteria}}</td>
                    <td>@{{b.tindakan}}</td>
                    <td>@{{b.wo_number}}</td>
                    @can('updateOrDelete', App\Breakdown::class)
                    <td>
                        <a href="#" @click="edit(b.id)" class="btn btn-primary btn-xs"><i class="icon icon-pencil"></i></a>
                    </td>
                    @endcan
                </tr>
            </tbody>
        </table>
    </div>

    @can('createOrUpdate', App\Breakdown::class)
    @include('breakdown._form_pcr')
    @endcan

</div>
@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        breakdowns: [],
        formData: {},
        formErrors: {},
        error: {},
        rowClass: {
            ICM: 'danger',
            USM: 'warning',
            SCM: 'info',
            TRM: 'warning',
        },
        component_criterias: {!!App\ComponentCriteria::selectRaw('id AS id, CONCAT(code, " - ", description) AS text')->orderBy('code', 'ASC')->get()!!},
    },
    methods: {
        getData: function() {
            var _this = this;
            axios.get('{{url("breakdown/pcr")}}').then(function(r) {
                _this.breakdowns = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });

            setTimeout(_this.getData, 3000);
        },
        edit: function(id) {
            var _this = this;
            _this.formErrors = {};
            _this.error = {};

            axios.get('{{url("breakdown")}}/' + id).then(function(r) {
                _this.formData = r.data;
                $('#time_out').datetimepicker().on('dp.change', function() {
                    _this.formData.time_out = $(this).val();
                });

                $('#modal-form').modal('show');

            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });
        },
        update: function() {
            if (this.formData.status == 1) {
                if (!confirm("Anda yakin?")) {
                    return;
                }
            }

            block('form');
            var _this = this;
            _this.formData.pcr = 1;
            axios.put('{{url("breakdown")}}/' + _this.formData.id, _this.formData).then(function(r) {
                unblock('form');
                $('#modal-form').modal('hide');
                toastr["success"]("Data berhasil diupdate");
            })
            // validasi
            .catch(function(error) {
                unblock('form');
                if (error.response.status == 422) {
                    _this.formErrors = error.response.data.errors;
                }

                else {
                    _this.error = error.response.data;
                }
            });
        },
    },
    mounted: function() {
        this.getData();
    }
});

</script>
@endpush
