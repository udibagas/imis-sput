@extends('layouts.app')

@section('content')
<div id="app">
    <barging-report></barging-report>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({
    el: '#app',
    data() {
        return {
        }
    }
});
</script>
@endpush
