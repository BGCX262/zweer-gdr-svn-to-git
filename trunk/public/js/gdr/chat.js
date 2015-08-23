window.addEvent('domready', function(){
    var ChatForm = document.id('form_newChat'),
        VediChat = document.id('chat_messages'),
        Luogo = VediChat.retrieve('luogo'),
        RefreshChat = function(){
            var LastID = VediChat.retrieve('lastID') || 0;

            new Request.JSON({
                url: '/chat/luogo/nuovi/' + Luogo + '.json',
                data: 'lastID=' + LastID,

                onSuccess: function(J){
                    J['messaggi'].each(function(Messaggio){
                        VediChat.store('lastID', Messaggio['id']);
                        var E = Messaggio['text'].toElement();
                        VediChat.adopt(E);
                        E.slide('hide').slide('in');
                        (function(){ new Fx.Scroll(window).toBottom(); }).delay(500);
                    });
                }
            }).send();
        };

    ChatForm.getElements('input').each(function(el){
        new OverText(el);
        el.addEvent('keypress', function(e){
            if(e.key == 'enter')
                ChatForm.fireEvent('submit');
        });
    });
    ChatForm.set('send', { async: false });
    new Form.Validator.Inline(ChatForm);

    ChatForm.addEvent('submit', function(){
        ChatForm.send();
        ChatForm.reset();
        RefreshChat();
    });

    RefreshChat();
    RefreshChat.periodical(10000);
});