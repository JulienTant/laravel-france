<template>
    <button v-if="ready" class="Button Button--Small Button--ToggleWatchTopic" @click="toggleWatch(topicId, $event)" :disabled="isDisabled">
        <span v-show="watched"><i class="fa fa-eye-slash"></i> Ne plus surveiller</span>
        <span v-show="!watched"><i class="fa fa-eye"></i> Surveiller</span>
    </button>
</template>

<script  type="text/ecmascript-6">
    import Laroute from '../laroute'

    export default {
        methods: {
            toggleWatch(topicId, event) {
                event.preventDefault();

                this.$http.post(Laroute.route('api.forums.toggle-watch', {topicId: topicId}))
                    .success((responseObject) => {
                        this.watched = responseObject.watched;
                    });
            }
        },
        props: {
            topicId: {
                type: String,
                validator: (value) => parseInt(value, 10) > 0
            },
        },
        data() {
            return {
                watched: null,
                ready: false
            }
        },
        ready() {
            this.$http.get(Laroute.route('api.forums.watch', {topicId: this.topicId}))
                .success((responseObject) => {
                    this.ready = true;
                    this.watched = responseObject.watched;
            });
        }
    }
</script>