@extends('layouts.app')

@section('content')
<div id="app" style="width:500px;margin:50px auto 0;">
    <div class="text-danger text-center" style="font-size:100px;">@{{jam}}</div>
    <input type="text" v-model="nrp" class="form-control" style="font-size:50px;height:100px;text-align:center;" placeholder="NRP" @keypress="checkNrp">
    <br>
    <div class="alert alert-success text-center" v-if="success">
        <h1>Selamat datang, @{{nrp}}!</h1>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        nrp: '',
        success: false,
        jam: moment().format('HH:mm:ss')
    },
    watch: {
        nrp: function(v, o) {
            if (v.length == 7) {
                this.absen(v);
            }
        }
    },
    methods: {
        absen: function(nrp) {
            this.nrp = '';
            this.success = true;
        },
        checkNrp: function(e) {
            if (e.keyCode == 13) {
                this.absen(this.nrp);
            }
        }
    },
    mounted: function() {
        var _this = this;
        setInterval(function() {
            _this.jam = moment().format('HH:mm:ss');
        }, 1000);
    }
});

</script>
@endpush
