@extends('layouts.app')

@section('content')
<div id="app">
    <jetty></jetty>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({el: '#app'});
</script>
@endpush
