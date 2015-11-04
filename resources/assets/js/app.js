import Alert from './components/alert.vue'
import RelativeDate from './components/relative-date.vue'
import NewTopic from './components/new-topic.vue'
import EditMessage from './components/edit-message.vue'
import LoginBox from './components/login-box.vue'
import AnswerTopic from './components/answer-topic.vue'
import RemoveMessage from './components/remove-message.vue'
import MarkTopicSolved from './components/mark-topic-solved.vue'

import HighlightedCode from './element_directives/highlighted-code.vue'

export default {
    data: {
        showLoginBox: false
    },
    methods: {
        citeMe: function(event) {
            this.$broadcast('cite-this', {username: event.target.dataset.quoteUsername, message: event.target.dataset.quoteMessage});
        }
    },
    elementDirectives: {
        HighlightedCode
    },
    components: {
        Alert,
        RelativeDate,
        NewTopic,
        LoginBox,
        AnswerTopic,
        EditMessage,
        RemoveMessage,
        MarkTopicSolved
    }
}