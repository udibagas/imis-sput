@extends('layouts.app')


@section('content')

<div id="app">
    <stock></stock>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
const app = new Vue({
    el: '#app'
});
</script>

@endpush
