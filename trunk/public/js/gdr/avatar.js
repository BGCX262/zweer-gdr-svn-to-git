window.addEvent('domready', function(){
    if(document.id('form_diario_nuova_pagina'))
    {
        if(document.id('testo'))
        {
            CKEDITOR.replace('testo', CKEditorOptionsBBCode);
        }
    }
});