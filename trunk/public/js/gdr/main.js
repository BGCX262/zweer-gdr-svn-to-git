var Pannelli;

window.addEvent('domready', function(){
    if(Berlino_IDUser > 0)
    {
        Pannelli = new BerlinoPanels();
        document.id('top_button_online').addEvent('click', function(e){
            e.stop();
            Pannelli.open('online');
        });

        document.id('top_button_messaggi').addEvent('click', function(e){
            e.stop();
            Pannelli.open('messages');
        });

        document.id('top_button_notifiche').addEvent('click', function(e){
            e.stop();

            Pannelli.open('notifications');
        });

        new ZweBox();
    }
});