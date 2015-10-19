<template>
    <button class="Button Button--Small Button--EditMessage" id="show-modal" @click="fillModal"><slot /></button>

    <modal :show.sync="showModal" class="Modal---EditMessage">
        <h3 slot="header">Modifier un message</h3>

        <div slot="body">
            <form class="Form Form--EditMessage" @submit="submitForm(editedMessage, $event)" >

                <ul class="Form__ErrorList" v-if="errors.length > 0">
                    <li class="Form__ErrorList__Item" v-for="error in errors">{{ error }}</li>
                </ul>


                <div class="Form__Row">
                    <label for="edit-message-markdown" class="Form__Row__Label">Message</label>
                    <textarea type="text" id="edit-message-markdown" name="edit-message[markdown]" class="Form__Row__Control" v-model="editMessage.markdown"></textarea>
                </div>

            </form>
        </div>


        <div slot="footer">
            <button type="reset" class="Button Button--Cancel" @click="closeModal">
                Annuler
            </button>

            <button type="submit" class="Button Button--Submit" @click="submitForm(editMessage, $event)">Modifier le message</button>
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
            fillModal() {
                var component = this;
                this.$http.get(Laroute.route('api.forums.message', {topicId: this.topicId, messageId: this.messageId}))
                    .success(function (message) {
                        component.editMessage.markdown = message.markdown;
                        component.showModal = true
                    });
            },
            submitForm(editMessage, event) {
                event.preventDefault();

                var that = this;
                this.$http.put(Laroute.route('api.forums.message.update', {topicId: this.topicId, messageId: this.messageId}), editMessage)
                        .success((topic, status, request) => {
                            document.location.href = Laroute.route('forums.show-message', {messageId: that.messageId});
                        })
                        .error((data, status, request) => {

                            that.errors = [];
                            if (status == 422) {
                                for(var element in data) {
                                    var elementWithError = data[element];
                                    for(var idx in elementWithError) {
                                        this.errors.push(elementWithError[idx]);
                                    }
                                }
                            }
                        });


            },
            closeModal() {
                this.showModal = false;
                this.editMessage.markdown = "";
                this.errors = [];
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
                errors: [],
                editMessage: {
                    markdown: ''
                }
            }
        }
    }
</script>