<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            <!-- Inicio card de buscas-->
            <card-component titulo="Busca de Locações">
                <template v-slot:conteudo>
                    <div class="form-group">
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da Locação">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="ID do Cliente" id="inputIdCliente" id-help="idClienteHelp" texto-ajuda="Opcional. Informe o ID do Cliente">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idClienteHelp" placeholder="ID do Cliente" v-model="busca.cliente_id">
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="ID do Carro" id="inputIdCarro" id-help="idCarroHelp" texto-ajuda="Opcional. Informe o ID do Carro">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idCarroHelp" placeholder="ID do Carro" v-model="busca.carro_id">
                                </input-container-component>
                            </div>
                        </div>
                    </div> 
                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>

            </card-component>
            <!-- Final card de buscas-->


            <!-- Inicio card de listagens de locacoes-->
            <card-component titulo="Relação de Locações">
                <template v-slot:conteudo>
                    <table-component 
                        :dados="locacoes.data"
                        :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalLocacoesVisualizar' }"
                        :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalLocacoesAtualizar' }"
                        :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalLocacoesRemover' }"
                        :titulos="{
                            id: {titulo: 'ID', tipo: 'texto', visivel: true},
                            cliente_id: {titulo: 'ID do Cliente', tipo: 'texto', visivel: true},
                            carro_id: {titulo: 'ID do Carro', tipo: 'texto', visivel: true},
                            data_inicio_periodo: {titulo: 'Data de Início', tipo: 'dataAlt', visivel: true},
                            data_final_previsto_periodo: {titulo: 'Data Final Prevista', tipo: 'dataAlt', visivel: true},
                            data_final_realizado_periodo: {titulo: 'Data Final Realizada', tipo: 'dataAlt', visivel: false},
                            valor_diaria: {titulo: 'Valor da Diária', tipo: 'texto', visivel: false},
                            km_inicial: {titulo: 'Quilometragem Inicial', tipo: 'texto', visivel: false},
                            km_final: {titulo: 'Quilometragem Final', tipo: 'texto', visivel: false},
                            created_at: {titulo: 'Data de criação', tipo: 'data', visivel: false}}">
                    </table-component>
                </template>

                <template v-slot:rodape>
                    <div class="row">
                        <div class="col-10">
                            <paginate-component>                       
                                <li v-for="l, key in locacoes.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                    <a class="page-link" v-html="l.label"></a>
                                </li>
                            </paginate-component>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalModelo">Adicionar</button>
                        </div>
                    </div>
                </template>
            </card-component>
            <!-- Final card de listagens de locacoes-->

            </div>
        </div> 

        <!-- inicio do modal de inclusão de locacao-->
        <modal-component id="modalModelo" titulo="Adicionar Locação">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="ID do Cliente" id="novoIdCliente" id-help="novoIdClienteHelp" texto-ajuda="Informe o ID do Cliente">
                        <input type="text" class="form-control" id="novoIdCliente" aria-describedby="novoIdClienteHelp" placeholder="ID do Cliente" v-model="clienteId">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="ID do Carro" id="novoCarroId" id-help="novoCarroIdHelp" texto-ajuda="Informe o ID do Carro">
                        <input type="text" class="form-control" id="novoCarroId" aria-describedby="novoCarroIdHelp" placeholder="ID do Carro" v-model="carroId">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data de Início" id="dataInicio" id-help="dataInicioHelp" texto-ajuda="Informe a data de início da locação">
                        <input type="text" class="form-control" id="dataInicio" aria-describedby="dataInicioHelp" placeholder="Data de Início" v-model="dataInicioPeriodo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Final Prevista" id="dataFinalPrevista" id-help="dataFinalPrevistaHelp" texto-ajuda="Informe a data final prevista da locação">
                        <input type="text" class="form-control" id="dataFinalPrevista" aria-describedby="dataFinalPrevistaHelp" placeholder="Data Final Prevista" v-model="dataFinalPrevistoPeriodo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Final Realizada" id="dataFinalRealizada" id-help="dataFinalRealizadaHelp" texto-ajuda="Informe a data final realizada da locação">
                        <input type="text" class="form-control" id="dataFinalRealizada" aria-describedby="dataFinalRealizadaHelp" placeholder="Data Final Realizada" v-model="dataFinalRealizadoPeriodo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Valor da Diária" id="valorDiaria" id-help="valorDiariaHelp" texto-ajuda="Informe o valor da diária">
                        <input type="text" class="form-control" id="valorDiaria" aria-describedby="valorDiariaHelp" placeholder="Valor da Diária" v-model="valorDiaria">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Quilometragem Inicial" id="kmInicial" id-help="kmInicialHelp" texto-ajuda="Informe a Quilometragem Inicial">
                        <input type="text" class="form-control" id="kmInicial" aria-describedby="kmInicialHelp" placeholder="Quilometragem Inicial" v-model="kmInicial">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Quilometragem Final" id="kmFinal" id-help="kmFinalHelp" texto-ajuda="Informe a Quilometragem Final">
                        <input type="text" class="form-control" id="kmFinal" aria-describedby="kmFinalHelp" placeholder="Quilometragem Final" v-model="kmFinal">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de inclusão de locacao-->

        <!-- inicio do modal de visualização de locacao-->
        <modal-component id="modalLocacoesVisualizar" titulo="Visualizar Locação">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="ID do Cliente">
                    <input type="text" class="form-control" :value="$store.state.item.cliente_id" disabled>
                </input-container-component>

                <input-container-component titulo="ID do Carro">
                    <input type="text" class="form-control" :value="$store.state.item.carro_id" disabled>
                </input-container-component>

                <input-container-component titulo="Data de Início">
                    <input type="text" class="form-control" :value="$store.state.item.data_inicio_periodo | formatarData" disabled>
                </input-container-component>

                <input-container-component titulo="Data Final Prevista">
                    <input type="text" class="form-control" :value="$store.state.item.data_final_previsto_periodo | formatarData" disabled>
                </input-container-component>

                <input-container-component titulo="Data Final Realizada">
                    <input type="text" class="form-control" :value="$store.state.item.data_final_realizado_periodo | formatarData" disabled>
                </input-container-component>

                <input-container-component titulo="Valor da Diária">
                    <input type="text" class="form-control" :value="$store.state.item.valor_diaria" disabled>
                </input-container-component>

                <input-container-component titulo="Quilometragem Inicial">
                    <input type="text" class="form-control" :value="$store.state.item.km_inicial" disabled>
                </input-container-component>

                <input-container-component titulo="Quilometragem Final">
                    <input type="text" class="form-control" :value="$store.state.item.km_final" disabled>
                </input-container-component>

                <input-container-component titulo="Data de Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>
        <!-- fim do modal de visualização de locacao-->

        <!-- inicio do modal de remoção de locacao-->
        <modal-component id="modalLocacoesRemover" titulo="Remover Locação">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="ID do Cliente">
                    <input type="text" class="form-control" :value="$store.state.item.cliente_id" disabled>
                </input-container-component>

                <input-container-component titulo="ID do Carro">
                    <input type="text" class="form-control" :value="$store.state.item.carro_id" disabled>
                </input-container-component>

            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- fim do modal de remoção de locacao-->

        <!-- inicio do modal de atualização de locacao-->
        <modal-component id="modalLocacoesAtualizar" titulo="Atualizar Locação">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="ID do Cliente" id="atualizarIdCliente" id-help="atualizarIdClienteHelp" texto-ajuda="Informe o ID do Cliente">
                        <input type="text" class="form-control" id="atualizarIdCliente" aria-describedby="atualizarIdClienteHelp" placeholder="ID do Cliente" v-model="$store.state.item.cliente_id">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="ID do Carro" id="atualizarIdCarro" id-help="atualizarIdCarroHelp" texto-ajuda="Informe o ID do Carro">
                        <input type="text" class="form-control" id="atualizarIdCarro" aria-describedby="atualizarIdCarroHelp" placeholder="ID do Carro" v-model="$store.state.item.carro_id">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data de Início" id="atualizarDataInicio" id-help="atualizarDataInicioHelp" texto-ajuda="Informe a data de Início da Locação">
                        <input type="text" class="form-control" id="atualizarDataInicio" aria-describedby="atualizarDataInicioHelp" placeholder="Data de Início" v-model="$store.state.item.data_inicio_periodo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Final Prevista" id="atualizarDataFinalPrevista" id-help="atualizarDataFinalPrevistaHelp" texto-ajuda="Informe a data Final Prevista">
                        <input type="text" class="form-control" id="atualizarDataFinalPrevista" aria-describedby="atualizarDataFinalPrevistaHelp" placeholder="Data Final Prevista" v-model="$store.state.item.data_final_previsto_periodo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Data Final Realizada" id="atualizarDataFinalRealizada" id-help="atualizarDataFinalRealizadaHelp" texto-ajuda="Informe a data Final Realizada">
                        <input type="text" class="form-control" id="atualizarDataFinalRealizada" aria-describedby="atualizarDataFinalRealizadaHelp" placeholder="Data Final Realizada" v-model="$store.state.item.data_final_realizado_periodo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Valor da Diária" id="atualizarValorDiaria" id-help="atualizarValorDiariaHelp" texto-ajuda="Informe o valor da diária">
                        <input type="text" class="form-control" id="atualizarValorDiaria" aria-describedby="atualizarValorDiariaHelp" placeholder="Valor da Diária" v-model="$store.state.item.valor_diaria">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Quilometragem Inicial" id="atualizarKmInicial" id-help="atualizarKmInicialHelp" texto-ajuda="Informe a quilometragem inicial">
                        <input type="text" class="form-control" id="atualizarKmInicial" aria-describedby="atualizarKmInicialHelp" placeholder="Quilometragem Inicial" v-model="$store.state.item.km_inicial">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Quilometragem Final" id="atualizarKmFinal" id-help="atualizarKmFinalHelp" texto-ajuda="Informe a quilometragem final">
                        <input type="text" class="form-control" id="atualizarKmFinal" aria-describedby="atualizarKmFinalHelp" placeholder="Quilometragem Final" v-model="$store.state.item.km_final">
                    </input-container-component>
                </div>

            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de atualização de locacao-->

    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/locacao',
                urlPaginacao: '',
                urlFiltro: '',
                clienteId: '',
                carroId: '',
                dataInicioPeriodo: '',
                dataFinalPrevistoPeriodo: '',
                dataFinalRealizadoPeriodo: '',
                valorDiaria: '',
                kmInicial: '',
                kmFinal: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                locacoes: { data: [] },
                busca: { id: '', cliente_id: '', carro_id: ''},
            }
        },
        methods: {
            atualizar() {
                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('data_inicio_periodo', this.$store.state.item.data_inicio_periodo)
                formData.append('data_final_previsto_periodo', this.$store.state.item.data_final_previsto_periodo)
                formData.append('data_final_realizado_periodo', this.$store.state.item.data_final_realizado_periodo)
                formData.append('valor_diaria', this.$store.state.item.valor_diaria)
                formData.append('km_inicial', this.$store.state.item.km_inicial)
                formData.append('km_final', this.$store.state.item.km_final)
                
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de locação atualizado com sucesso!'

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
                    this.locacoes = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            salvar() {
                let formData = new FormData();
                formData.append('cliente_id', this.clienteId)
                formData.append('carro_id', this.carroId)
                formData.append('data_inicio_periodo', this.dataInicioPeriodo)
                formData.append('data_final_previsto_periodo', this.dataFinalPrevistoPeriodo)
                formData.append('data_final_realizado_periodo', this.dataFinalRealizadoPeriodo)
                formData.append('valor_diaria', this.valorDiaria)
                formData.append('km_inicial', this.kmInicial)
                formData.append('km_final', this.kmFinal)

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
                this.clienteId = ''
                this.carroId = ''
                this.dataInicioPeriodo = ''
                this.dataFinalPrevistoPeriodo = ''
                this.dataFinalRealizadoPeriodo = ''
                this.valorDiaria = ''
                this.kmInicial = ''
                this.kmFinal = ''
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>