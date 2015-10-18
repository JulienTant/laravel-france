<template>
    <span :title="frenchDate">{{ relativeTime }}</span>
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
            relativeTime: '',
            frenchDate: ''
        }
    },
    ready() {
        var momentedDate = moment(this.date);


        this.frenchDate = momentedDate.format('LLL');
        setTimeout(() => this.relativeTime = momentedDate.fromNow() , 10000);
        this.relativeTime = momentedDate.fromNow();
    }
}
</script>