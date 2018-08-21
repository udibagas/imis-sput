<template lang="html">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>UNIT</th>
                <th>EGI</th>
                <th>SHIFT</th>
                <th>ACTIVITY</th>
                <th>BUCKET</th>
                <th class="info">VOLUME (TON)</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="s in summaries">
                <td>{{s.unit}}</td>
                <td>{{s.egi}}</td>
                <td>{{s.shift}}</td>
                <td>{{activities.filter(a => a.id == s.unit_activity_id)[0].text}}</td>
                <td>{{s.bucket | formatNumber}}</td>
                <td class="info">{{s.volume | formatNumber}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th class="info" colspan="4">TOTAL</th>
                <th class="info">{{totalBucket | formatNumber}}</th>
                <th class="info">{{totalVolume | formatNumber}}</th>
            </tr>
        </tfoot>
    </table>
</template>

<script>
export default {
    props: ['from', 'to'],
    data: function() {
        return {
            summaries: [],
            totalBucket: 0,
            totalVolume: 0,
            activities: [
                {"id":1,"text":"Hauling"},
                {"id":2,"text":"Feeding"},
                {"id":3,"text":"Load and Carry"},
                {"id":4,"text":"Loading"},
                {"id":5,"text":"Stock Piling"},
                {"id":6,"text":"Breakdown"},
                {"id":7,"text":"Standby"}
            ]
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            let params = {
                from: this.from,
                to: this.to,
            };
            axios.get('portActivity/summary', {params: params}).then(function(r) {
                _this.summaries = r.data;
                _this.totalBucket = 0;
                _this.totalVolume = 0;

                _this.summaries.forEach(function(s) {
                    _this.totalBucket += parseInt(s.bucket);
                    _this.totalVolume+= parseInt(s.volume);
                });

            }).catch(function(error) {
                console.log(error);
            });

            setTimeout(this.requestData, 3000);
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
    th, td {
        vertical-align: middle;
        text-align: center;
    }
</style>
