<template>
    <button class="Button Button--Small Button--MarkTopicSolved" @click="markAsSolved(topicId, messageId, $event)" :disabled="isDisabled"><slot /></button>
</template>

<script lang="es6" type="text/ecmascript-6">
    import Laroute from '../laroute'

    export default {
        methods: {
            markAsSolved(topicId, messageId, event) {
                this.isDisabled = true;
                event.preventDefault();

                this.$http.post(Laroute.route('api.forums.message.solved_topic', {topicId: topicId, messageId: messageId}))
                        .success((topic) => {
                            document.location.href = Laroute.route('forums.show-message', {messageId: messageId});
                        });
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
                isDisabled: false
            }
        }
    }
</script>