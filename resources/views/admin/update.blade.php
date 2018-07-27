@extends('layouts.app')

@section('content')
<div id="app" class="panel panel-primary">
    <div class="panel-body">
        <a href="#" class="btn btn-primary" @click="update">UPDATE</a>
        <br><br>

        <div class="alert alert-success" v-if="messages.length > 0">
            <ul>
                <li v-for="m in messages">@{{m}}</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        messages: []
    },
    methods: {
        update: function() {
            var _this = this;
            axios.get('{{url("doUpdate")}}').then(function(r) {
                _this.messages = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });
        }
    },
    mounted: function() {

    }
});

</script>
@endpush
