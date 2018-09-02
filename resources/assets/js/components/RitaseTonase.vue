<template lang="html">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            TOTAL SUMMARY
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" colspan="3">UNIT</th>
                    <th class="text-center" colspan="3">RITASE</th>
                    <th class="text-center" colspan="3">VOLUME (KG)</th>
                </tr>
                <tr>
                    <th class="text-center">SHIFT 1</th>
                    <th class="text-center">SHIFT 2</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">SHIFT 1</th>
                    <th class="text-center">SHIFT 2</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">SHIFT 1</th>
                    <th class="text-center">SHIFT 2</th>
                    <th class="text-center">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center text-primary"><h2>{{unit_1 | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{unit_2 | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{unit | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{ritase_1 | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{ritase_2 | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{ritase | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{tonase_1 | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{tonase_2 | formatNumber}}</h2></td>
                    <td class="text-center text-primary"><h2>{{tonase | formatNumber}}</h2></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['from', 'to'],
    data: function() {
        return {
            ritase: 0,
            ritase_1: 0,
            ritase_2: 0,
            tonase: 0,
            tonase_1: 0,
            tonase_2: 0,
            unit: 0,
            unit_1: 0,
            unit_2: 0,
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            let params = {
                from: _this.from,
                to: _this.to
            };
            axios.get(BASE_URL + '/stockDumping/tonase', {params: params})
                .then(function(r) {
                    _this.tonase = r.data[0].tonase ? r.data[0].tonase : 0;
                    _this.tonase_1 = r.data[0].tonase_1 ? r.data[0].tonase_1 : 0;
                    _this.tonase_2 = r.data[0].tonase_2 ? r.data[0].tonase_2 : 0;
                    _this.ritase = r.data[0].ritase ? r.data[0].ritase : 0;
                    _this.ritase_1 = r.data[0].ritase_1 ? r.data[0].ritase_1 : 0;
                    _this.ritase_2 = r.data[0].ritase_2 ? r.data[0].ritase_2 : 0;
                    _this.unit = r.data[0].unit ? r.data[0].unit : 0;
                    _this.unit_1 = r.data[0].unit_1 ? r.data[0].unit_1 : 0;
                    _this.unit_2 = r.data[0].unit_2 ? r.data[0].unit_2 : 0;
                })
                .catch(function(error) {
                    console.log(JSON.stringify(error));
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
    h2 {
        margin-top: 10px;
    }
</style>
