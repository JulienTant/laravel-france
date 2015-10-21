<script lang="es6" type="text/ecmascript-6">
    import SimpleMDE from 'simplemde'

    export default {
        twoWay: true,
        bind: function () {
            var self = this;

            self.editor = new SimpleMDE({
                element: self.el,
                indentWithTabs: false,
                previewRender: function(plainText, preview) { // Async method
                    preview.innerHTML = self.$http.post(Laroute.route('api.markdown'), {markdown: plainText})
                            .success((data) => { preview.innerHTML = data.html });
                    return preview.innerHTML;
                },
                spellChecker: false,
                status: ['lines', 'words', 'cursor'],
                tabSize: 4,
                toolbar: ["bold", "italic", "heading", "|", "quote", "code", "unordered-list", "ordered-list", "|", "link", "image", "|", "preview", "side-by-side", "fullscreen"],
                toolbarTips: true
            });

            self.editor.codemirror.on("change", function() {
                self.set(self.editor.value());
            });
        },
        update: function (newValue, oldValue) {
            var self = this;
            self.vm.$nextTick(() => {
                self.editor.value(newValue);
            });

        },
        unbind: function () {
            var el = this.el;

            var parent = el.parentElement;

            if (parent) {
                var classes = ['editor-toolbar', 'CodeMirror', 'editor-preview-side' ,'editor-statusbar'];
                for (var i in classes) {
                    var toRemove = parent.querySelector('.' + classes[i])
                    if (toRemove) {
                        toRemove.remove();
                    }
                }
            }

            el.style.display = "";
        }
    }
</script>