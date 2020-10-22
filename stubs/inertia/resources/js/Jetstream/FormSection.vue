<template>
    <div class="row">
        <div class="col-md-4">
            <jet-section-title>
                <template #title><slot name="title"></slot></template>
                <template #description><slot name="description"></slot></template>
            </jet-section-title>
        </div>

        <div class="col-md-8">
            <form @submit.prevent="$emit('submitted')">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <slot name="form"></slot>
                    </div>

                    <div class="card-footer d-flex justify-content-end" v-if="hasActions">
                        <slot name="actions"></slot>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from './SectionTitle'

    export default {
        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>
