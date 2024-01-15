<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            <!-- Inicio card de buscas-->
            <card-component titulo="Busca de Clientes">
                <template v-slot:conteudo>
                    <div class="form-row">
                        <div class="col mb-3">

                        <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do Nome">
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                        </input-container-component>
                
                        </div>
                        <div class="col mb-3">

                        <input-container-component titulo="Nome do Cliente" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome do Cliente">
                        <input type="text" class="form-control" id="inputId" aria-describedby="nomeHelp" placeholder="Nome do Cliente" v-model="busca.nome">
                        </input-container-component>

                        </div>
                    </div> 
                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>

            </card-component>
            <!-- Final card de buscas-->


            <!-- Inicio card de listagens de clientes-->
            <card-component titulo="Lista de Clientes">
                <template v-slot:conteudo>
                    <table-component 
                        :dados="clientes.data"
                        :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteVisualizar' }"
                        :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteAtualizar' }"
                        :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalClienteRemover' }"
                        :titulos="{
                            id: {titulo: 'ID', tipo: 'texto'},
                            nome: {titulo: 'Nome', tipo: 'texto'},
                            created_at: {titulo: 'Data de criação', tipo: 'data'}}">
                    </table-component>
                </template>

                <template v-slot:rodape>
                    <div class="row">
                        <div class="col-10">
                            <paginate-component>
                                <li v-for="l, key in clientes.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                    <a class="page-link" v-html="l.label"></a>
                                </li>
                            </paginate-component>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCliente">Adicionar</button>
                        </div>
                    </div>
                </template>
            </card-component>
            <!-- Final card de listagens de clientes-->

            </div>
        </div> 

        <!-- inicio do modal de inclusão de cliente-->
        <modal-component id="modalCliente" titulo="Adicionar Cliente">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o Cliente" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Cliente" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Cliente">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do Cliente" v-model="nomeCliente">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de inclusão de cliente-->

        <!-- inicio do modal de visualização de clientes-->
        <modal-component id="modalClienteVisualizar" titulo="Visualizar Cliente">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome do Cliente">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

                <input-container-component titulo="Data de Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>
        <!-- fim do modal de visualização de cliente-->

        <!-- inicio do modal de remoção de cliente-->
        <modal-component id="modalClienteRemover" titulo="Remover Cliente">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome do Cliente">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- fim do modal de remoção de cliente-->

        <!-- inicio do modal de atualização de cliente-->
        <modal-component id="modalClienteAtualizar" titulo="Atualizar Cliente">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Cliente" id="AtualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome do Cliente">
                        <input type="text" class="form-control" id="AtualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome do Cliente" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de atualização de cliente-->

    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/cliente',
                urlPaginacao: '',
                urlFiltro: '',
                nomeCliente: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                clientes: { data: [] },
                busca: { id: '', nome: ''}
            }
        },
        methods: {
            atualizar() {
                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)
                
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de cliente atualizado com sucesso!'
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
                    this.clientes = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            salvar() {
                let formData = new FormData();
                formData.append('nome', this.nomeCliente)

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
                this.nomeCliente = ''
            }
            
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>