<template>
  <button type="submit" style="min-width: 0" @click="$emit('clicked')" class="dropdown-item" v-if="as == 'button'">
    <slot></slot>
  </button>

  <inertia-link style="min-width: 0" :href="href" class="dropdown-item" v-else>
    <slot></slot>
  </inertia-link>
</template>

<script>
export default {
  emits: ['clicked'],
  props: ['href', 'as']
}
</script>
