@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <div class="col-md-3">
        <div class="panel minimal panel-default">
			<div class="panel-heading clearfix">
				<div class="panel-title text-primary">REMARK UNIT BY TYPE</div>
			</div>
			<table class="table table-striped table-bordered">
			    <thead>
			        <tr>
			            <th style="font-weight:bold;">TYPE</th>
			            <th style="font-weight:bold;text-align:center;">READY</th>
			            <th style="font-weight:bold;text-align:center;">B/D</th>
			        </tr>
			    </thead>
                <tbody>
                    <tr v-for="i in remarkUnitByType">
                        <td>@{{i.category}}</td>
                        <td style="text-align:center;">@{{i.ready}}</td>
                        <td style="text-align:center;">@{{i.breakdown}}</td>
                    </tr>
                </tbody>
			</table>
		</div>

        <div class="panel minimal panel-default">
			<div class="panel-heading clearfix">
				<div class="panel-title text-primary">UNIT YANG BARU READY</div>
			</div>
			<table class="table table-striped table-bordered">
                <tbody>
                    <tr v-for="u in unitBaruReady">
                        <td>@{{u.name}}</td>
                        <td>@{{u.time}}</td>
                    </tr>
                </tbody>
			</table>
		</div>

        <div class="panel minimal panel-default">
			<div class="panel-heading clearfix">
				<div class="panel-title text-primary">TODAY PLAN SERVICE</div>
			</div>
			<table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
			</table>
		</div>

        <div class="panel minimal panel-default">
			<div class="panel-heading clearfix">
				<div class="panel-title text-primary">TOMORROW PLAN SERVICE</div>
			</div>
			<table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
			</table>
		</div>

    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                STATUS & LEAD TIME B/D UNIT
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>UNIT</th>
                        <th>TYPE</th>
                        <th>JENIS B/D</th>
                        <th>LOKASI B/D</th>
                        <th>PROBLEM</th>
                        <th>TIME IN</th>
                        <th>DOWN TIME</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="b in breakdowns" :class="rowClass[b.breakdown_category]">
                        <td></td>
                        <td>@{{b.unit}}</td>
                        <td>@{{b.unit_category}}</td>
                        <td>@{{b.breakdown_category}}</td>
                        <td>@{{b.location}}</td>
                        <td>@{{b.diagnosa}}</td>
                        <td>@{{b.time_in}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        breakdowns: [],
        remarkUnitByType: [],
        rowClass: {
            ICM: 'danger',
            USM: 'warning',
            SCM: 'info',
            TRM: 'warning',
        }
    },
    methods: {
        getData: function() {
            var _this = this;
            axios.get('{{url("breakdown/leadTimeBreakdownUnit")}}').then(function(r) {
                _this.breakdowns = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });

            setTimeout(_this.getData, 3000);
        },
        getDataRemarkUnitByType: function() {
            var _this = this;
            axios.get('{{url("unit/remarkUnitByType")}}').then(function(r) {
                _this.remarkUnitByType = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });

            setTimeout(_this.getDataRemarkUnitByType, 3000);
        }
    },
    mounted: function() {
        this.getData();
        this.getDataRemarkUnitByType();
    }
});

</script>
@endpush
