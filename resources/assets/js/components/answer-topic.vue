<template>
    <div>
        <h3>Répondre au sujet</h3>

        <form class="Form Form--AnswerTopic" @submit="submitForm(answer, $event)" >

            <ul class="Form__ErrorList" v-if="errors.length > 0">
                <li class="Form__ErrorList__Item" v-for="error in errors">{{ error }}</li>
            </ul>


            <div class="Form__Row">
                <label for="answer-topic-markdown" class="Form__Row__Label">Message</label>
                <textarea type="text" id="answer-topic-markdown" name="answer-topic[markdown]" class="Form__Row__Control" v-simplemde="answer.markdown"></textarea>
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

<script type="text/ecmascript-6">
    import Laroute from '../laroute'
    import SimpleMDE from '../directives/simplemde.vue'

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
        events: {
            'cite-this': function (payload) {

                var user = JSON.parse(payload.username);
                var message = JSON.parse(payload.message);


                var userLine = '> <cite>'+ user +'</cite>' + "\n";

                var arrayOfLines = message.split("\n");
                arrayOfLines.forEach(function (value, k) {
                    arrayOfLines[k] = '> '+ value
                });

                var twoNewLines = "\n\n";

                this.answer.markdown = userLine + arrayOfLines.join("\n") + twoNewLines;

                var myTextarea = document.querySelector('#answer-topic-markdown');
                myTextarea.editor.codemirror.focus();

                if (myTextarea.editor) {
                    setTimeout(function () {
                        myTextarea.editor.codemirror.setCursor(1e8, 0)
                    }, 50);
                }
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
        },
        directives: {
            'simplemde': SimpleMDE
        }
    }

</script>