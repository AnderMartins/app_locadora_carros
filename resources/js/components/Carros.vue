<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            <!-- Inicio card de buscas-->
            <card-component titulo="Busca de Carros">
                <template v-slot:conteudo>
                    <div class="form-row">
                        <div class="col mb-3">

                        <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca">
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                        </input-container-component>
                
                        </div>
                        <div class="col mb-3">

                        <input-container-component titulo="Placa" id="inputPlaca" id-help="placaHelp" texto-ajuda="Opcional. Informe a placa do Carro">
                        <input type="text" class="form-control" id="inputId" aria-describedby="placaHelp" placeholder="Placa" v-model="busca.placa">
                        </input-container-component>

                        </div>
                    </div> 
                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>

            </card-component>
            <!-- Final card de buscas-->


            <!-- Inicio card de listagens de carros-->
            <card-component titulo="Relação de Carros">
                <template v-slot:conteudo>
                    <table-component 
                        :dados="carros.data"
                        :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCarroVisualizar' }"
                        :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCarroAtualizar' }"
                        :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCarroRemover' }"
                        :titulos="{
                            id: {titulo: 'ID', tipo: 'texto', visivel: true},
                            modelo_id: {titulo: 'ID do Modelo', tipo: 'texto', visivel: false},
                            placa: {titulo: 'Placa', tipo: 'texto', visivel: true},
                            disponivel: {titulo: 'Disponivel', tipo: 'boolean', visivel: true},
                            km: {titulo: 'Quilometragem', tipo: 'texto', visivel: true},
                            created_at: {titulo: 'Data de criação', tipo: 'data', visivel: false}}">
                    </table-component>
                </template>

                <template v-slot:rodape>
                    <div class="row">
                        <div class="col-10">
                            <paginate-component>                       
                                <li v-for="l, key in carros.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                    <a class="page-link" v-html="l.label"></a>
                                </li>
                            </paginate-component>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCarro">Adicionar</button>
                        </div>
                    </div>
                </template>
            </card-component>
            <!-- Final card de listagens de carros-->

            </div>
        </div> 

        <!-- inicio do modal de inclusão de carros-->
        <modal-component id="modalCarro" titulo="Adicionar Carro">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="ID do Modelo" id="novoModeloId" id-help="novoModeloIdHelp" texto-ajuda="Informe o ID do Modelo">
                        <input type="text" class="form-control" id="novoModeloId" aria-describedby="novoModeloIdHelp" placeholder="ID do Modelo" v-model="modeloId">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Placa" id="novoPlaca" id-help="novoPlacaHelp" texto-ajuda="Informe a Placa do Carro">
                        <input type="text" class="form-control" id="novoPlaca" aria-describedby="novoPlacaHelp" placeholder="Placa" v-model="placa">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Disponivel" id="novoDisponivel" id-help="novoDisponivelHelp" texto-ajuda="O carro está disponivel?">
                        <input type="text" class="form-control" id="novoDisponivel" aria-describedby="novoDisponivelHelp" placeholder="Disponivel" v-model="disponivel">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Quilometragem" id="novoKm" id-help="novoKmHelp" texto-ajuda="Informe a Quilometragem do Carro">
                        <input type="text" class="form-control" id="novoKm" aria-describedby="novoKmHelp" placeholder="Quilometragem" v-model="km">
                    </input-container-component>
                </div>

            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de inclusão de marca-->

        <!-- inicio do modal de visualização de carro-->
        <modal-component id="modalCarroVisualizar" titulo="Visualizar Carro">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="ID do Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo_id" disabled>
                </input-container-component>

                <input-container-component titulo="Placa">
                    <input type="text" class="form-control" :value="$store.state.item.placa" disabled>
                </input-container-component>

                <input-container-component titulo="Disponivel">
                    <input type="text" class="form-control" :value="$store.state.item.disponivel | booleano" disabled>
                </input-container-component>

                <input-container-component titulo="Quilometragem">
                    <input type="text" class="form-control" :value="$store.state.item.km" disabled>
                </input-container-component>

                <input-container-component titulo="Data de Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
                </input-container-component>

            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>
        <!-- fim do modal de visualização de carro-->

        <!-- inicio do modal de remoção de carro-->
        <modal-component id="modalCarroRemover" titulo="Remover Carro">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="ID do Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo_id" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- fim do modal de remoção de carro-->

        <!-- inicio do modal de atualização de carro-->
        <modal-component id="modalCarroAtualizar" titulo="Atualizar Carro">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="ID do Modelo" id="AtualizarModeloId" id-help="AtualizarModeloIdHelp" texto-ajuda="Informe o ID do Modelo">
                        <input type="text" class="form-control" id="AtualizarModeloId" aria-describedby="AtualizarModeloIdHelp" placeholder="ID do Modelo" v-model="$store.state.item.modelo_id">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Placa" id="atualizarPlaca" id-help="atualizarPlacaHelp" texto-ajuda="Informe a Placa do Carro">
                        <input type="text" class="form-control" id="atualizarPlaca" aria-describedby="atualizarPlacaHelp" placeholder="Placa" v-model="$store.state.item.placa">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Disponivel" id="atualizarDisponivel" id-help="atualizarDisponivelHelp" texto-ajuda="O Carro está Disponivel?">
                        <input type="text" class="form-control" id="atualizarDisponivel" aria-describedby="atualizarDisponivelHelp" placeholder="Disponivel" v-model="$store.state.item.disponivel">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Quilometragem" id="atualizarKm" id-help="atualizarKmHelp" texto-ajuda="Informe a Quilometragem do Carro">
                        <input type="text" class="form-control" id="atualizarKm" aria-describedby="atualizarKmHelp" placeholder="Quilometragem" v-model="$store.state.item.km">
                    </input-container-component>
                </div>

            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de atualização de carro-->

    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/carro',
                urlPaginacao: '',
                urlFiltro: '',
                modeloId: '',
                placa: '',
                disponivel: '',
                km: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                carros: { data: [] },
                busca: { id: '', nome: ''}
            }
        },
        methods: {
            atualizar() {
                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('modelo_id', this.$store.state.item.modelo_id)
                formData.append('placa', this.$store.state.item.placa)
                formData.append('disponivel', this.$store.state.item.disponivel)
                formData.append('km', this.$store.state.item.km)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de carro atualizado com sucesso!'

                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

                if(!confirmacao) {
                    return false
                }
                
                let formData = new FormData()
                formData.append('_method', 'delete')

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                    })
            },
            pesquisar() {
                let filtro = ''

                for(let chave in this.busca) {

                    if(this.busca[chave]) {
                        if(filtro != '') {
                            filtro += ";"
                        }

                        filtro += chave + ':like:' + this.busca[chave]
                    }   
                }
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }
                this.carregarLista()
            },
            paginacao(l) {
                if(l.url) {
                    //this.urlBase = l.url
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista()
                }
            },
            carregarLista() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                console.log(url)

                axios.get(url)
                .then(response => {
                    this.carros = response.data

                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            salvar() {
                let formData = new FormData();
                formData.append('modelo_id', this.modeloId)
                formData.append('placa', this.placa)
                formData.append('disponivel', this.disponivel)
                formData.append('km', this.km)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                    this.carregarLista()
                    this.resetarCampos()

                    console.log(response)
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
            },
            resetarCampos() {
                this.modeloId = ''
                this.placa = ''
                this.disponivel = ''
                this.km = ''
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>