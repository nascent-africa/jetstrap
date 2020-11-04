<template>
    <jet-form-section @submitted="createTeam">
        <template #title>
            Team Details
        </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>
            <div class="mb-4">
                <jet-label value="Team Owner" />

                <div class="d-flex mt-2">
                    <img class="rounded-circle" width="48" :src="$page.user.profile_photo_url" :alt="$page.user.name">

                    <div class="ml-2">
                        <div>{{ $page.user.name }}</div>
                        <div class="text-muted">{{ $page.user.email }}</div>
                    </div>
                </div>
            </div>

            <div class="w-75">
                <div class="form-group">
                    <jet-label for="name" value="Team Name" />
                    <jet-input id="name" type="text" v-model="form.name" autofocus
                               :class="{ 'is-invalid': form.error('name') }" />
                    <jet-input-error :message="form.error('name')" />
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
                    name: '',
                }, {
                    bag: 'createTeam',
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            createTeam() {
                this.form.post(route('teams.store'), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
