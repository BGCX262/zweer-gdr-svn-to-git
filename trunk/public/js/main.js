// Main js file

window.addEvent('domready', function(){
    Locale.use('it-IT');
});

String.implement({
    toElement: function(){
        return new Element('div', { html: this }).getFirst();
    }
});