import Alert from './components/alert.vue'
import RelativeDate from './components/relative-date.vue'
import HighlightedCode from './components/highlighted-code.vue'
import NewTopic from './components/new-topic.vue'
import EditMessage from './components/edit-message.vue'
import LoginBox from './components/login-box.vue'
import AnswerTopic from './components/answer-topic.vue'
import RemoveMessage from './components/remove-message.vue'
import MarkTopicSolved from './components/mark-topic-solved.vue'


export default {
    data: {
        showLoginBox: false
    },
    methods: {
        citeMe: function(event) {
            this.$broadcast('cite-this', {username: event.target.dataset.quoteUsername, message: event.target.dataset.quoteMessage});
        }
    },
    components: {
        Alert,
        RelativeDate,
        HighlightedCode,
        NewTopic,
        LoginBox,
        AnswerTopic,
        EditMessage,
        RemoveMessage,
        MarkTopicSolved
    }
}