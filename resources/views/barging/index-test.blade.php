@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <div class="col-md-3">
        <active-barging></active-barging>
    </div>
    <div class="col-md-9">

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
const app = new Vue( {el: '#app'} );
</script>
@endpush
