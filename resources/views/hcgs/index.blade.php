@extends('layouts.app')

@section('content')

<div id="app">
<h1>HCGS DASHBOARD</h1>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {},
    methods: {

    },
    mounted: function() {

    }
});

</script>
@endpush
