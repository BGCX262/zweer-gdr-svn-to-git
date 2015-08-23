var CKEditorOptionsFull = {
    toolbarCanCollapse: false,
    toolbar: [
        { name: 'document', items: ['Source'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
        { name: 'colors', items : [ 'TextColor', 'BGColor' ] },
        { name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] },
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
        { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
        { name: 'insert', items : [ 'Image', 'Flash','Smiley','SpecialChar' ] },
        { name: 'styles', items : [ 'Styles', 'Format', 'Font', 'FontSize' ] }
    ]
};

var CKEditorOptionsBBCode = {
    extraPlugins: 'bbcode',
    removePlugins: 'bidi,button,dialogadvtab,div,filebrowser,flash,format,forms,horizontalrule,iframe,indent,justify,liststyle,pagebreak,showborders,stylescombo,table,tabletools,templates',
    disableObjectResizing: true,

    fontSize_sizes: "30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%",
    toolbar: [
        { name: 'document', items: ['Source'] },
        { name: 'tools', items: ['Maximize'] },
        { name: 'clipboard', items: ['Undo', 'Redo'] },
        { name: 'links', items: ['Link', 'Unlink'] },
        { name: 'insert', items: ['Image', 'Flash', 'Smiley', 'SpecialChar'] },
        { name: 'basicstyles', items: ['Bold', 'Italic','Underline'] },
        { name: 'styles', items: ['FontSize', 'TextColor'] },
        { name: 'paragraph', items: ['NumberedList','BulletedList','-','Blockquote'] }
    ],
    smiley_images: [
        'regular_smile.gif','sad_smile.gif','wink_smile.gif','teeth_smile.gif','tounge_smile.gif',
        'embaressed_smile.gif','omg_smile.gif','whatchutalkingabout_smile.gif','angel_smile.gif','shades_smile.gif',
        'cry_smile.gif','kiss.gif'
    ],
    smiley_descriptions: [
        'smiley', 'sad', 'wink', 'laugh', 'cheeky', 'blush', 'surprise',
        'indecision', 'angel', 'cool', 'crying', 'kiss'
    ]
};