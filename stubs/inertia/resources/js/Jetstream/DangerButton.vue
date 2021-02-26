<template>
  <button :type="type" class="btn btn-danger text-white text-uppercase">
    <slot></slot>
  </button>
</template>

<script>
  export default {
    props: {
      type: {
        type: String,
        default: 'button',
      },
    }
  }
</script>
