@extends('layouts.app')

@section('content')
<div id="app">
    <div class="row">
        @foreach ($areas as $a)
        <div class="col-md-6">
            <div class="row">
                <div class="text-center" style="border:1px solid #000;width:100px;margin:0px auto;padding:15px;">
                    <b>JETTY {{$a->jetty}}</b>
                </div>
                @foreach ($a->stockArea()->orderBy('order', 'ASC')->get() as $s)

                <div class="col-md-6 text-right" style="border-right:1px solid red;height:100px;padding:25px 0;">
                    @if ($s->position == 'l')
                    <span class="text-center" style="border:1px solid #000;width:100px;margin:0px auto;padding:15px;">
                        <b>{{$s->name}}</b>
                        {{number_format($s->stock/$s->capacity*100, 2)}}%
                    </span>
                    <span style="display: inline-block;border:1px solid red;height:0px;width:80px;"> </span>
                    @endif
                </div>

                <div class="col-md-6" style="border-left:1px solid red;height:100px;padding:0;">
                    @if ($s->position == 'r')
                    <span style="display:inline-block;border:1px solid red;height:0px;width:80px;"> </span>
                    <span class="text-center" style="border:1px solid #000;width:100px;margin:0px auto;padding:15px;">
                        <b>{{$s->name}}</b>
                    </span>
                    @endif
                </div>

                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    <!-- <operation-dashboard></operation-dashboard>
    <water-level></water-level> -->
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
const app = new Vue({el: '#app'});
</script>
@endpush
