var BerlinoPanels = new Class({
    Implements: [Options, Events],

    options: {
        panelClass: 'lateral_panel',
        url: {
            online: '/gdr/online',
            messages: '/gdr/messaggi',
            notifications: '/gdr/notifiche',
            weather: '/gdr/meteo'
        },
        defaultContent: 'online'
    },

    RightPanel: null,

    LeftPanel: null,
    OnlinePanel: null,
    MessagesPanel: null,
    NotificationsPanel: null,
    WeatherPanel: null,
    LeftHidder: null,

    Sizes: { Panel: {}, Label: {}, Border: { Online: {}, Messages: {}, Notifications: {}, Weather: {} } },

    initialize: function(options)
    {
        this.setOptions(options);

        this._createPanels();

        this._resizePanels();
        window.addEvent('resize', this._resizePanels.bind(this));

        this.open(this.options.defaultContent);
        this._refreshContent.periodical(10000, this);
    },

    _createPanels: function()
    {
        this.LeftPanel = new Element('div', { id: this.options.panelClass + '_left' }).inject(document.body);
        this.LeftPanel.store('hidden', false);

        this.OnlinePanel = this._createPanel('online').inject(this.LeftPanel);
        this.MessagesPanel = this._createPanel('messages').inject(this.LeftPanel);
        this.NotificationsPanel = this._createPanel('notifications').inject(this.LeftPanel);
        this.WeatherPanel = this._createPanel('weather').inject(this.LeftPanel);
        this.LeftHidder = new Element('div', { id: this.options.panelClass + '_left_hidder', text: Locale.get('BerlinoPanels.hidder_hide'), events: { click: this.toggle.bind(this) } }).inject(this.LeftPanel);

        this.RightPanel = new Element('div', { id: this.options.panelClass + '_right' }).inject(document.body);
    },

    _createPanel: function(panelName)
    {
        return new Element('div', {
            id: this.options.panelClass + '_' + panelName,
            'class': this.options.panelClass + '_panel',
            tween: {
                transition: 'sine:out'
            }
        }).adopt(
            new Element('div', {
                id: this.options.panelClass + '_' + panelName + '_label',
                'class': this.options.panelClass + '_panel_label',
                text: Locale.get('BerlinoPanels.label_' + panelName),

                events: {
                    click: this.open.bind(this, panelName)
                }
            })
        ).adopt(
            new Element('div', {
                id: this.options.panelClass + '_' + panelName + '_body',
                'class': this.options.panelClass + '_panel_body' })
        );
    },

    _resizePanels: function()
    {
        this.Sizes.Panel.Left  = window.getSize().y;
        this.Sizes.Panel.Left -= this.LeftPanel.getStyle('paddingTop').toInt();
        this.Sizes.Panel.Left -= this.LeftPanel.getStyle('paddingBottom').toInt();
        this.Sizes.Panel.Left -= this.LeftPanel.getStyle('borderTopWidth').toInt();
        this.Sizes.Panel.Left -= this.LeftPanel.getStyle('borderBottomWidth').toInt();
        this.Sizes.Panel.Left -= this.LeftPanel.getPosition().y;
        this.LeftPanel.setStyle('height', this.Sizes.Panel.Left);

        this.Sizes.Label.Online = this.OnlinePanel.getElement('.' + this.options.panelClass + '_panel_label').getSize().y;
        this.Sizes.Label.Messages = this.MessagesPanel.getElement('.' + this.options.panelClass + '_panel_label').getSize().y;
        this.Sizes.Label.Notifications = this.NotificationsPanel.getElement('.' + this.options.panelClass + '_panel_label').getSize().y;
        this.Sizes.Label.Weather = this.WeatherPanel.getElement('.' + this.options.panelClass + '_panel_label').getSize().y;
        this.Sizes.Body = this.Sizes.Panel.Left - this.Sizes.Label.Online - this.Sizes.Label.Messages - this.Sizes.Label.Notifications - this.Sizes.Label.Weather;

        this.LeftPanel.getElements('.' + this.options.panelClass + '_panel_body').each(function(el){
            el.setStyle('height', this.Sizes.Body);
        }.bind(this));

        this.Sizes.Border.Online.Top = this.OnlinePanel.getStyle('borderTopWidth').toInt() + this.OnlinePanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderTopWidth').toInt();
        this.Sizes.Border.Online.Bottom = this.OnlinePanel.getStyle('borderBottomWidth').toInt() + this.OnlinePanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderBottomWidth').toInt();
        this.Sizes.Border.Messages.Top = this.MessagesPanel.getStyle('borderTopWidth').toInt() + this.MessagesPanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderTopWidth').toInt();
        this.Sizes.Border.Messages.Bottom = this.MessagesPanel.getStyle('borderBottomWidth').toInt() + this.MessagesPanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderBottomWidth').toInt();
        this.Sizes.Border.Notifications.Top = this.NotificationsPanel.getStyle('borderTopWidth').toInt() + this.NotificationsPanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderTopWidth').toInt();
        this.Sizes.Border.Notifications.Bottom = this.NotificationsPanel.getStyle('borderBottomWidth').toInt() + this.NotificationsPanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderBottomWidth').toInt();
        this.Sizes.Border.Weather.Top = this.WeatherPanel.getStyle('borderTopWidth').toInt() + this.WeatherPanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderTopWidth').toInt();
        this.Sizes.Border.Weather.Bottom = this.WeatherPanel.getStyle('borderBottomWidth').toInt() + this.WeatherPanel.getElement('.' + this.options.panelClass + '_panel_label').getStyle('borderBottomWidth').toInt();

        this.MessagesPanel.store('topY', this.Sizes.Label.Online - Math.min(this.Sizes.Border.Online.Bottom, this.Sizes.Border.Messages.Top));
        this.MessagesPanel.store('bottomY', this.Sizes.Panel.Left - this.Sizes.Label.Messages - this.Sizes.Label.Notifications - this.Sizes.Label.Weather + Math.min(this.Sizes.Border.Messages.Bottom, this.Sizes.Border.Notifications.Top) + Math.min(this.Sizes.Border.Notifications.Bottom, this.Sizes.Border.Weather.Top));

        this.NotificationsPanel.store('topY', this.Sizes.Label.Online - Math.min(this.Sizes.Border.Online.Bottom, this.Sizes.Border.Messages.Top) + this.Sizes.Label.Messages - Math.min(this.Sizes.Border.Messages.Bottom, this.Sizes.Border.Notifications.Top));
        this.NotificationsPanel.store('bottomY', this.Sizes.Panel.Left - this.Sizes.Label.Notifications - this.Sizes.Label.Weather + Math.min(this.Sizes.Border.Notifications.Bottom, this.Sizes.Border.Weather.Top));

        this.WeatherPanel.store('topY', this.Sizes.Label.Online - Math.min(this.Sizes.Border.Online.Bottom, this.Sizes.Border.Messages.Top) + this.Sizes.Label.Messages - Math.min(this.Sizes.Border.Messages.Bottom, this.Sizes.Border.Notifications.Top) + this.Sizes.Label.Notifications - Math.min(this.Sizes.Border.Notifications.Bottom, this.Sizes.Border.Weather.Top));
        this.WeatherPanel.store('bottomY', this.Sizes.Panel.Left - this.Sizes.Label.Weather);

        this.MessagesPanel.setStyle('top', this.MessagesPanel.retrieve('bottomY'));
        this.NotificationsPanel.setStyle('top', this.NotificationsPanel.retrieve('bottomY'));
        this.WeatherPanel.setStyle('top', this.WeatherPanel.retrieve('bottomY'));
        this.LeftPanelActive = 'online';
    },

    open: function(panelName)
    {
        if(this.LeftPanel.retrieve('hidden'))
            this.show();

        if(panelName != this.LeftPanelActive && panelName != undefined)
        {
            this.LeftPanelActive = panelName;
            this._refreshContent();

            switch(panelName)
            {
                case 'online':
                    this.MessagesPanel.tween('top', this.MessagesPanel.retrieve('bottomY'));
                    this.NotificationsPanel.tween('top', this.NotificationsPanel.retrieve('bottomY'));
                    this.WeatherPanel.tween('top', this.WeatherPanel.retrieve('bottomY'));
                break;

                case 'messages':
                    this.MessagesPanel.tween('top', this.MessagesPanel.retrieve('topY'));
                    this.NotificationsPanel.tween('top', this.NotificationsPanel.retrieve('bottomY'));
                    this.WeatherPanel.tween('top', this.WeatherPanel.retrieve('bottomY'));
                break;

                case 'notifications':
                    this.MessagesPanel.tween('top', this.MessagesPanel.retrieve('topY'));
                    this.NotificationsPanel.tween('top', this.NotificationsPanel.retrieve('topY'));
                    this.WeatherPanel.tween('top', this.WeatherPanel.retrieve('bottomY'));
                break;

                case 'weather':
                    this.MessagesPanel.tween('top', this.MessagesPanel.retrieve('topY'));
                    this.NotificationsPanel.tween('top', this.NotificationsPanel.retrieve('topY'));
                    this.WeatherPanel.tween('top', this.WeatherPanel.retrieve('topY'));
                break;
            }
        }
    },

    show: function()
    {
        this.LeftPanel.store('hidden', false);
        this.LeftHidder.set('text', Locale.get('BerlinoPanels.hidder_hide'));

        this.LeftPanel.tween('left', 0);
    },

    hide: function()
    {
        this.LeftPanel.store('hidden', true);
        this.LeftHidder.set('text', Locale.get('BerlinoPanels.hidder_show'));

        this.LeftPanel.tween('left', this.LeftPanel.getDimensions().x * -1);
    },

    toggle: function()
    {
        if(this.LeftPanel.retrieve('hidden'))
            this.show();
        else
            this.hide();
    },

    _refreshContent: function()
    {
        var ToUpdate = null;
        switch(this.LeftPanelActive)
        {
            case 'online':
                ToUpdate = this.OnlinePanel;
            break;

            case 'messages':
                ToUpdate = this.MessagesPanel;
            break;

            case 'notifications':
                ToUpdate = this.NotificationsPanel;
            break;

            case 'weather':
                ToUpdate = this.WeatherPanel;
            break;
        }

        new Request.HTML({
            url: this.options.url[this.LeftPanelActive] + '.ajax',
            update: ToUpdate.getElement('.' + this.options.panelClass + '_panel_body'),

            onSuccess: function(){
                ZweBox.getInstance().refreshLinks();
            }
        }).send();
    }
});

Locale.define('it-IT', 'BerlinoPanels', {
    label_online: 'Online',
    label_messages: 'Messaggi',
    label_notifications: 'Notifiche',
    label_weather: 'Meteo',

    hidder_hide: 'Nascondi',
    hidder_show: 'Mostra'
});