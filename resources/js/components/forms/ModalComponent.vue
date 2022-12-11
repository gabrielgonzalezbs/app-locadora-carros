<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" :id="modalId" tabindex="-1" :aria-labelledby="`${modalId}Label`" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" :id="`${modalId}Label`">
                            {{modalTitle}}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <slot name="modal-body">

                        </slot>

                    </div>
                    <div class="modal-footer">
                        <slot name="modal-footer">

                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'modalId',
        'buttonText',
        'modalTitle'
    ]
}
</script>

<style>

</style>
