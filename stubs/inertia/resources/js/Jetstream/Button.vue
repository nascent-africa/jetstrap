<template>
  <button :type="type" class="btn btn-dark text-uppercase">
    <slot></slot>
  </button>
</template>

<script>
  export default {
    props: {
      type: {
        type: String,
        default: 'submit',
      },
    }
  }
</script>
