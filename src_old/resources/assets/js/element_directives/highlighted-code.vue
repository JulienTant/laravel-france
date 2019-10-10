<template>
<pre class="%LANGUAGE_CLASS%"><code>%INNER_HTML%</code></pre>
</template>

<script type="text/ecmascript-6">
    var hljs = require('highlight.js');

    export default {
        bind() {

            var languageAttribute = this.el.getAttribute('language');
            var languageClass = languageAttribute ? 'language-'  +languageAttribute : '';

            this.el.innerHTML = this.template.replace('%LANGUAGE_CLASS%', languageClass).replace('%INNER_HTML%', this.el.innerHTML);

            hljs.highlightBlock(this.el.querySelector('pre'));
        }
    }
</script>