<template>
    <div>
        <div class="toast-container position-fixed p-3 top-0 start-50 translate-middle-x">
            <div
                :class="`toast fade show text-bg-${alertComponent.category}`"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
            >
                <div class="d-flex">
                    <div class="toast-body">
                        {{ alertComponent.message }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="$emit('closeAlert', false)">

                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'alertComponent'
    ],
}
</script>
