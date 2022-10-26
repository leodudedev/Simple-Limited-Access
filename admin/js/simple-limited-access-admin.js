(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */


    $(window).load(function () {

        let settings = {
            tinymce: {toolbar1: "bold,italic,bullist,link"},
            quicktags: {
                "buttons": "strong,em,link,ul,li,code"
            },

        };

        let conf = wp.editor.getDefaultSettings();
        conf.tinymce.toolbar1 = "bold,italic,underline,forecolor,bullist,numlist,link";

        wp.editor.initialize('sla_text', conf);


        let sel = jQuery('.sla-select2');
        if (sel.length) {
            sel.each(function (i, e) {
                let elm = jQuery(e);
                let init_val = elm.data('initval');
                if (init_val) {
                    elm.val(init_val.toString().split(','));
                }
                elm.select2();
            });
        }
    });


})(jQuery);
