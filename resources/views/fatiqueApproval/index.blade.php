@extends('layouts.app')

@section('content')

<div class="panel panel-default" id="app">
    <div class="panel-heading">
        <span class="text-primary">FATIQUE APPROVAL</span>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NRP</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th class="text-center">Shift</th>
                    <th class="text-center">Lama Tidur Kemarin</th>
                    <th class="text-center">Lama Tidur Hari Ini</th>
                    <th class="text-center">Minum Obat</th>
                    <th class="text-center">Ada Masalah</th>
                    <th class="text-center">Siap Bekerja</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in data" :class="rowClass[d.approval_status]">
                    <td>@{{d.nrp}}</td>
                    <td>@{{d.name}}</td>
                    <td>@{{d.tgl}}</td>
                    <td class="text-center">@{{d.shift}}</td>
                    <td class="text-center">@{{d.tidur_kemarin}}</td>
                    <td class="text-center">@{{d.tidur_hari_ini}}</td>
                    <td class="text-center">@{{d.minum_obat ? 'Y' : 'T'}}</td>
                    <td class="text-center">@{{d.ada_masalah ? 'Y' : 'T'}}</td>
                    <td class="text-center">@{{d.siap_bekerja ? 'Y' : 'T'}}</td>
                    <td class="text-right">
                        <button type="button" @click="update(d.id, 1)" class="btn btn-success btn-sm" title="Disetujuti"><i class="icon-check"></i></button>
                        <button type="button" @click="update(d.id, 2)" class="btn btn-warning btn-sm" title="Butuh Pengawasan">!</button>
                        <button type="button" @click="update(d.id, 3)" class="btn btn-danger btn-sm" title="Tidak Boleh Bekerja"><i class="icon-cancel"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

const app = new Vue({
    el: '#app',
    data: {
        data: [],
        rowClass: {
            0: 'default',
            1: 'success',
            2: 'warning',
            3: 'danger',
        }
    },
    methods: {
        getData: function() {
            var _this = this;
            axios.get("{{url('fatiqueApproval')}}").then(function(r) {
                _this.data = r.data;
            })

            .catch(function(error) {
                var error = error.response.data;
                toastr["error"](error.message + ". " + error.file + ":" + error.line);
            });

            setTimeout(this.getData, 3000);
        },
        update: function(id, status) {
            titles = {
                1: "DISETUJUI",
                2: "BUTUH PENGAWASAN",
                3: "TIDAK BOLEH BEKERJA"
            };
            bootbox.confirm({
                title: titles[status],
                message: "Anda yakin?",
                callback: function(r) {
                    if (r == true) {
                        var _this = this;
                        axios.put("{{url('fatiqueApproval')}}/" + id, {approval_status:status})

                        .then(function(r) {
                            toastr["success"]("Data berhasil diupdate");
                        })

                        .catch(function(error) {
                            var error = error.response.data;
                            toastr["error"](error.message + ". " + error.file + ":" + error.line);
                        });
                    }
                }
            });
        },
    },
    mounted: function() {
        this.getData();
    }
});

</script>
@endpush
