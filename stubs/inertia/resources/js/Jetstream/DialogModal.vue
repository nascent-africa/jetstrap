<template>
    <modal :id="id" :max-width="maxWidth">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <slot name="title">
                    </slot>
                </h5>
              <!-- Modal close button is different in bootstrap 5 -->
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <slot name="content">
                </slot>
            </div>
            <div class="modal-footer bg-light">
                <slot name="footer">
                </slot>
            </div>
        </div>
    </modal>
</template>

<script>
    import Modal from './Modal'

    export default {
        components: {
            Modal,
        },

        props: {
            id: {
                type: String,
                required: true
            },
            maxWidth: {
                default: '2xl'
            }
        }
    }
</script>
