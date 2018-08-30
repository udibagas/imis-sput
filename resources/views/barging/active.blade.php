@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <div class="col-md-5">
        @if (!auth()->user()->customer_id)
        <select2 :options="customers" v-model="customer_id" data-placeholder="Customer">
        </select2>
        <br><br>
        @endif
        <active-barging :customer="customer_id"></active-barging>
    </div>
    <div class="col-md-7">
        Timeline dwelling time will be here...
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({
    el: '#app',
    data: {
        customer_id: 0,
        customers: {!! App\Customer::selectRaw('customers.id AS id, customers.name AS text')
            ->join('bargings', 'bargings.customer_id', '=', 'customers.id')
            ->orderBy('customers.name', 'ASC')->get() !!},
    },
    mounted: function() {
        this.customer_id = this.customers[0].id;
    }
});
</script>
@endpush
