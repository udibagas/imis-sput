@extends('layouts.app')

@section('content')
<div id="app">
    <daily-check-setting>
    </daily-check-setting>
</div>
@endsection

@push('scripts')

<script type="text/javascript">

const app = new Vue({
    el: '#app'
});

</script>

@endpush
