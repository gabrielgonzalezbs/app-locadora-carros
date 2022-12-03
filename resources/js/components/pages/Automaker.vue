<template>
    <div>

        <message-component v-show="alertComponent.showAlert" :alert-component="alertComponent" @closeAlert="alertComponent.showAlert = false">

        </message-component>

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
                :body-content="listMarcasFiltred"
                :header-content="[ '#', 'Nome', 'Imagem', ]"
            >

                <template v-slot:table-body>
                    <tr v-for="content in listMarcasFiltred" :key="content.id">
                        <th scope="row">{{content.id}}</th>
                        <td>{{content.name}}</td>
                        <td><img :src="`/storage/${content.image}`" :alt="content.name" width="5%" height="5%"></td>
                    </tr>
                </template>

            </table-component>
        </div>

        <div class="row">
            <paginate-component :paginate="listMarcas" @clickPage="paginate">
            </paginate-component>
        </div>

    </div>
</template>

<script>
import { api, apiSetToken } from "../../api";

export default {
    data() {
        return {
            filterId: null,
            filterName: null,
            createName: null,
            createImage: [],
            alertComponent: {
                message: null,
                showAlert: false,
                category: 'default'
            },
            listMarcas: [],
            listMarcasFiltred: [],
        }
    },

    methods: {
        listAllMarcas(link = '/automakers') {

            const options = {
                headers: {
                    Accept: 'application/json',
                },
            };

            api.get(link, options)
                .then(response => {
                    console.log(response.data);

                    this.listMarcas = response.data;
                    this.listMarcasFiltred = this.listMarcas.data
                }).catch(error => {
                    console.error(error);
                    this.alertComponent.message = `O servidor retornou o seguinte erro: ${error.message}` ;
                    this.alertComponent.category = 'danger';
                    this.alertComponent.showAlert = true;
                });

        },

        loadFile(e) {
            this.createImage = e.target?.files
        },

        searchAutomakers() {

            if (this.filterId || this.filterName) {
                console.log('filterId', this.filterId);
                console.log('filterName', this.filterName);
                return this.listMarcasFiltred = this.listMarcas.data.filter(marca => marca.name == this.filterName || marca.id == this.filterId )

            }

            this.listMarcasFiltred = this.listMarcas.data
        },

        createAutomaker() {
            let formData = new FormData();
            formData.append('name', this.createName);
            formData.append('image', this.createImage[0]);

            const options = {
                headers: {
                    'Content-Type': 'multipart/form-data;',
                    Accept: 'application/json',
                },
            };

            api.post('/automakers', formData, options)
                .then(response => {
                    console.log(response.data);

                    this.alertComponent.message = 'Marca salva com sucesso';
                    this.alertComponent.category = 'primary';
                    this.alertComponent.showAlert = true;
                }).catch(error => {
                    console.error(error);
                    this.alertComponent.message = `O servidor retornou o seguinte erro: ${error.message}` ;
                    this.alertComponent.category = 'danger';
                    this.alertComponent.showAlert = true;
                });
        },

        paginate(page) {
            this.listAllMarcas(page.url)
        }

    },

    // computed: {
    //     listMarcasFiltred() {
    //         if (this.filterId != '' || this.filterName != '') {

    //             return this.listMarcasFiltred = this.listMarcas.filter(marca => marca.name == this.filterName || marca.id == this.filterId )
    //         }

    //         return this.listMarcas
    //     }
    // },

    mounted() {
        this.listAllMarcas();
    }
}
</script>

<style scoped>
    .align-all-end {
        display: flex;
        justify-content: flex-end;
    }
</style>
