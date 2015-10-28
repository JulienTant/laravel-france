<template>
    <button class="Button Button--NewTopic" id="show-modal" @click="showModal = true"><slot /></button>

    <modal :show.sync="showModal" class="Modal--NewTopic">
        <h3 slot="header">Créer un sujet</h3>

        <div slot="body">
            <form class="Form Form--NewTopic" @submit="submitForm(newTopic, $event)" >

                <ul class="Form__ErrorList" v-if="errors.length > 0">
                    <li class="Form__ErrorList__Item" v-for="error in errors">{{ error }}</li>
                </ul>


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
                    <label for="new-topic-markdown" class="Form__Row__Label">Message <small>(Le message doit être rédigé au format <a href="https://help.github.com/articles/markdown-basics/">Markdown</a>)</small></label>
                    <textarea v-if="showModal" v-simplemde="newTopic.markdown" type="text" id="new-topic-markdown" name="new-topic[markdown]" class="Form__Row__Control"></textarea>
                </div>

            </form>
        </div>


        <div slot="footer">
            <button type="reset" class="Button Button--Cancel" @click="closeModal">
                Annuler
            </button>

            <button type="submit" class="Button Button--Submit" @click="submitForm(newTopic, $event)" :disabled="isDisabled">Créer un sujet</button>

        </div>


    </modal>
</template>

<script  type="text/ecmascript-6">
    import Modal from './modal.vue'
    import Laroute from '../laroute'
    import SimpleMDE from '../directives/simplemde.vue'

    export default {
        components: {
           Modal
        },
        directives: {
            'simplemde': SimpleMDE
        },
        methods: {
            submitForm(newTopic, event) {
                event.preventDefault();

                this.isDisabled = true;

                var that = this;
                this.$http.post(Laroute.route('api.forums.post'), newTopic)
                        .success((topic, status, request) => {
                            document.location.href = Laroute.route('forums.show-topic', {categorySlug: topic.forums_category.slug, topicSlug: topic.slug});

                        })
                        .error((data, status, request) => {
                            this.isDisabled = false;
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
                this.newTopic.title = "";
                this.newTopic.markdown = "";
                this.newTopic.category = null;

                this.errors = [];
            }
        },
        props: {
            categories: {
                validator (value) {
                    return typeof JSON.parse(value) == 'object'
                }
            },
            current_category: {
                type: String,
                twoWay: false
            }
        },
        data() {
            return {
                isDisabled: false,
                showModal: false,
                categoriesJson: [],
                errors: [],
                newTopic: {
                    title: '',
                    markdown: '',
                    category: null
                }
            }
        },
        ready() {
            var that = this;

            if (!!this.current_category) {
                this.newTopic.category = this.current_category;
            }
            this.categoriesJson = JSON.parse(this.categories);
        }
    }
</script>