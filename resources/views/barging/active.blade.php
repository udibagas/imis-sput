@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <div class="col-md-4">
        <select2 :options="jetties" v-model="jetty_id" data-placeholder="Jetty">
        </select2>
        <br><br>
        <active-barging :jetty="jetty_id"></active-barging>
    </div>
    <div class="col-md-8">
        <barging-progress></barging-progress>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({
    el: '#app',
    data: {
        jetty_id: 0,
        jetties: {!! App\Jetty::selectRaw('id AS id, name AS text') ->orderBy('name', 'ASC')->get() !!},
    },
    mounted: function() {
        this.jetty_id = this.jetties[0].id;
    }
});
</script>
@endpush
