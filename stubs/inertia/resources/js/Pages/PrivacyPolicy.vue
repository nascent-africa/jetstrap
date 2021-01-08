<template>
    <div class="row justify-content-center pt-4">
        <div class="col-6">
            <div>
                <jet-authentication-card-logo />
            </div>

            <div class="card shadow-sm">
                <div v-html="policy" class="card-body">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'

export default {
    props: ['policy'],

    components: {
        JetAuthenticationCardLogo,
    },
}
</script>
