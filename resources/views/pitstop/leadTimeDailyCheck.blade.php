@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <div class="col-md-3">
        <div class="panel minimal panel-default">
			<div class="panel-heading clearfix">
				<div class="panel-title text-primary">ACHIEVEMENT DAILY CHECK</div>
			</div>
			<div class="panel-body">
				<div class="row col-with-divider">
					<div class="col-xs-6 text-center stack-order">
						<h1 class="no-margins">@{{achievement.plan}}</h1>
						<strong>PLAN</strong>
					</div>
					<div class="col-xs-6 text-center stack-order">
						<h1 class="no-margins">@{{achievement.actual}}</h1>
						<strong>ACTUAL</strong>
					</div>
				</div>
			</div>
		</div>
        <div class="panel minimal panel-default">
			<div class="panel-heading clearfix">
				<div class="panel-title text-primary">TODAY PLAN DAILY CHECK</div>
			</div>
			<table class="table table-striped table-bordered">
			    <thead>
			        <tr>
			            <th style="font-weight:bold;">UNIT</th>
			            <th style="font-weight:bold;">DURASI</th>
			            <th style="font-weight:bold;">TIME OUT</th>
			        </tr>
			    </thead>
                <tbody>
                    <tr v-for="i in todayPlans">
                        <td>@{{i.unit}}</td>
                        <td>@{{i.durasi}}</td>
                        <td>@{{i.timeout}}</td>
                    </tr>
                </tbody>
			</table>
		</div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                LEAD TIME DAILY CHECK
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>LOCATION</th>
                        <th>UNIT</th>
                        <th>SHIFT</th>
                        <th>DATE IN</th>
                        <th>DURASI</th>
                        <th>DESKRIPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in pitstops">
                        <td></td>
                        <td>@{{p.location}}</td>
                        <td>@{{p.unit}}</td>
                        <td>@{{p.shift}}</td>
                        <td>@{{p.time_in}}</td>
                        <td></td>
                        <td>@{{p.description}}</td>
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
        pitstops: [],
        achievement: {
            plan: 0,
            actual: 0
        },
        todayPlans: []
    },
    methods: {
        getData: function() {
            var _this = this;
            axios.get('{{url("pitstop/leadTimeDailyCheck")}}').then(function(r) {
                _this.pitstops = r.data;
            })

            .catch(function(error) {
                if (error.response.status == 500) {
                    var error = error.response.data;
                    toastr["error"](error.message + ". " + error.file + ":" + error.line)
                }
            });

            setTimeout(_this.getData, 3000);
        },
        getDataAchievementDailyCheck: function() {
            var _this = this;
            axios.get('{{url("breakdown/achievementDailyCheck")}}').then(function(r) {
                _this.achievement = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });

            setTimeout(_this.getDataAchievementDailyCheck, 3000);
        },
        getDataTodayPlanDailyCheck: function() {
            var _this = this;
            axios.get('{{url("breakdown/todayPlanDailyCheck")}}').then(function(r) {
                _this.todayPlans = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line)
            });

            setTimeout(_this.getDataTodayPlanDailyCheck, 3000);
        },
    },
    mounted: function() {
        this.getData();
        this.getDataAchievementDailyCheck();
        this.getDataTodayPlanDailyCheck();
    }
});

</script>
@endpush
