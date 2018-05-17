@extends('layouts.app')


@section('content')

<?php $doc_types = array(
    '-- Select --',
    'Job Card Order',
    'Shop Visit Report',
    'Workshop Order',
    'Receiving Document'
); ?>

<div class="col-md-4" id="test">
    <select class="form-control" name="doc_type" v-model="docType">
        <?php foreach ($doc_types as $t) : ?>
            <option value="<?= $t ?>"><?= $t ?></option>
        <?php endforeach ?>
    </select>

    <br>

    <input type="text" name="doc_no" id="doc_no" class="input-lg form-control">
    <br>
    <div class="alert alert-success">
        <ul id="doc_no_list">
        </ul>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

var docNo = '';
var docType = '';
var docList = [];

$('#doc_type').change(function() {
    docType = $(this).val().toLowerCase();
    $('#doc_no').val('').focus();
});

$('#doc_no').keyup(function(e) {
    docNo = $(this).val();

    if (e.keyCode == 13) {
        addToList(docNo);
        $('#doc_no').val('');
    }

    if (docType == 'receiving document' && docNo.length == 10) {
        addToList(docNo);
        $('#doc_no').val('');
    }

    if (docNo[0] == '!' && docNo[docNo.length-1] == '!' && docNo.length >= 18) {
        docNo = docNo.substr(1,12).replace(/^0+/, '');
        addToList(docNo);
        $('#doc_no').val('');
    }

});

var addToList = function(d) {
    $('#doc_no_list').append('<li>'+d+'</li>');
}

</script>

@endpush
