@extends('layouts.app')

@section('content')
<div id="app">
    <!-- <stock-dumping-chart :range="[chartRange.from, chartRange.to]"></stock-dumping-chart> -->
    <form class="form-inline pull-right">
        <div class="form-group">
            <strong>Range :</strong>
            <div class="input-group">
                <vue-datepicker placeholder="From" v-model="chartRange.from"> </vue-datepicker>
                <div class="input-group-addon">To</div>
                <vue-datepicker placeholder="To" v-model="chartRange.to"> </vue-datepicker>
            </div>
        </div>
    </form>
    <div class="clearfix"> </div>
    <ritase-tonase :from="chartRange.from" :to="chartRange.to"></ritase-tonase>

    @if (!auth()->user()->customer_id)
    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'customer_id'"
        :header="'SUMMARY BY CUSTOMER'"
        :entity="'Customer'"></stock-dumping-summary>
    @endif

    @if (!auth()->user()->contractor_id)
    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'contractor_id'"
        :header="'SUMMARY BY CONTRACTOR'"
        :entity="'Contractor'"></stock-dumping-summary>
    @endif

    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'material_type'"
        :header="'SUMMARY BY MATERIAL TYPE'"
        :entity="'Material Type'"></stock-dumping-summary>

    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'seam_id'"
        :header="'SUMMARY BY SEAM'"
        :entity="'Seam'"></stock-dumping-summary>

    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'subcont_id'"
        :header="'SUMMARY BY SUBCONT'"
        :entity="'Subcont'"></stock-dumping-summary>

    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'area_id'"
        :header="'SUMMARY BY BLOCK AREA'"
        :entity="'Block Area'"></stock-dumping-summary>

    <stock-dumping-summary
        :from="chartRange.from"
        :to="chartRange.to"
        :group="'stock_area_id'"
        :header="'SUMMARY BY STOCK AREA'"
        :entity="'Stock Area'"></stock-dumping-summary>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({
    el: '#app',
    data: {
        chartRange: {
            from: '{{date("Y-m-d")}}',
            to: '{{date("Y-m-d")}}'
        },
    },
    methods: {

    }
})
</script>
@endpush
