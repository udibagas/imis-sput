@extends('layouts.app')

@section('content')

<div class="row" id="app">
    <div class="col-md-6">
        <div class="row">
            <div class="batu" style="height:100px;width:100px;background-color:#ccc;">

            </div>
            <!-- <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div>
            <div class="col-md-1 batu" style="height:100px;background-color:#ccc;">

            </div> -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="row barge">

        </div>
    </div>
</div>


@endsection


@push('scripts')

<script type="text/javascript">

$('.batu').draggable();
$('.barge').droppable({

});

    // const app = new Vue({
    //     el: '#app',
    //     data: {
    //         stock: {
    //             a: 100,
    //             b: 200
    //         }
    //     },
    //     methods: {
    //         drag: function() {
    //
    //         },ca
    //         drop: function() {
    //
    //         }
    //     },
    //     mounted: function() {
    //
    //     }
    // });
</script>

@endpush
