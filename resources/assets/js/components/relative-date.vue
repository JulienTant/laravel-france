<template>
    <span>{{ result }}</span>
</template>

<script lang="es6" type="text/ecmascript-6">
import moment from 'moment'
require('moment/locale/fr');
moment.locale('fr');

export default {
    props: {
        date: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            result: ''
        }
    },
    ready() {
        this.result = moment(this.date).fromNow();
        setTimeout(() => this.result = moment(this.date).fromNow() , 10000)
    }
}
</script>