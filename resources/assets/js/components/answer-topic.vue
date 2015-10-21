<template>
    <div>
        <h3>Répondre au sujet</h3>

        <form class="Form Form--AnswerTopic" @submit="submitForm(answer, $event)" >

            <ul class="Form__ErrorList" v-if="errors.length > 0">
                <li class="Form__ErrorList__Item" v-for="error in errors">{{ error }}</li>
            </ul>


            <div class="Form__Row">
                <label for="answer-topic-markdown" class="Form__Row__Label">Message</label>
                <textarea type="text" id="answer-topic-markdown" name="answer-topic[markdown]" class="Form__Row__Control" v-model="answer.markdown"></textarea>
            </div>

            <div class="Form__Row Form__Row--Buttons" style="float: right">
                <button type="reset" class="Button Button--Cancel" @click="reset">
                    Annuler
                </button>

                <button type="submit" class="Button Button--Submit" @click="submitForm(answer, $event)" :disabled="isDisabled">Répondre</button>
            </div>

            <p style="float: left">
                <small>Le message doit être rédigé au format <a href="https://help.github.com/articles/markdown-basics/">Markdown</a></small>
            </p>
        </form>
    </div>
</template>

<script lang="es6" type="text/ecmascript-6">
    import Laroute from '../laroute'

    export default {
        methods: {
            submitForm(answer, event) {
                event.preventDefault();
                this.isDisabled = true;

                var that = this;
                this.$http.post(Laroute.route('api.forums.reply', {topicId: this.topic}), answer)
                        .success((message, status, request) => {
                            document.location.href = Laroute.route('forums.show-message', {messageId: message.id});
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
            reset() {
                this.answer.markdown = "";
                this.errors = [];
            }
        },
        props: {
            topic: {
                required: true,
                twoWay: false
            }
        },
        data() {
            return {
                isDisabled: false,
                errors: [],
                answer: {
                    markdown: '',
                }
            }
        }
    }

</script>