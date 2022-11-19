<template>
    <div>

        <!-- FILTRO DAS MARCAS -->
        <div class="row">

            <p>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Filtrar">
                    <i class="bi bi-funnel"></i>
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input-component id-input='filterId'
                                textLabel='ID'
                                type-input='text'
                                text-help='(Opcional) Você pode filtrar pelo ID das Marcas'
                                v-model="filterId" >
                            </input-component>
                        </div>
                        <div class="col mb-3">
                            <input-component id-input='filterName'
                                textLabel='Nome da marca'
                                type-input='text'
                                text-help='(Opcional) Você pode filtrar pelo Nome das Marcas'
                                v-model="filterName" >
                            </input-component>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" @click="searchAutomakers">Pesquisar <i class="bi bi-funnel"></i></button>
                </div>
            </div>

        </div>

        <hr>

        <!-- TABLE DE LISTAGEM -->
        <div class="row">
            <table-component
                table-title="Lista de Marcas"
            >
            </table-component>
        </div>

    </div>
</template>

<script>
import TableComponent from '../forms/TableComponent.vue';
export default {
  components: { TableComponent },
    data() {
        return {
            filterId: null,
            filterName: null,
        }
    },

    methods: {
        searchAutomakers() {
            console.log(this.filterId);
            console.log(this.filterName);
        },
    }
}
</script>
