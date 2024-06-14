<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicío do card de busca -->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container>
                            </div>
                            <div class="col mb-3">
                                <input-container titulo="Nome da Marca" id="nomeHelp" id-help="idHelp" texto-ajuda="Opcional. Informe o Nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca">
                                </input-container>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->
                <!-- Início do card de listagem de marcas -->
                <card-component titulo="Relação de marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Adicionar</button>
                    </template>
                </card-component>

                <!-- Fim do card de listagem de marcas -->
            </div>
        </div>
    </div>
</template>

<script>

import {defineComponent} from "vue";
import InputContainer from "./InputContainer.vue";

export default defineComponent({
    components: {InputContainer}
})
</script>
