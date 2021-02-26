<template>
  <li class="c-header-nav-item dropdown">
    <a :id="id" class="c-header-nav-link" role="button" data-toggle="dropdown" aria-expanded="false">
      <slot name="trigger"></slot>
    </a>

    <div class="dropdown-menu dropdown-menu-right animate slideIn pt-0" :aria-labelledby="id">
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
  }
}
</script>
