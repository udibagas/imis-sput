@extends('layouts.app')


@section('content')

<input type="text" name="" value="" id="doc_no" class="input-lg form-control">
<br>
<div class="alert alert-success">
    <ul id="doc_no_list">
    </ul>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

// detect kapan terakhir dia change. kalau ga ada perubahan dalam 200 milliseconds baru di enter, kecuali dia kirim

var lastChange = null;
var docNo = '';

$('#doc_no').keyup(function(e) {
    lastChange = new Date();
    docNo = $(this).val();

    if (e.keyCode == 13) {
        addToList(docNo);
        $('#doc_no').val();
        // console.log(e);
    }

});


var parseIt = function(docNo) {
    if (docNo.length == 22 || docNo.length == 18) {
        return docNo.substr(1,12).replace(/^0+/, '');
    }

    if (docNo.length == 10) {
        return docNo;
    }

    return false;
}

var addToList = function(v) {
    $('#doc_no_list').append('<li>'+v+'</li>');
}

</script>

@endpush
