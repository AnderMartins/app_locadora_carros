<template>
  <div>
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th scope="col" v-for="t, key in titulosVisiveis" :key="key">{{ t.titulo }}</th>
                  <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
              </tr>             
          </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                  <template v-for="(valor, chaveValor) in obj">
                    <td :key="chaveValor" v-if="titulos[chaveValor].visivel !== false">
                      <span v-if="titulos[chaveValor].tipo === 'texto'">{{ valor }}</span>
                      <span v-if="titulos[chaveValor].tipo === 'boolean'">{{ valor | booleano }}</span>
                      <span v-if="titulos[chaveValor].tipo === 'data'">{{ valor | formataDataTempoGlobal }}</span>
                      <span v-if="titulos[chaveValor].tipo === 'dataAlt'">{{ valor | formatarData }}</span>
                      <span v-if="titulos[chaveValor].tipo === 'imagem'">
                        <img :src="'/storage/' + valor" width="40" height="40">
                      </span>
                    </td>
                  </template>
                  <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                    <div class="btn-group">
                      <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                      <button v-if="atualizar.visivel" class="btn btn-outline-success btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(obj)">Atualizar</button>
                      <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">Remover</button>
                    </div>
                  </td>
                </tr>
            </tbody>
      </table>
  </div>
</template>

<script>
  export default {
      props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover'],
      methods: {
          setStore(obj) {
            this.$store.state.transacao.status = ''
            this.$store.state.transacao.mensagem = ''
            this.$store.state.transacao.dados = ''
            this.$store.state.item = obj
          }
      },
      computed: {
        titulosVisiveis() {
          return Object.keys(this.titulos)
          .filter((key) => this.titulos[key].visivel !== false)
          .reduce((obj, key) => {
            obj[key] = this.titulos[key];
            return obj;
          }, {});
      },
      dadosFiltrados() {
          let campos = Object.keys(this.titulos)
          let dadosFiltrados = []

          this.dados.map((item, chave) => {

            let itemFiltrado = {}

            campos.forEach(campo => {
              itemFiltrado[campo] = item[campo] //utilizar a sintaxe de array para atribuir valores a objetos
            })

            dadosFiltrados.push(itemFiltrado)
          })

          return dadosFiltrados
      }
    }
  }
</script>