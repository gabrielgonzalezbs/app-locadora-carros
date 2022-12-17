<template>
    <div>
        <div class="toast-container position-fixed top-50 start-50 translate-middle-x alert">
            <div
                class="toast fade show"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
            >
                <div class="toast-header header">
                    <strong class="me-auto">
                        {{ alertComponent?.header ?? 'Tem certeza que deseja realizar esta ação?' }}
                    </strong>
                </div>
                <div class="toast-body">
                    {{ alertComponent?.message ?? 'Atenção, ao confirmar esta ação, ela não poderá ser desfeita.' }}

                    <div class="mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-danger btn-sm" @click="$emit('clickConfirm', true)">Confirmar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Cancelar</button>
                    </div>
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

<style scoped>

</style>
