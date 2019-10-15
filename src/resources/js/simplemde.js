import SimpleMDE from 'simplemde'

$(function () {
    document.querySelectorAll('.editor-please').forEach((block) => {
        new SimpleMDE({
            element: block,
            indentWithTabs: false,
            spellChecker: false,
            status: ['lines', 'words', 'cursor'],
            tabSize: 4,
            toolbar: ["bold", "italic", "heading", "|", "quote", "code", "unordered-list", "ordered-list", "table", "|", "link", "image", "|", "preview", "side-by-side", "fullscreen"],
            toolbarTips: true
        });
    });
})

