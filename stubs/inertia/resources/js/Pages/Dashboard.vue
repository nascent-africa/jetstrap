<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Dashboard
            </h2>
        </template>

        <welcome />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
