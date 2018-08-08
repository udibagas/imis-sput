<template lang="html">
    <div class="">
        <select v-model="department">
            <option v-for="d in department_list" :value="d.id">{{d.text}}</option>
        </select>
        <select v-model="section">
            <option v-for="d in section_list" :value="d.id">{{d.text}}</option>
        </select>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            section_list: [],
            department_list: []
        }
    },
    methods: {
        getDepartmentList:function() {
            // get from server
        }
    }
}
</script>

<style lang="css">
</style>
