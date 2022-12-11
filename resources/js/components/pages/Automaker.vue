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

            <div class="col-md-8"> </div>

            <div class="col-md-2 align-all-end">

                <!-- Button trigger modal -->
                <p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAutomaker" @click="createAutomaker()">
                        Adicionar
                    </button>
                </p>

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
                                v-model="filter.id" >
                            </input-component>
                        </div>
                        <div class="col mb-3">
                            <input-component id-input='filterName'
                                textLabel='Nome da marca'
                                type-input='text'
                                text-help='(Opcional) Você pode filtrar pelo Nome das Marcas'
                                v-model="filter.name" >
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
                :header-content="[ '#', 'Nome', 'Imagem', 'Ações']"
            >

                <template v-slot:table-body>
                    <tr v-for="content in listMarcasFiltred" :key="content.id">
                        <th scope="row">{{content.id}}</th>
                        <td>{{content.name}}</td>
                        <td><img :src="`/storage/${content.image}`" :alt="content.name" width="5%" height="5%"></td>
                        <td>
                            <div class="dropdown-center">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ações
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" @click="editAutomaker(content)" data-bs-toggle="modal" data-bs-target="#modalAutomaker">Editar</a></li>
                                    <li><a class="dropdown-item" @click="showAutomaker(content)" data-bs-toggle="modal" data-bs-target="#modalAutomaker">Visualizar</a></li>
                                    <li><a class="dropdown-item" @click.prevent="deleteAutomaker(content)">Excluir</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </template>

            </table-component>
        </div>

        <div class="row">
            <paginate-component :paginate="listMarcas" @clickPage="paginate">
            </paginate-component>
        </div>

        <!-- MODAL DE CRIAÇÃO/EDIÇÃO/VISUALIZAÇÃO DE MARCAS  -->
        <modal-component
            modal-id='modalAutomaker'
            button-text='Adicionar'
            modal-title='Adicionar nova Marca'
        >
            <template v-slot:modal-body>

                <div class="row">
                    <div class="col-md-12" v-if="marca.id != null">
                        <input-component id-input='marcaId'
                            textLabel='Id'
                            type-input='text'
                            text-help='ID da marca'
                            v-model="marca.id"
                            :disabled="true" >
                        </input-component>
                    </div>

                    <div class="col-md-12">
                        <input-component id-input='marcaName'
                            textLabel='Nome'
                            type-input='text'
                            text-help='Informe o nome da Marca'
                            v-model="marca.name"
                            :disabled="marca.state === 'show'" >
                        </input-component>
                    </div>

                    <div class="col-md-12" v-if="marca.image == null">
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

                    <div class="col-md-12" v-else>
                        <p>Logo da Marca</p>
                        <img :src="`/storage/${marca.image}`" :alt="marca.name" width="25%" height="30%">
                    </div>

                    <div class="col-md-12" v-if="marca.created_at != null">
                        <input-component id-input='marcaCreated_at'
                            textLabel='Criado em'
                            type-input='text'
                            v-model="marca.created_at"
                            :disabled="true" >
                        </input-component>
                    </div>
                </div>

            </template>

            <template v-slot:modal-footer v-if="marca.state != 'show'">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" @click="saveAutomaker">Salvar</button>
            </template>
        </modal-component>

    </div>
</template>

<script>
import { api } from "../../api";

export default {
    data() {
        return {
            filter: {
                id: null,
                name: null
            },
            marca: {
                state: 'create',
                id: null,
                name: null,
                image: [],
                created_at: null,
            },
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

            if ( (this.filter.id && this.filter.id != null) || (this.filter.name && this.filter.name != null)) {

                const searchParams = new URLSearchParams({
                    id: this.filter.id ?? '',
                    name: this.filter.name ?? ''
                });
                const queryString = searchParams.toString();

                const link = `/automakers?${queryString}`;

                this.listAllMarcas(link)

                return

            }

            this.listAllMarcas()
        },

        saveAutomaker() {
            let formData = new FormData();
            formData.append('name', this.marca.name);
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

        createAutomaker() {
            this.marca.state = 'create'
            this.marca.id = null
            this.marca.name = null
            this.marca.image = null
            this.marca.created_at = null
        },

        paginate(page) {
            this.listAllMarcas(page.url)
        },

        editAutomaker(automaker) {
            console.log(automaker);
            this.marca.state = 'edit'
            this.marca.id = automaker.id
            this.marca.name = automaker.name
            this.marca.image = automaker.image
            this.marca.created_at = automaker.created_at
        },

        showAutomaker(automaker) {
            console.log(automaker);

            this.marca.state = 'show'
            this.marca.id = automaker.id
            this.marca.name = automaker.name
            this.marca.image = automaker.image
            this.marca.created_at = automaker.created_at
        },

        deleteAutomaker(automaker) {
            console.log(automaker);

            this.marca.state = 'delete'
            this.marca.id = automaker.id
            this.marca.name = automaker.name
            this.marca.image = automaker.image
            this.marca.created_at = automaker.created_at
        },

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
