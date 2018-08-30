@extends('layouts.app')

@section('content')
<div id="app">
    <form class="form-inline pull-right">
        <div class="input-group">
            <vue-datepicker placeholder="From" v-model="summary_from"> </vue-datepicker>
            <div class="input-group-addon">To</div>
            <vue-datepicker placeholder="To" v-model="summary_to"> </vue-datepicker>
        </div>
    </form>
    <div class="clearfix">

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <port-activity-summary :from="summary_from" :to="summary_to"></port-activity-summary>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <productivity :from="summary_from" :to="summary_to"></productivity>
            </div>
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
        summary_from: '{{date("Y-m-01")}}',
        summary_to: '{{date("Y-m-d")}}',
    }
});
</script>
@endpush
