<template>

  <div class="card-body">
    <div class="mb-3 small text-muted">
      Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
    </div>

    <div class="alert alert-success" role="alert" v-if="verificationLinkSent" >
      A new verification link has been sent to the email address you provided during registration.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 d-flex justify-content-between">
        <breeze-button :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
          Resend Verification Email
        </breeze-button>

        <inertia-link :href="route('logout')" method="post" as="button" class="btn btn-link">Log out</inertia-link>
      </div>
    </form>
  </div>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeGuestLayout from "@/Layouts/Guest"

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
