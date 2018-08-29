<template lang="html">
    <div v-if="text !== null" id="runningText" style="height:50px;background-color:#00B8CE;padding:10px;color:white;font-size:20px;">
        <div class="marquee">
            @{{text}}
        </div>
    </div>
</template>

<script>
const runningText = new Vue({
    el: '#runningText',
    data: {
        text: null
    },
    methods: {
        getData: function() {
            var _this = this;
            _this.text = "";

            axios.get(BASE_URL + 'api/runningText').then(function(r) {

                if (r.data.length == 0) {
                    _this.text = null;
                }

                r.data.forEach(function(d) {
                    _this.text += " :: ";
                    _this.text += d.text;
                });

            });

            setTimeout(_this.getData, 5000);
        },
        runMarquee: function() {
            $('.marquee').marquee({
                duration: 20000,
                pauseOnHover: true
            });
        },
    },
    mounted: function() {
        // this.getData();
        // this.runMarquee();
    }
});
</script>

<style lang="css" scoped>
</style>
