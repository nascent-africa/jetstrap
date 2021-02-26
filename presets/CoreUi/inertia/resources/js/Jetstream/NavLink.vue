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
          ? 'c-header-nav-link active font-weight-bold'
          : 'c-header-nav-link'
    }
  }
}
</script>
