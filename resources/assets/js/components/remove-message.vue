<template>
    <button class="Button Button--Small Button--RemoveMessage" @click="showModal = true" id="show-modal"><slot /></button>

    <modal :show.sync="showModal" class="Modal---RemoveMessage">
        <h3 slot="header">Supprimer un message</h3>

        <div slot="body">
            <strong>Êtes vous sûr de vouloir supprimer ce message ?</strong>
        </div>

        <div slot="footer">
            <button type="reset" class="Button Button--Cancel" @click="closeModal">
                Non, annuler
            </button>

            <button type="submit" class="Button Button--Submit" @click="deleteMessage(topicId, messageId, $event)">Oui, supprimer le message</button>
        </div>


    </modal>
</template>

<script lang="es6" type="text/ecmascript-6">
    import Modal from './modal.vue'
    import Laroute from '../laroute'

    export default {
        components: {
           Modal
        },
        methods: {
            deleteMessage(topicId, messageId, event) {
                event.preventDefault();

                this.$http.delete(Laroute.route('api.forums.message.delete', {topicId: topicId, messageId: this.messageId}))
                        .success((topic, status, request) => {
                            if (topic) {
                                document.location.href = Laroute.route('forums.show-topic', {categorySlug: topic.forums_category.slug, topicSlug: topic.slug});
                            } else {
                                document.location.href = '/';
                            }
                        })
            },
            closeModal() {
                this.showModal = false;
            }
        },
        props: {
            messageId: {
                type: String,
                validator: (value) => parseInt(value, 10) > 0
            },
            topicId: {
                type: String,
                validator: (value) => parseInt(value, 10) > 0
            },
        },
        data() {
            return {
                showModal: false,
            }
        }
    }
</script>