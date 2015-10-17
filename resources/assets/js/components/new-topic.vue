<template>
    <button class="Button Button--NewTopic" id="show-modal" @click="showModal = true"><slot /></button>

    <modal :show.sync="showModal" class="Modal--NewTopic">
        <h3 slot="header">Créer un sujet</h3>

        <div slot="body">
            <form class="Form Form--NewTopic" @submit="submitForm(newTopic, $event)">
                <div class="Form__Row">
                    <label class="Form__Row__Label" for="new-topic-title">Titre</label>
                    <input type="text" class="Form__Row__Control" id="new-topic-title" name="new-topic[title]" v-model="newTopic.title"/>
                </div>

                <div class="Form__Row Form__Row--Category">
                    <label class="Form__Row__Label">Catégorie</label>

                    <template v-for="category in categoriesJson" track-by="id">
                        <input id="category-id-{{ category.id }}" type="radio" name="new-topic[category]" v-model="newTopic.category" value="{{ category.id }}" > 
                        <label for="category-id-{{ category.id }}">{{ category.name }}</label>
                    </template>
                </div>

                <div class="Form__Row">
                    <label for="new-topic-markdown" class="Form__Row__Label">Message</label>
                    <textarea type="text" id="new-topic-markdown" name="new-topic[markdown]" class="Form__Row__Control" v-model="newTopic.markdown"></textarea>
                </div>

            </form>
        </div>


        <div slot="footer">
            <button type="reset" class="Button Button--Cancel" @click="closeModal">
                Annuler
            </button>

            <button type="submit" class="Button Button--Submit" @click="submitForm(newTopic, $event)">Créer un sujet</button>

        </div>


    </modal>
</template>

<script lang="es6" type="text/ecmascript-6">
    import Modal from './modal.vue'

    export default {
        components: {
           Modal
        },
        methods: {
            submitForm(newTopic, event) {
                event.preventDefault();

                this.$http.post('test', newTopic)
                        .success((data, status, request) => {
                            console.log(status);
                        })
                        .error((data, status, request) => {
                            console.log(status);
                        });

                console.log(newTopic);
            },
            closeModal() {
                this.showModal = false;
                this.newTopic.title = "";
                this.newTopic.markdown = "";
                this.newTopic.category = -1;
            }
        },
        props: {
            categories: {
                validator (value) {
                    return typeof JSON.parse(value) == 'object'
                }
            }
        },
        data() {
            return {
                showModal: false,
                categoriesJson: [],
                newTopic: {
                    title: '',
                    markdown: '',
                    category: -1
                }
            }
        },
        ready() {
            this.categoriesJson = JSON.parse(this.categories);
        }
    }
</script>