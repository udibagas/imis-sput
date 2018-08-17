<template lang="html">
    <div class="panel minimal panel-default">
        <div class="panel-body">
            <div class="row col-with-divider">
                <div class="col-xs-6 text-center stack-order">
                    RITASE
                    <h1 class="no-margins text-success">{{ritase | formatNumber}}</h1>
                </div>
                <div class="col-xs-6 text-center stack-order">
                    VOLUME (KG)
                    <h1 class="no-margins text-success">{{tonase | formatNumber}}</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['from', 'to'],
    data: function() {
        return {
            ritase: 0,
            tonase: 0
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            let params = {
                from: _this.from,
                to: _this.to
            };
            axios.get('stockDumping/tonase', {params: params})
                .then(function(r) {
                    _this.tonase = r.data[0].tonase ? r.data[0].tonase : 0;
                    _this.ritase = r.data[0].ritase ? r.data[0].ritase : 0;
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

<style lang="css">
</style>
