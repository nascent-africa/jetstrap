<template>
  <input class="form-control" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

<script>
  export default {
    props: ['modelValue'],

    emits: ['update:modelValue'],

    methods: {
      focus() {
        this.$refs.input.focus()
      }
    }
  }
</script>

