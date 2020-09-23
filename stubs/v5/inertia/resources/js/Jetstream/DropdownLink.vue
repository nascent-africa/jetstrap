<template>
    <div>
        <button type="submit" @click="$emit('clicked')" class="dropdown-item px-4" v-if="as == 'button'">
            <slot></slot>
        </button>

        <inertia-link :href="href" class="dropdown-item px-4" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['href', 'as']
    }
</script>
