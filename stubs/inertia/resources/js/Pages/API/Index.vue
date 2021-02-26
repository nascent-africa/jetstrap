<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                API Tokens
            </h2>
        </template>

        <api-token-manager :tokens="tokens"
                           :available-permissions="availablePermissions"
                           :default-permissions="defaultPermissions" />
    </app-layout>
</template>

<script>
    import ApiTokenManager from './ApiTokenManager'
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],

        components: {
            ApiTokenManager,
            AppLayout
        },
    }
</script>
