<template lang="html">
    <div class="row">
        <div class="col-md-6" v-for="j in jetties">
            <div class="panel panel-default panel-body">
                <h3 class="text-center">JETTY {{j.name}}</h3>
                <div class="box">
                    BARGE X
                </div>
                <!-- untuk stock area -->
                <div class="row" v-for="row in j.stockAreaMap">
                    <div class="vertical-line" v-if="row.filter(r => r.position == 'l' || r.position == 'c' || r.position == 'r').length > 0"> </div>
                    <!-- ini kalau ada 3  -->
                    <div class="col-md-4" v-if="row.length == 3">
                        <div class="box">
                            {{row.filter(r => r.position == 'l')[0].name}}
                        </div>
                    </div>
                    <div class="col-md-4" v-if="row.length == 3">
                        <div class="box">
                            {{row.filter(r => r.position == 'c')[0].name}}
                        </div>
                    </div>
                    <div class="col-md-4" v-if="row.length == 3">
                        <div class="box">
                            {{row.filter(r => r.position == 'r')[0].name}}
                        </div>
                    </div>
                    <!-- ini kalau ada 2 -->
                    <div class="col-md-6 right-border" v-if="row.length == 2">
                        <div class="box">
                            {{row.filter(r => r.position == 'l')[0].name}}
                        </div>
                    </div>
                    <div class="col-md-6" v-if="row.length == 2">
                        <div class="box">
                            {{row.filter(r => r.position == 'r')[0].name}}
                        </div>
                    </div>
                    <!-- ini kalau cuma 1  -->
                    <div class="col-md-6 right-border" v-if="row.length == 1">
                        <div class="box" v-if="row[0].position == 'l'">
                            {{row[0].name}}
                        </div>
                    </div>
                    <div class="col-md-6 left-border" v-if="row.length == 1">
                        <div class="box" v-if="row[0].position == 'r'">
                            {{row[0].name}}
                        </div>
                    </div>
                    <div class="col-md-12" v-if="row.length == 1 && row[0].position == 'c'">
                        <div class="box">
                            {{row[0].name}}
                        </div>
                    </div>
                    <div class="col-md-12" v-if="row.length == 1 && row[0].position == 'o'">
                        <br><br><br>
                        <div class="box">
                            {{row[0].name}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data: function() {
        return {
            jetties: []
        }
    },
    methods: {
        requestData: function() {
            let _this = this;
            axios.get('api/jetty').then(function(r) {
                _this.jetties = r.data;
            }).catch(function(e) {
                console.log(e);
            });
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css" scoped>
.box {
    border: 1px solid #999;
    text-align: center;
    width: 150px;
    margin: 0px auto;
    padding: 15px;
}

.vertical-line {
    height: 50px;
    width: 0;
    margin: 0 auto;
    border: 1px solid red;
}

.right-border {
    border-right: 1px solid red;
}

.left-border {
    border-left: 1px solid red;
}
</style>
