$.overridePlugin('swEmotionLoader', {
    loadEmotion: function(controllerUrl, deviceState) {
        var me = this,
            devices = me.availableDevices,
            types = me.opts.deviceTypes,
            url = controllerUrl || me.opts.controllerUrl,
            state = deviceState || StateManager.getCurrentState();

        /**
         * Hide the emotion world if it is not defined for the current device.
         */
        if (devices.indexOf(types[state]) === -1) {
            me.$overlay.remove();
            me.hideEmotion();
            return;
        }

        /**
         * Return if the plugin is not configured correctly.
         */
        if (!devices.length || !state.length || !url.length) {
            me.$overlay.remove();
            me.hideEmotion();
            return;
        }

        /**
         * If the emotion world was already loaded show it.
         */
        if (me.$emotion && me.$emotion.length) {
            me.$overlay.remove();
            me.showEmotion();
            return;
        }

        me.$overlay.remove();
        me.showEmotion();
        $.publish('plugin/swEmotionLoader/onLoadEmotionLoaded', [ me ]);
        me.initEmotion(me.$el.find('template').html());
        $.publish('plugin/swEmotionLoader/onLoadEmotionFinished', [ me ]);

        $.publish('plugin/swEmotionLoader/onLoadEmotion', [me]);
    },
});