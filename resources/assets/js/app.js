import Alert from './components/alert.vue'
import RelativeDate from './components/relative-date.vue'
import HighlightedCode from './components/highlighted-code.vue'
import NewTopic from './components/new-topic.vue'
import LoginBox from './components/login-box.vue'


export default {
    data: {
        showLoginBox: false
    },
    components: {
        'alert': Alert,
        'relative-date': RelativeDate,
        'highlighted-code': HighlightedCode,
        'new-topic': NewTopic,
        'login-box': LoginBox
    }
}