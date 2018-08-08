<template lang="html">
    <div class="panel panel-default">
        <div class="panel-heading">
            SUMMARY
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>UNIT</th>
                    <th>ACTIVITY</th>
                    <th class="text-right">BUCKET</th>
                    <th class="text-right">VOLUME</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="s in summaries">
                    <td>{{s.unit}}</td>
                    <td>{{activities.filter(a => a.id == s.unit_activity_id)[0].text}}</td>
                    <td class="text-right">{{s.bucket | formatNumber}}</td>
                    <td class="text-right">{{s.volume | formatNumber}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">TOTAL</th>
                    <th class="text-right">{{totalBucket | formatNumber}}</th>
                    <th class="text-right">{{totalVolume | formatNumber}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
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
</style>
