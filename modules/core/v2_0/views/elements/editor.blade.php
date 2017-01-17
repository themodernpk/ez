<!--editor-->
<script src="<?php echo asset_path(); ?>/plugins/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'.content-editor',
        browser_spellcheck : true,
        plugins: "link, autoresize, paste",
        paste_preprocess : function(pl, o) {
            //example: keep bold,italic,underline and paragraphs
            o.content = strip_tags( o.content,'<b><p><br/>' );

            // remove all tags => plain text
            //o.content = strip_tags( o.content,'' );
        },
        autoresize_max_height: '350',
        toolbar: "newdocument bold italic underline strikethrough link unlink | fontsizeselect bullist numlist outdent indent removeformat | undo redo ",
        menubar:false,
        statusbar: false,
        setup: function(editor) {
            editor.on('blur', function(e) {
                var content = tinyMCE.activeEditor.getContent({format : 'raw'});
                $('.content-editor').val(content);
            });
        },
        content_css: "<?php echo asset_path(); ?>/plugins/tinymce/editor.css",
    });

    function strip_tags (str, allowed_tags)
    {

        var key = '', allowed = false;
        var matches = [];    var allowed_array = [];
        var allowed_tag = '';
        var i = 0;
        var k = '';
        var html = '';
        var replacer = function (search, replace, str) {
            return str.split(search).join(replace);
        };
        // Build allowes tags associative array
        if (allowed_tags) {
            allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
        }
        str += '';

        // Match tags
        matches = str.match(/(<\/?[\S][^>]*>)/gi);
        // Go through all HTML tags
        for (key in matches) {
            if (isNaN(key)) {
                // IE7 Hack
                continue;
            }

            // Save HTML tag
            html = matches[key].toString();
            // Is tag not in allowed list? Remove from str!
            allowed = false;

            // Go through all allowed tags
            for (k in allowed_array) {            // Init
                allowed_tag = allowed_array[k];
                i = -1;

                if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
                if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
                if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}

                // Determine
                if (i == 0) {
                    allowed = true;
                    break;
                }
            }
            if (!allowed) {
                str = replacer(html, "", str); // Custom replace. No regexing
            }
        }


        str = replaceAll(str, '<p></p>', '');

        return str;
    }


    function replaceAll(str, find, replace)
    {
        return str.replace(new RegExp(find, 'g'), replace);
    }

</script>
<!--/editor-->