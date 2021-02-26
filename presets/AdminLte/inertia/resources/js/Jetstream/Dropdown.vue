<template>
  <li :class="classes">
    <a :id="id" href="#" class="nav-link" role="button" data-toggle="dropdown" aria-expanded="false">
      <slot name="trigger"></slot>
    </a>

    <div class="dropdown-menu dropdown-menu-right animate slideIn" :aria-labelledby="id">
      <slot name="content"></slot>
    </div>
  </li>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    },

    classes: {
      type: String,
      default: 'nav-item dropdown'
    }
  }
}
</script>
