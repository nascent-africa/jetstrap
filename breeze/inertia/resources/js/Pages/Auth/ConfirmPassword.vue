<template>
  <div class="card-body">

    <div class="mb-2">
      This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <breeze-validation-errors class="mb-2" />

    <form @submit.prevent="submit">
      <div class="form-group">
        <breeze-label for="password" value="Password" />
        <breeze-input id="password" type="password" v-model="form.password" required autocomplete="current-password" autofocus />
      </div>

      <div class="d-flex justify-content-end mt-2">
        <breeze-button class="ml-4" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
          Confirm
        </breeze-button>
      </div>
    </form>
  </div>
</template>

<script>
import BreezeButton from '@/Components/Button'
import BreezeGuestLayout from "@/Layouts/Guest"
import BreezeInput from '@/Components/Input'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
  layout: BreezeGuestLayout,

  components: {
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
  },

  data() {
    return {
      form: this.$inertia.form({
        password: '',
      })
    }
  },

  methods: {
    submit() {
      this.form.post(this.route('password.confirm'), {
        onFinish: () => this.form.reset(),
      })
    }
  }
}
</script>
