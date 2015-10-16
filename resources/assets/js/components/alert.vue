<script lang="es6" type="text/ecmascript-6">
import swal from 'sweetalert'

export default {
    props: {
        config: {
            type: String,
            default: () => "{title:''}"
        }
    },
    ready() {
        var config = JSON.parse(this.config);
        swal(config)
    }
}
</script>