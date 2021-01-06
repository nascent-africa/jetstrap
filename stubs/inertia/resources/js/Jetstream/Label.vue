<template>
    <label :class="classes">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
    export default {
        props: ['value', 'classes']
    }
</script>
