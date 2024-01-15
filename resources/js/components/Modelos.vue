<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            <!-- Inicio card de buscas-->
            <card-component titulo="Busca de Modelos">
                <template v-slot:conteudo>
                    <div class="form-row">
                        <div class="col mb-3">

                        <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do Modelo">
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                        </input-container-component>
                
                        </div>
                        <div class="col mb-3">

                        <input-container-component titulo="Nome do Modelo" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome do Modelo">
                        <input type="text" class="form-control" id="inputId" aria-describedby="nomeHelp" placeholder="Nome do Modelo" v-model="busca.nome">
                        </input-container-component>

                        </div>
                    </div> 
                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>

            </card-component>
            <!-- Final card de buscas-->


            <!-- Inicio card de listagens de modelos-->
            <card-component titulo="Relação de Modelos">
                <template v-slot:conteudo>
                    <table-component 
                        :dados="modelos.data"
                        :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloVisualizar' }"
                        :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloAtualizar' }"
                        :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloRemover' }"
                        :titulos="{
                            id: {titulo: 'ID', tipo: 'texto', visivel: true},
                            marca_id: {titulo: 'Marca ID', tipo: 'texto', visivel: false},
                            nome: {titulo: 'Nome', tipo: 'texto', visivel: true},
                            imagem: {titulo: 'Imagem', tipo: 'imagem', visivel: true},
                            numero_portas: {titulo: 'Nome', tipo: 'texto', visivel: false},
                            lugares: {titulo: 'Lugares', tipo: 'texto', visivel: false},
                            air_bag: {titulo: 'Air Bag', tipo: 'texto', visivel: false},
                            abs: {titulo: 'ABS', tipo: 'texto', visivel: false},
                            created_at: {titulo: 'Data de criação', tipo: 'data', visivel: true}}">
                    </table-component>
                </template>

                <template v-slot:rodape>
                    <div class="row">
                        <div class="col-10">
                            <paginate-component>                       
                                <li v-for="l, key in modelos.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
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
            <!-- Final card de listagens de modelos-->

            </div>
        </div> 

        <!-- inicio do modal de inclusão de modelo-->
        <modal-component id="modalModelo" titulo="Adicionar Modelo">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Modelo">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do Modelo" v-model="nomeModelo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="ID da Marca" id="novoMarcaId" id-help="novoMarcaIdHelp" texto-ajuda="Informe o ID da marca">
                        <input type="text" class="form-control" id="novoMarcaId" aria-describedby="novoMarcaIdHelp" placeholder="ID da Marca" v-model="marcaId">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Numero de Portas" id="novoPortas" id-help="novoPortasHelp" texto-ajuda="Informe a quantidade de portas">
                        <input type="text" class="form-control" id="novoPortas" aria-describedby="novoPortasHelp" placeholder="Numero de Portas" v-model="numeroPortas">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Lugares" id="novoLugares" id-help="novoLugaresHelp" texto-ajuda="Informe o numero de lugares">
                        <input type="text" class="form-control" id="novoLugares" aria-describedby="novoLugaresHelp" placeholder="Numero de Lugares" v-model="lugares">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Air-Bag" id="novoAirBag" id-help="novoAirBagHelp" texto-ajuda="Possui Air-Bag?">
                        <input type="text" class="form-control" id="novoAirBag" aria-describedby="novoAirBagHelp" placeholder="Air-Bag" v-model="airBag">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="ABS" id="novoAbs" id-help="novoAbsHelp" texto-ajuda="Possui Freio ABS?">
                        <input type="text" class="form-control" id="novoAbs" aria-describedby="novoAbsHelp" placeholder="ABS" v-model="abs">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de inclusão de modelo-->

        <!-- inicio do modal de visualização de modelo-->
        <modal-component id="modalModeloVisualizar" titulo="Visualizar Modelo">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="ID da Marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca_id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome do Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

                <input-container-component titulo="">
                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem">
                </input-container-component>

                <input-container-component titulo="Numero de Portas">
                    <input type="text" class="form-control" :value="$store.state.item.numero_portas" disabled>
                </input-container-component>

                <input-container-component titulo="Lugares">
                    <input type="text" class="form-control" :value="$store.state.item.lugares" disabled>
                </input-container-component>

                <input-container-component titulo="Air-Bag">
                    <input type="text" class="form-control" :value="$store.state.item.air_bag" disabled>
                </input-container-component>

                <input-container-component titulo="ABS">
                    <input type="text" class="form-control" :value="$store.state.item.abs" disabled>
                </input-container-component>

                <input-container-component titulo="Data de Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>
        <!-- fim do modal de visualização de modelo-->

        <!-- inicio do modal de remoção de modelo-->
        <modal-component id="modalModeloRemover" titulo="Remover Modelo">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome do Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- fim do modal de remoção de modelo-->

        <!-- inicio do modal de atualização de modelo-->
        <modal-component id="modalModeloAtualizar" titulo="Atualizar Modelo">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso!" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Modelo" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome do modelo">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da Marca" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Numero de Portas" id="atualizarPortas" id-help="atualizarPortasHelp" texto-ajuda="Informe o Numero de Portas">
                        <input type="text" class="form-control" id="atualizarPortas" aria-describedby="atualizarPortasHelp" placeholder="Numero de Portas" v-model="$store.state.item.numero_portas">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Numero de Lugares" id="atualizarLugares" id-help="atualizarLugaresHelp" texto-ajuda="Informe o Numero de Lugares">
                        <input type="text" class="form-control" id="atualizarLugares" aria-describedby="atualizarLugaresHelp" placeholder="Numero de Lugares" v-model="$store.state.item.lugares">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Air-Bag" id="atualizarAirBag" id-help="atualizarAirBagHelp" texto-ajuda="Possui Air-Bag?">
                        <input type="text" class="form-control" id="atualizarAirBag" aria-describedby="atualizarAirBagHelp" placeholder="Air-Bag" v-model="$store.state.item.air_bag">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="ABS" id="atualizarAbs" id-help="atualizarAbsHelp" texto-ajuda="Possui Freio ABS?">
                        <input type="text" class="form-control" id="atualizarAbs" aria-describedby="atualizarAbsHelp" placeholder="ABS" v-model="$store.state.item.abs">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>

        </modal-component> 
        <!-- fim do modal de atualização de modelo-->

    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/modelo',
                urlPaginacao: '',
                urlFiltro: '',
                nomeModelo: '',
                marcaId: '',
                numeroPortas: '',
                lugares: '',
                airBag: '',
                abs: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                modelos: { data: [] },
                busca: { id: '', nome: ''},
            }
        },
        methods: {
            atualizar() {
                let formData = new FormData()
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)
                formData.append('numero_portas', this.$store.state.item.numero_portas)
                formData.append('lugares', this.$store.state.item.lugares)
                formData.append('air_bag', this.$store.state.item.air_bag)
                formData.append('abs', this.$store.state.item.abs)
                
                if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0])
                }

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de modelo atualizado com sucesso!'
                        //limpar o campo de seleção de arquivos
                        atualizarImagem.value = ''
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
                    this.modelos = response.data
                    //console.log(this.marcas)
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                let formData = new FormData();
                formData.append('nome', this.nomeModelo)
                formData.append('marca_id', this.marcaId)
                formData.append('imagem', this.arquivoImagem[0])
                formData.append('numero_portas', this.numeroPortas)
                formData.append('lugares', this.lugares)
                formData.append('air_bag', this.airBag)
                formData.append('abs', this.abs)

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
                    novoImagem.value = ''
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
                this.nomeModelo = ''
                this.marcaId = ''
                this.numeroPortas = ''
                this.lugares = ''
                this.airBag = ''
                this.abs = ''
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>