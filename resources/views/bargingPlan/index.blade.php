@extends('layouts.app')

@section('content')

<div class="panel panel-primary" id="app">
    <div class="panel-body">
        <h3 class="pull-left text-primary">BARGING PLAN</h3>
        <barging-plan></barging-plan>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
const app = new Vue({
    el: '#app'
})

</script>

@endpush