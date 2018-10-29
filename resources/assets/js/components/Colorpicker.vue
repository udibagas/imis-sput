<template lang="html">
    <input type="text" class="form-control" data-format="hex">
</template>

<script>
export default {
    props: ['value'],
    watch: {
        value: function (value) {
            $(this.$el).val(value).trigger('change');
        },
    },
    mounted: function () {
        var vm = this;

        $(this.$el).colorpicker()
        .val(this.value)
        .trigger('change')
        .on('changeColor', function (e) {
            vm.$emit('input', this.value);
        });
    },
    destroyed: function () {
        $(this.$el).off().colorpicker('destroy');
    }
}
</script>

<style lang="css">
</style>
