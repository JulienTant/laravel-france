import Alert from './components/alert.vue'
import RelativeDate from './components/relative-date.vue'
import HighlightedCode from './components/highlighted-code.vue'
import NewTopic from './components/new-topic.vue'


export default {
    data: {
        showModal: false
    },
    components: {
        'alert': Alert,
        'relative-date': RelativeDate,
        'highlighted-code': HighlightedCode,
        'new-topic': NewTopic
    }
}