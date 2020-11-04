<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Create Team
            </h2>
        </template>

        <create-team-form />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import CreateTeamForm from './CreateTeamForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        props: ['team'],

        components: {
            AppLayout,
            CreateTeamForm,
            JetSectionBorder,
        },
    }
</script>
