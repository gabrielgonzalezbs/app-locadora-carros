<template>
    <div>

        <!-- FILTRO DAS MARCAS -->
        <div class="row">

            <div class="col-md-2">
                <p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Filtrar">
                        <i class="bi bi-funnel"></i>
                    </button>
                </p>
            </div>

            <div class="col-md-8">

            </div>

            <div class="col-md-2 align-all-end">

                <!-- MODAL DE CRIAÇÃO DE MARCAS  -->
                <modal-component
                    modal-id='modalCreate'
                    button-text='Adicionar'
                    modal-title='Adicionar nova Marca'
                >
                    <template v-slot:modal-body>

                        <div class="row">
                            <div class="col-md-12">
                                <input-component id-input='createName'
                                    textLabel='Nome'
                                    type-input='text'
                                    text-help='Informe o nome da Marca'
                                    v-model="createName" >
                                </input-component>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="createImage" class="form-label">Logo da Marca</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="createImage"
                                        @change="loadFile($event)" >

                                    <div class="form-text">Adicione o Logo da marca aqui</div>
                                </div>
                            </div>
                        </div>

                    </template>

                    <template v-slot:modal-footer>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="createAutomaker">Salvar</button>
                    </template>
                </modal-component>

            </div>

            <!-- DIV COM O FORM DE FILTRAGEM -->
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
import ModalComponent from '../forms/ModalComponent.vue';
import TableComponent from '../forms/TableComponent.vue';
export default {
  components: { TableComponent, ModalComponent },
    data() {
        return {
            filterId: null,
            filterName: null,
            createName: null,
            createImage: [],
        }
    },

    computed: {
        token() {
            const { cookie } = document

            const token = /token=(?<meuGrupo>.*?);/gm.exec(cookie)

            return token[1];
        }
    },

    methods: {
        loadFile(e) {
            this.createImage = e.target?.files
        },

        searchAutomakers() {
            console.log(this.filterId);
            console.log(this.filterName);
        },

        createAutomaker() {
            let formData = new FormData();
            formData.append('name', this.createName);
            formData.append('image', this.createImage[0]);

            const options = {
                headers: {
                    'Content-Type': 'multipart/form-data;',
                    Accept: 'application/json',
                    Authorization: `Bearer ${this.token}`
                },
            };

            axios.post('http://127.0.0.1:8000/api/v1/automakers', formData, options)
                .then(response => {
                    console.log(response.data);
                }).catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>

<style scoped>
    .align-all-end {
        display: flex;
        justify-content: flex-end;
    }
</style>
