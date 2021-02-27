<template>
  <div class="container">
    <div class="row justify-content-center my-5">
      <div class="col-sm-12 col-md-8 col-lg-5 my-5">
        <div class="d-flex justify-content-center mb-3">
          <inertia-link href="/">
            <breeze-application-logo width="82" />
          </inertia-link>
        </div>

        <div class="card shadow-sm px-3">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo'

export default {
  components: {
    BreezeApplicationLogo,
  }
}
</script>
