@extends('layouts.app')

@section('content')

<div class="row text-center" style="width:1000px;margin:auto;">
    <h1>Welcome to POINS!<br>
        <small>Port Operation Integrated System</small>
    </h1>

    <br>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="{{url('leadTimeBreakdownUnit')}}">
                    <div class="stack-order">
                        <div class="fa fa-wrench fa-3x"></div>
                        <h1 class="no-margins">PLANT</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="{{url('sm')}}">
                    <div class="stack-order">
                        <div class="fa fa-map-marker fa-3x"></div>
                        <h1 class="no-margins">SM</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="{{url('operation')}}">
                    <div class="stack-order">
                        <div class="fa fa-cogs fa-3x"></div>
                        <h1 class="no-margins">OPERATION</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="{{url('hcgs')}}">
                    <div class="stack-order">
                        <div class="fa fa-users fa-3x"></div>
                        <h1 class="no-margins">HCGS</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="{{url('she')}}">
                    <div class="stack-order">
                        <div class="fa fa-medkit fa-3x"></div>
                        <h1 class="no-margins">SHE</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="{{url('fat')}}">
                    <div class="stack-order">
                        <div class="fa fa-dollar fa-3x"></div>
                        <h1 class="no-margins">FAT</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.page-container').addClass('sidebar-collapsed');
</script>
@endpush()
