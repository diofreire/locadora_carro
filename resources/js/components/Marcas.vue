<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Inicío do card de busca -->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <inputContainer-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </inputContainer-component>
                            </div>
                            <div class="col mb-3">
                                <inputContainer-component titulo="Nome da Marca" id="nomeHelp" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca" v-model="busca.nome">
                                </inputContainer-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pequisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->
                <!-- Início do card de listagem de marcas -->
                <card-component titulo="Relação de marcas">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="marcas.data"
                            :visualizar=" { visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar' }"
                            :atualizar="true"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover' }"
                            :titulos="{
                                id: { titulo: 'ID', tipo: 'texto' },
                                nome: { titulo: 'Nome', tipo: 'texto' },
                                imagem: { titulo: 'Imagem', tipo: 'imagem' },
                                created_at: { titulo: 'Data criação', tipo: 'data' },
                            }"
                        >

                        </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links"
                                        :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)">
                                        <a class="page-link" href="#" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>

                <!-- Fim do card de listagem de marcas -->
            </div>
        </div>

        <!-- Início do Modal de criação de Marca -->
        <modal-component id="modalMarca" titulo="Adicionar Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="returnMessage" titulo="Cadastro realizado com Sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="returnMessage" titulo="Erro ao tentar cadastrar marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="col mb-3">
                        <inputContainer-component titulo="Nome da Marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da Marca">
                            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da Marca" v-model="nomeMarca">
                        </inputContainer-component>
                    </div>

                    <div class="col mb-3">
                        <inputContainer-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                        </inputContainer-component>
                    </div>
                </div>
            </template>
            <template v-slot:bottons>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>

        <!-- Início do Modal de Visualizaçao de Marca -->
        <modal-component id="modalMarcaVisualizar" titulo="Visualizar Marca">
            <template v-slot:alertas>
            </template>
            <template v-slot:conteudo>
                <inputContainer-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </inputContainer-component>
                <inputContainer-component titulo="Nome da Marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </inputContainer-component>
                <inputContainer-component titulo="Imagem">
                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem">
                </inputContainer-component>
                <inputContainer-component titulo="Data Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </inputContainer-component>
            </template>
            <template v-slot:bottons>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>

        <!-- Início do Modal de Remoção de Marca -->
        <modal-component id="modalMarcaRemover" titulo="Remover Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <inputContainer-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </inputContainer-component>
                <inputContainer-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </inputContainer-component>
            </template>
            <template v-slot:bottons>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>


    </div>

</template>

<script>
    export default {
        computed: {
            token() {
                let token = document.cookie.split('; ')
                    .find(row => row.startsWith('token='))
                    .split('=')[1]

                return 'bearer ' + token;
            }
        },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/marca',
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                returnMessage: {},
                marcas: { data: [] },
                busca: {
                    nome: '',
                    id: ''
                }
            }
        },
        methods: {
            carregarLista() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.get(url, config)
                    .then(response => {
                        this.marcas = response.data
                        //console.log(this.marcas)
                    })
                    .catch(erros => {
                        console.log(erros)
                    })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                //console.log(this.nomeMarca, this.arquivoImagem)

                let formData = new FormData();
                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagem[0]);

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                // client http
                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.returnMessage = {
                            mensagem: 'ID do Registro' + response.data.id
                        }
                        //console.log(response)
                        this.carregarLista()
                    })
                    .catch(erros => {
                        this.transacaoStatus = 'erro'
                        this.returnMessage = {
                            mensagem: erros.response.data.message,
                            erros: erros.response.data.errors
                        }
                        //console.log(erros.response.data)
                    })
            },
            paginacao(l) {
                if(l.url) {
                    //this.urlBase = l.url //ajustando a url de consulta com parametro de página
                    this.urlPaginacao = l.url.split('?')[1];
                    this.carregarLista() //atualizando
                }
            },
            pequisar() {
                let filtro = ''
                for(let chave in this.busca) {
                    if(this.busca[chave]) {
                        //console.log(chave, this.busca[chave])
                        if(filtro != '') {
                            filtro += ";"
                        }
                        filtro += chave + ':like:' + this.busca[chave]
                    }
                }

                //console.log(filtro)
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            },
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')
                if(!confirmacao) {
                    return false;
                }

                // URL com ID
                let url = this.urlBase + '/' + this.$store.state.item.id
                // Configurações
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': this.token
                    }
                }

                // FormData com Method
                let formData = new FormData();
                formData.append('_method', 'delete');

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {

                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erros
                    })
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
