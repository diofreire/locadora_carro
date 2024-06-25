<template>
    <div :class="estilo" role="alert">
        {{ titulo }}
        <hr>
        <p>{{ detalhes.mensagem }}</p>
        <!-- Detalhes do erro -->
        <ul v-if="detalhes.erros">
            <li v-for="e, key in detalhes.erros" :key="key"> {{ e[0] }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['tipo', 'titulo', 'detalhes'],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        }
    }
}
</script>
