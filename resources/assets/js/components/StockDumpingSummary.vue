<template>
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            {{header}}
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align:middle">{{entity}}</th>
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
                <tr v-for="s in summaries">
                    <td>{{s.entity}}</td>
                    <td class="text-center">{{s.unit_1}}</td>
                    <td class="text-center">{{s.unit_2}}</td>
                    <td class="text-center">{{s.unit}}</td>
                    <td class="text-center">{{s.ritase_1 | formatNumber}}</td>
                    <td class="text-center">{{s.ritase_2 | formatNumber}}</td>
                    <td class="text-center">{{s.ritase | formatNumber}}</td>
                    <td class="text-center">{{s.tonase_1 | formatNumber}}</td>
                    <td class="text-center">{{s.tonase_2 | formatNumber}}</td>
                    <td class="text-center">{{s.tonase | formatNumber}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>TOTAL</th>
                    <th class="text-center">{{totalUnit_1 | formatNumber}}</th>
                    <th class="text-center">{{totalUnit_2 | formatNumber}}</th>
                    <th class="text-center">{{totalUnit | formatNumber}}</th>
                    <th class="text-center">{{totalRitase_1 | formatNumber}}</th>
                    <th class="text-center">{{totalRitase_2 | formatNumber}}</th>
                    <th class="text-center">{{totalRitase | formatNumber}}</th>
                    <th class="text-center">{{totalTonase_1 | formatNumber}}</th>
                    <th class="text-center">{{totalTonase_2 | formatNumber}}</th>
                    <th class="text-center">{{totalTonase | formatNumber}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props: ['header', 'entity', 'group', 'from', 'to', 'area'],
    data: function() {
        return {
            summaries: [],
            totalRitase_1: 0,
            totalRitase_2: 0,
            totalRitase: 0,
            totalTonase_1: 0,
            totalTonase_2: 0,
            totalTonase: 0,
            totalUnit_1: 0,
            totalUnit_2: 0,
            totalUnit: 0,
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                group_by: this.group,
                from: this.from,
                to: this.to,
                group_area: this.area
            };
            axios.get(BASE_URL + '/stockDumping/summary', {params: params})

            .then(function(r) {
                _this.summaries = r.data;
                _this.totalRitase = 0;
                _this.totalRitase_1 = 0;
                _this.totalRitase_2 = 0;

                _this.totalTonase = 0;
                _this.totalTonase_1 = 0;
                _this.totalTonase_2 = 0;

                _this.totalUnit = 0;
                _this.totalUnit_1 = 0;
                _this.totalUnit_2 = 0;

                r.data.forEach(function(d) {
                    _this.totalRitase += parseInt(d.ritase);
                    _this.totalRitase_1 += parseInt(d.ritase_1);
                    _this.totalRitase_2 += parseInt(d.ritase_2);

                    _this.totalTonase += parseInt(d.tonase);
                    _this.totalTonase_1 += parseInt(d.tonase_1);
                    _this.totalTonase_2 += parseInt(d.tonase_2);

                    _this.totalUnit += parseInt(d.unit);
                    _this.totalUnit_1 += parseInt(d.unit_1);
                    _this.totalUnit_2 += parseInt(d.unit_2);
                });
            })

            .catch(function(error) {
                console.log(JSON.stringify(error));
            });

            setTimeout(_this.requestData, 5000);
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style scoped>
</style>
