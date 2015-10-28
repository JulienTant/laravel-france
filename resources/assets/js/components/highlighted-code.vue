<template>
    <pre class="{{ language ? 'language-' + language : '' }}"><code><slot></slot></code></pre>
</template>

<script type="text/ecmascript-6">
    var hljs = require('highlight.js');

    export default {
        props: ['language'],
        ready () {
            hljs.highlightBlock(this.$el);
        }
    }
</script>