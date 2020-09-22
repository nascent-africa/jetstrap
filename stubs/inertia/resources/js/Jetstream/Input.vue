<template>
    <input class="form-control" :value="value" @input="$emit('input', $event.target.value)" ref="input">
</template>

<script>
    export default {
        props: ['value', 'classes'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

