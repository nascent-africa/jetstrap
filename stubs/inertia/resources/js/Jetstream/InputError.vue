<template>
    <div v-show="message" class="invalid-feedback" role="alert">
        <strong>{{ message }}</strong>
    </div>
</template>

<script>
    export default {
        props: ['message']
    }
</script>
