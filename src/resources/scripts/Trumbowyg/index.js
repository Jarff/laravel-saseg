require('trumbowyg');
require('trumbowyg/dist/ui/trumbowyg.min.css');
require('trumbowyg/dist/plugins/base64/trumbowyg.base64');
require('trumbowyg/dist/plugins/cleanpaste/trumbowyg.cleanpaste');
require('trumbowyg/dist/plugins/noembed/trumbowyg.noembed');

$.trumbowyg.svgPath = process.env.MIX_URL+'/panel/vendor/trumbowyg/dist/ui/icons.svg';
$('.trumbowyg-panel').trumbowyg(
    {
        btnsDef: {
            base64: {
                ico: 'insert-image',
                title: 'Insertar Imagen',
                text: 'Insertar Imagen',
            },
            noembed: {
                title: 'Insertar URL video',
                text: 'Insertar URL video',
            }
        },
        btns: [
            ['formatting'],
            ['strong', 'em', 'del'],
            ['link'],
            ['base64'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['noembed']
        ]
    }
);