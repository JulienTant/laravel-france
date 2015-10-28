<script type="text/ecmascript-6">
import swal from 'sweetalert'

export default {
    props: {
        config: {
          twoWay: false,
            validator (value) {
                return typeof JSON.parse(value) == 'object'
            }
        }
    },
    ready() {
        var config = JSON.parse(this.config);
        swal(config)
    }
}
</script>