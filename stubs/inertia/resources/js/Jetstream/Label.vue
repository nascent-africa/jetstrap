<template>
    <label :class="classes">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
    export default {
        props: {
            value: String,
            classes: {
                type: String,
                default: 'form-label'
            }
        }
    }
</script>
