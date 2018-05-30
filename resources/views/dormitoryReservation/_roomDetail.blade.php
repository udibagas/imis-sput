<div id="modal-room-detail" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@{{roomTitle}}</h4>
            </div>
            <table class="table table-striped table-hover" style="border-top:1px solid #ddd; margin:0;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Permit</th>
                        <th>NRP</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Chek In</th>
                        <th>Chek Out</th>
                        <th>Cuti</th>
                        <th>Need</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r,i) in reservations" :class="statusMapping[r.status]">
                        <td>@{{i+1}}.</td>
                        <td>@{{r.permit_number}}</td>
                        <td>@{{r.nrp}}</td>
                        <td>@{{r.name}}</td>
                        <td>@{{r.department}}</td>
                        <td>@{{r.position}}</td>
                        <td>@{{r.check_in}}</td>
                        <td>@{{r.check_out}}</td>
                        <td>@{{r.cuti}} hari</td>
                        <td>@{{r.need}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            </div>
        </div>
    </div>
</div>
