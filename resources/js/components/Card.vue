<template>
    <div class="card mb-3">
        <div class="card-header">{{ titulo }}</div>
        <div class="card-body">
            <slot name="conteudo"></slot>
        </div>
        <div class="card-footer">
            <slot name="rodape"></slot>
        </div>
    </div>
</template>

<script>
import InputContainer from "./InputContainer.vue";

export default {
    props: [
        'titulo'
    ]
}
</script>
