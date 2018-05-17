@extends('layouts.app')


@section('content')

<?php

$errors = array();

if (isset($_POST['save']))
{
    foreach ($_POST['doc_no'] as $d)
    {
        $sql = "INSERT INTO docfiles
                (doc_no, ...)
            VALUES
                ('{$_POST['doc_no']}', ...)
        ";

        $query = $konek->query($sql);

        $sql = "INSERT INTO doc_log
                (doc_no, ...)
            VALUES
                ('{$_POST['doc_no']}', ...)
        ";

        $konek->query($sql);
    }

}

$doc_types = array(
    '-- Select --',
    'Job Card Order',
    'Shop Visit Report',
    'Workshop Order',
    'Receiving Document'
);

$doc_category = array(
    '-- Select --',
    'Job Card Order',
    'Shop Visit Report',
    'Workshop Order',
    'Receiving Document'
);

?>

<div id="app">
    <h2>Incoming Document</h2>
    <hr>
    <form class="form-vertical well" @submit="checkForm" action="" method="get">
        <div class="alert alert-danger" v-if="errors.length > 0">
            <ul>
                <li v-for="e in errors">@{{e}}</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">User</label>
                    <input type="text" name="" value="" disabled class="form-control" placeholder="User">
                </div>

                <div class="form-group">
                    <label for="">Document Type</label>
                    <select class="form-control" name="doc_type" v-model="docType">
                        <?php foreach ($doc_types as $t) : ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Document Category</label>
                    <select class="form-control" name="doc_category" v-model="docCategory">
                        <?php foreach ($doc_category as $t) : ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> SAVE ALL</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Posting Date</label>
                    <input type="text" name="" value="" class="form-control" placeholder="Posting Date">
                </div>
                <div class="form-group">
                    <label for="">Box</label>
                    <input type="text" name="" v-model="box" class="form-control" placeholder="Box">
                </div>
            </div>
        </div>
        <input type="text" v-model="docNo" id="doc_no" class="form-control" placeholder="Document Number"><br>
        <table class="table table-striped">
            <tbody>
                <tr v-for="d in docList">
                    <td>
                        <input type="hidden" name="doc_no[]" :value="d">
                        @{{d}}
                    </td>
                    <td class="text-right"><button type="button" name="button" class="btn btn-danger" @click="deleteFromList(d)"><i class="fa fa-trash"></i></button></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        box: '',
        docNo: '',
        docType: '',
        docCategory: '',
        errors: [],
        docList: [],
    },
    watch: {
        box: function(v, o) {
            if (v.length == 12) {
                $('#doc_no').val('').focus();
            }
        },
        docNo: function(v, o) {
            if (this.docType.toLowerCase() == 'receiving document'
            && v.length == 10) {
                this.addToList(v);
            }

            if (v[0] == '!' && v[v.length-1] == '!' && v.length >= 18) {
                this.addToList(v.substr(1,12).replace(/^0+/, ''));
            }
        }
    },
    methods: {
        checkForm: function(e) {
            if (this.docType && this.docCategory && this.box && this.docList.length > 0) {
                return true;
            }

            this.errors = [];

            if (!this.docType) {
                this.errors.push('Document type harus diisi.');
            }

            if (!this.docCategory) {
                this.errors.push('Document category harus diisi.');
            }

            if (!this.box) {
                this.errors.push('Box harus diisi.');
            }

            if (this.docList.length == 0) {
                this.errors.push('Document list kosong');
            }

            e.preventDefault();
        },
        addToList: function(v) {
            if (this.docList.indexOf(v) == -1) {
                this.docList.push(v);
            }

            this.docNo = '';
        },
        deleteFromList: function(v) {
            this.docList.splice(this.docList.indexOf(v), 1);
        }
    },
    mounted: function() {
        var vm = this;
        $('#doc_no').keyup(function(e) {
            if (e.keyCode == 13) {
                vm.addToList(vm.docNo);
            }
        });
    }
});

</script>

@endpush
