@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <active-barging></active-barging>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({
    el: '#app'
});
</script>
@endpush
