<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr >
                    <th v-for="t, key in titulos" :key="key" scope="col">{{ t.titulo }}</th>
                    <th v-if="visualizar || atualizar || remover"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo === 'imagem'">
                            <img :src="'/storage/'+valor" width="30" height="30">
                        </span>
                        <span v-else-if="titulos[chaveValor].tipo === 'texto'">
                           {{ valor }}
                        </span>
                        <span v-else-if="titulos[chaveValor].tipo === 'data'">
                           {{ valor }}
                        </span>
                    </td>
                    <td v-if="visualizar.visivel || atualizar || remover">
                        <button v-if="visualizar.visivel" class="bi bi-info-square btn-outline-primary btn-sm"
                                :data-toggle="visualizar.dataToggle"
                                :data-target="visualizar.dataTarget"
                                @click="setStore(obj)">
                            Visualizar
                        </button>
                        <button v-if="atualizar" class="bi bi-pencil-fill btn-outline-primary btn-sm"> Atualizar</button>
                        <button v-if="remover" class="bi-trash btn-outline-danger btn-sm"> Remover</button>
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
                this.$store.state.item = obj
                //console.log(obj)
            }
        },
        computed: {
            dadosFiltrados() {

                let campos = Object.keys(this.titulos)
                let dadosFiltrados = []

                this.dados.map((item, chave) => {
                    //console.log(chave, item)
                    let itemFiltrado = {}
                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo]

                    })
                    dadosFiltrados.push(itemFiltrado)
                })
                return dadosFiltrados //retornar []
            }
        }
    }
</script>
