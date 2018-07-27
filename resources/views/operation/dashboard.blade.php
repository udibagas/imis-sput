@extends('layouts.app')

@section('content')
<div id="app">
    <operation-dashboard></operation-dashboard>
    <water-level></water-level>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({el: '#app'});
</script>
@endpush
