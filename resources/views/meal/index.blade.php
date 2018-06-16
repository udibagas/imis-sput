@extends('layouts.app')

@section('content')

<div class="row" id="app">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                SUMMARY BY LOCATION
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>LOCATION</th>
                        <th class="text-center" title="Breakfast">B</th>
                        <th class="text-center" title="Lunch">L</th>
                        <th class="text-center" title="Dinner">D</th>
                        <th class="text-center" title="Supper">S</th>
                        <th class="info text-center" title="Total">T</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="s in summaryByLocation">
                        <td>@{{s.location}}</td>
                        <td class="text-center">@{{s.b}}</td>
                        <td class="text-center">@{{s.l}}</td>
                        <td class="text-center">@{{s.d}}</td>
                        <td class="text-center">@{{s.s}}</td>
                        <td class="info text-center"><strong>@{{s.t}}</strong></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center info">TOTAL</th>
                        <th class="text-center info">@{{total.breakfast}}</th>
                        <th class="text-center info">@{{total.lunch}}</th>
                        <th class="text-center info">@{{total.dinner}}</th>
                        <th class="text-center info">@{{total.supper}}</th>
                        <th class="text-center info">@{{total.all}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                SUMMARY BY DEPARTMENT
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>DEPARTMENT</th>
                        <th class="text-center" title="Breakfast">B</th>
                        <th class="text-center" title="Lunch">L</th>
                        <th class="text-center" title="Dinner">D</th>
                        <th class="text-center" title="Supper">S</th>
                        <th class="info text-center" title="Total">T</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="s in summaryByDepartment">
                        <td>@{{s.department}}</td>
                        <td class="text-center">@{{s.b}}</td>
                        <td class="text-center">@{{s.l}}</td>
                        <td class="text-center">@{{s.d}}</td>
                        <td class="text-center">@{{s.s}}</td>
                        <td class="info text-center"><strong>@{{s.t}}</strong></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center info">TOTAL</th>
                        <th class="text-center info">@{{total.breakfast}}</th>
                        <th class="text-center info">@{{total.lunch}}</th>
                        <th class="text-center info">@{{total.dinner}}</th>
                        <th class="text-center info">@{{total.supper}}</th>
                        <th class="text-center info">@{{total.all}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                SUMMARY BY LOCATION & DEPARTMENT
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>DEPARTMENT</th>
                        <th>LOCATION</th>
                        <th class="text-center" title="Breakfast">B</th>
                        <th class="text-center" title="Lunch">L</th>
                        <th class="text-center" title="Dinner">D</th>
                        <th class="text-center" title="Supper">S</th>
                        <th class="info text-center" title="Total">T</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="s in summaries">
                        <td>@{{s.department}}</td>
                        <td>@{{s.location}}</td>
                        <td class="text-center">@{{s.b}}</td>
                        <td class="text-center">@{{s.l}}</td>
                        <td class="text-center">@{{s.d}}</td>
                        <td class="text-center">@{{s.s}}</td>
                        <td class="info text-center"><strong>@{{s.t}}</strong></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center info">TOTAL</th>
                        <th class="text-center info">@{{total.breakfast}}</th>
                        <th class="text-center info">@{{total.lunch}}</th>
                        <th class="text-center info">@{{total.dinner}}</th>
                        <th class="text-center info">@{{total.supper}}</th>
                        <th class="text-center info">@{{total.all}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="panel panel-default panel-body">
            B = Breakfast <br />
            L = Lunch <br />
            D = Dinner <br />
            S = Supper <br />
            T = Total <br />
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-body">
                <h3 class="pull-left text-primary">CATERING MANAGEMENT</h3>
                <form class="form-inline text-right">
                    <vue-datepicker v-model="date" placeholder="Date">
                    </vue-datepicker>
                    @can('export', App\Meal::class)
                    <a href="#" @click.prevent="openExportForm" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> EXPORT</a>
                    @endcan
                </form>
                <hr>
                <h3>Tanggal: @{{date}}</h3>
                <table class="table table-striped table-hover " id="bootgrid" style="border-top:2px solid #ddd">
                    <thead>
                        <tr>
                            <th>NRP</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employer</th>
                            <th class="text-center">Breakfast</th>
                            <th class="text-center">Lunch</th>
                            <th class="text-center">Dinner</th>
                            <th class="text-center">Supper</th>
                            <th class="text-center">
                                <input type="checkbox" value="1" v-model="checkAll">
                            </th>
                            <th class="text-center">
                                <a href="#" title="Confirm (@{{checkMe.filter(s => s == true).length}})" class="btn btn-primary" :disabled="checkMe.filter(s => s == true).length == 0" @click.prevent="confirmSelected"><i class="icon-check"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(d,i) in mealData">
                            <td>
                                <input type="hidden" v-model="formData.employee_id[i]">
                                @{{d.nrp}}
                            </td>
                            <td>@{{d.name}}</td>
                            <td>@{{d.department}}</td>
                            <td>@{{d.position}}</td>
                            <td>@{{d.employer}}</td>
                            <td :class="['text-center', formData.b_status[i] ? 'success' : 'danger']">
                                <select class="form-control input-sm" v-model="formData.b[i]" @change="save('b', d.employee_id, formData.b[i])">
                                    <option value="">NO</option>
                                    <option v-for="l in mealLocations" :value="l.id">@{{l.text}}</option>
                                </select>
                            </td>
                            <td :class="['text-center', formData.l_status[i] ? 'success' : 'danger']">
                                <select class="form-control input-sm" v-model="formData.l[i]" @change="save('l', d.employee_id, formData.l[i])">
                                    <option value="">NO</option>
                                    <option v-for="l in mealLocations" :value="l.id">@{{l.text}}</option>
                                </select>
                            </td>
                            <td :class="['text-center', formData.d_status[i] ? 'success' : 'danger']">
                                <select class="form-control input-sm" v-model="formData.d[i]" @change="save('d', d.employee_id, formData.d[i])">
                                    <option value="">NO</option>
                                    <option v-for="l in mealLocations" :value="l.id">@{{l.text}}</option>
                                </select>
                            </td>
                            <td :class="['text-center', formData.s_status[i] ? 'success' : 'danger']">
                                <select class="form-control input-sm" v-model="formData.s[i]" @change="save('s', d.employee_id, formData.s[i])">
                                    <option value="">NO</option>
                                    <option v-for="l in mealLocations" :value="l.id">@{{l.text}}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="checkMe[i]" value="1">
                            </td>
                            <td class="text-center">
                                <a href="#" title="Confirm" @click.prevent="confirm(formData.employee_id[i])" class="btn-sm btn-primary"><i class="icon-check"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @can('export', App\Meal::class)
            @include('meal._form_export')
            @endcan

        </div>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

$('.page-container').addClass('sidebar-collapsed');

const app = new Vue({
    el: '#app',
    data: {
        checkAll: 0,
        total: {
            breakfast: 0,
            lunch: 0,
            dinner: 0,
            supper: 0,
            all: 0
        },
        totalByLocation: {
            breakfast: 0,
            lunch: 0,
            dinner: 0,
            supper: 0,
            all: 0
        },
        totalByDepartment: {
            breakfast: 0,
            lunch: 0,
            dinner: 0,
            supper: 0,
            all: 0
        },
        summaries: [],
        summaryByLocation: [],
        summaryByDepartment: [],
        checkMe: [],
        mealData: [],
        formData: {
            date: '{{date("Y-m-d")}}',
            employee_id: [],
            b: [], l: [], d: [], s: [],
            b_status: [], l_status: [], d_status: [], s_status: [],
        },
        formTitle: '',
        error: {},
        date: '{{date("Y-m-d")}}',
        exportRange: {
            from: '{{date("Y-m-d")}}',
            to: '{{date("Y-m-d")}}'
        },
        mealLocations: {!! App\MealLocation::selectRaw('id AS id, name AS text')->orderBy('name', 'ASC')->get() !!},
    },
    watch: {
        date: function(v, o) {
            this.getData();
            this.getSummary();
            this.getSummary('department');
            this.getSummary('location');
        },
        checkAll: function(v, o) {
            for (i in this.checkMe) {
                this.checkMe[i] = v;
            }
        }
    },
    methods: {
        getData: function() {
            var _this = this;
            // block('table');
            axios.get('{{url("meal")}}?date=' + _this.date).then(function(r) {
                _this.mealData = r.data;

                r.data.forEach(function(d,i) {
                    _this.formData.employee_id[i] = d.employee_id;
                    _this.formData.b[i] = d.breakfast || '';
                    _this.formData.l[i] = d.lunch || '';
                    _this.formData.d[i] = d.dinner || '';
                    _this.formData.s[i] = d.supper || '';
                    _this.formData.b_status[i] = d.b_status;
                    _this.formData.l_status[i] = d.l_status;
                    _this.formData.d_status[i] = d.d_status;
                    _this.formData.s_status[i] = d.s_status;
                    _this.checkMe[i] = false;
                });
                // unblock('table');
            })

            .catch(function(error) {
                // unblock('table');
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        getSummary: function(group = null) {
            var _this = this;
            axios.get('{{url("meal/summary")}}?date=' + _this.date + '&group=' + group)
            .then(function(r) {

                if (group == 'location') {
                    _this.summaryByLocation = r.data;
                    _this.totalByLocation = {
                        breakfast: 0,
                        lunch: 0,
                        dinner: 0,
                        supper: 0,
                        all: 0
                    };

                    r.data.forEach(function(s) {
                        _this.totalByLocation.breakfast += s.b;
                        _this.totalByLocation.lunch += s.l;
                        _this.totalByLocation.dinner += s.d;
                        _this.totalByLocation.supper += s.s;
                        _this.totalByLocation.all += s.t;
                    });
                }

                else if (group == 'department') {
                    _this.summaryByDepartment = r.data;
                    _this.totalByDepartment = {
                        breakfast: 0,
                        lunch: 0,
                        dinner: 0,
                        supper: 0,
                        all: 0
                    };

                    r.data.forEach(function(s) {
                        _this.totalByDepartment.breakfast += s.b;
                        _this.totalByDepartment.lunch += s.l;
                        _this.totalByDepartment.dinner += s.d;
                        _this.totalByDepartment.supper += s.s;
                        _this.totalByDepartment.all += s.t;
                    });
                }

                else {
                    _this.summaries = r.data;
                    _this.total = {
                        breakfast: 0,
                        lunch: 0,
                        dinner: 0,
                        supper: 0,
                        all: 0
                    };

                    r.data.forEach(function(s) {
                        _this.total.breakfast += s.b;
                        _this.total.lunch += s.l;
                        _this.total.dinner += s.d;
                        _this.total.supper += s.s;
                        _this.total.all += s.t;
                    });
                }
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
        openExportForm: function() {
            $('#modal-form-export').modal('show');
        },
        doExport: function() {
            $('#modal-form-export').modal('hide');
            window.location = '{{url("meal/export")}}?from=' + this.exportRange.from + '&to=' + this.exportRange.to;
        },
        confirm: function(employee_id) {
                var _this = this;
                var data = {
                    employee_id: employee_id,
                    date: this.date
                };

                axios.put('{{url("meal/confirm")}}', data).then(function(r) {
                    _this.getData();
                    _this.getSummary();
                    _this.getSummary('location');
                    _this.getSummary('department');
                })

                .catch(function(error) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line);
                });
        },
        confirmSelected: function() {
            var selection = this.checkMe;

            for (i in selection) {
                if (selection[i] == false) {
                    selection.slice(i,1);
                }
            }

            console.log(selection);
        },
        save: function(type, employee_id, location) {
            var _this = this;
            var data = {
                type: type,
                employee_id: employee_id,
                meal_location_id: location,
                date: this.date,
                status: 0
            };

            // console.log(data);

            axios.post('{{url("meal")}}', data).then(function(r) {
                // toastr["success"]("Data berhasil ditambahkan");
                _this.getData();
                _this.getSummary();
                _this.getSummary('location');
                _this.getSummary('department');
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        },
    },
    mounted: function() {
        this.getData();
        this.getSummary();
        this.getSummary('location');
        this.getSummary('department');
    }
});

</script>

@endpush
