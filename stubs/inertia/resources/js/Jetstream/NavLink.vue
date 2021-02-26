<template>
  <li class="nav-item">
    <inertia-link :href="href" :class="classes">
      <slot></slot>
    </inertia-link>
  </li>
</template>

<script>
  export default {
    props: ['href', 'active'],

    computed: {
      classes() {
        return this.active
            ? 'nav-link active font-weight-bolder'
            : 'nav-link'
      }
    }
  }
</script>
