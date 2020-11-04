<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Profile
            </h2>
        </template>

        <update-profile-information-form
            :user="$page.user" />

        <jet-section-border />

        <update-password-form />

        <div v-if="$page.jetstream.canManageTwoFactorAuthentication">
            <jet-section-border />

            <two-factor-authentication-form />
        </div>

        <jet-section-border />

        <logout-other-browser-sessions-form :sessions="sessions" />

        <jet-section-border />

        <delete-user-form />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteUserForm from './DeleteUserForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'

    export default {
        props: ['sessions'],

        components: {
            AppLayout,
            DeleteUserForm,
            JetSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
        },
    }
</script>
