<template lang="html">
    <div class="panel panel-primary">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in dwellingTimes">
                    <td>{{d.time}}</td>
                    <td>{{d.description}}</td>
                    <td>{{d.status}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['jetty'],
    data: function() {
        return {
            dwellingTimes: []
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                jetty_id: _this.jetty
            };

            axios.get(BASE_URL + '/dwellingTime', {params:params})
                .then(function(r) {
                    _this.dwellingTimes = r.data;
                })
                .catch(function(e) {
                    console.log(e);
                });

            setTimeout(this.requestData, 3000);
        }
    },
    mounted: function() {
        setTimeout(this.requestData, 200);
    }
}
</script>

<style lang="css">
</style>
