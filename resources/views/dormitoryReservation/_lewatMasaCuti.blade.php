<div class="panel panel-default" v-if="lewatMasaCuti.length > 0">
    <div class="panel-heading">
        <div class="pull-right">
            <input type="text" placeholder="Search" class="form-control" v-model="searchLewatMasaCuti">
        </div>
        MENDEKATI/LEWAT MASA CUTI
        <div class="clearfix"> </div>
    </div>
    <!-- <div class="panel-body"> -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Permit</th>
                    <th>NRP</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Dormitory</th>
                    <th>Room</th>
                    <th>Need</th>
                    <th>Chek In</th>
                    <th>Chek Out</th>
                    <th>Cuti</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(r,i) in lewatMasaCuti.filter(l => l.name.toLowerCase().includes(searchLewatMasaCuti))" :class="statusMapping[r.status]">
                    <td>@{{i+1}}.</td>
                    <td>@{{r.permit_number}}</td>
                    <td>@{{r.nrp}}</td>
                    <td>@{{r.name}}</td>
                    <td>@{{r.department}}</td>
                    <td>@{{r.position}}</td>
                    <td>@{{r.dormitory}}</td>
                    <td>@{{r.room}}</td>
                    <td>@{{r.need}}</td>
                    <td>@{{r.check_in}}</td>
                    <td>@{{r.check_out}}</td>
                    <td>@{{r.cuti}} hari</td>
                </tr>
            </tbody>
        </table>
    <!-- </div> -->
</div>
