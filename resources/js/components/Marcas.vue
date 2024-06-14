<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Busca de Marcas</div>

                    <div class="card-body">
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
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </div>
                </div>
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
