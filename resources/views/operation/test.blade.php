@extends('layouts.app')


@section('content')
<div id="app">
    <h1>Request Creation</h1>
    <hr>
    <div class="row">
        <label for="" class="col-md-3">User ID</label>
        <div class="col-md-9">

        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-3">Request Date</label>
        <div class="col-md-9">
            <?php echo date('d F Y') ?>
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-3">Return Date</label>
        <div class="col-md-9">
            @{{returnDate}}
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-3">Request Option</label>
        <div class="col-md-9">
            <input type="radio" name="" value="Phase Out">Phase Out <br>
            <input type="radio" name="" value="Disposed">Disposed <br>
            <input type="radio" name="" value="Borrowed">Borrowed
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-3">Status</label>
        <div class="col-md-9">
            Open
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-3">Reason</label>
        <div class="col-md-9">
            <textarea name="reason" rows="8" class="form-control"></textarea>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        returnDate: '',
    },
    watch: {

    },
    methods: {

    },
    mounted: function() {
        now = new Date();
        returnDate = new Date(now.getTime() + 7*24*60*60*1000);
        this.returnDate = new Date(returnDate);
    }
});

</script>

@endpush
