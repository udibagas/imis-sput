<template lang="html">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="2">UNIT</th>
                <th rowspan="2">EGI</th>
                <th rowspan="2">SHIFT</th>
                <th rowspan="2">ACTIVITY</th>
                <th colspan="3">PRODUCTIVITY</th>
                <th rowspan="2">BUCKET</th>
                <th rowspan="2">VOLUME</th>
            </tr>
            <tr>
                <th style="width:100px;">PLAN</th>
                <th style="width:100px;">ACTUAL</th>
                <th style="width:100px;">ACHIEVEMENT</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="s in summaries">
                <td>{{s.unit}}</td>
                <td>{{s.egi}}</td>
                <td class="text-center">{{s.shift}}</td>
                <td>{{activities.filter(a => a.id == s.unit_activity_id)[0].text}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">{{s.bucket | formatNumber}}</td>
                <td class="text-center">{{s.volume | formatNumber}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{totalBucket | formatNumber}}</th>
                <th>{{totalVolume | formatNumber}}</th>
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
    table tr th {
        vertical-align: middle;
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
</style>
