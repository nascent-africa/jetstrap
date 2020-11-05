<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="w-75">
                <div class="mb-3">
                    <jet-label for="current_password" value="Current Password" />
                    <jet-input id="current_password" type="password"
                               :class="{ 'is-invalid': form.error('current_password') }" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                    <jet-input-error :message="form.error('current_password')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <jet-label for="password" value="New Password" />
                    <jet-input id="password" type="password"
                               :class="{ 'is-invalid': form.error('password') }" v-model="form.password" autocomplete="new-password" />
                    <jet-input-error :message="form.error('password')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <jet-label for="password_confirmation" value="Confirm Password" />
                    <jet-input id="password_confirmation" type="password"
                               :class="{ 'is-invalid': form.error('password_confirmation') }" v-model="form.password_confirmation" autocomplete="new-password" />
                    <jet-input-error :message="form.error('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }, {
                    bag: 'updatePassword',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    preserveScroll: true
                }).then(() => {
                    this.$refs.current_password.focus()
                })
            },
        },
    }
</script>
