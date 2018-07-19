@extends('layouts.app')

@section('content')
<div id="app">
    <operation-dashboard></operation-dashboard>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$('.page-container').addClass('sidebar-collapsed');

const app = new Vue({
    el: '#app',
    data: {
    },
    methods: {
    },
    mounted: function() {

    }
});
</script>
@endpush
