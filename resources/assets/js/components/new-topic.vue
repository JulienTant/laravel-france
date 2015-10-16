<template>
    <button class="Button Button_NewTopic" id="show-modal" @click="showModal = true"><slot></slot></button>

    <modal :show.sync="showModal">
        <h3 slot="header">Créer un sujet</h3>
        <div slot="body">
            Formulaire ici
        </div>
    </modal>
</template>

<script lang="es6" type="text/ecmascript-6">
    import Modal from './modal.vue'

    export default {
        components: {
           Modal
        },
        data() {
            return {
                showModal: false
            }
        },
        ready () {
        }
    }
</script>