var hljs = require('highlight.js/lib/highlight');

hljs.registerLanguage('css', require('highlight.js/lib/languages/css'));
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));

$(function () {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });
})
