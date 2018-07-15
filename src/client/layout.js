/*
 * Copyright (c) 2018. Jake Toolson
 */

!function($) {
    'use strict';

    let App = function() {
        this.$body = $('body'),
            this.$window = $(window)
    };


    /**
     * Initializes the menu - top and sidebar
     */
    App.prototype.initMenu = function() {
        let $this = this;

        // Left menu collapse
        $('.button-menu-mobile').on('click', function (event) {
            event.preventDefault();
            $this.$body.toggleClass("enlarged");
        });

        // Topbar - main menu
        $('.navbar-toggle').on('click', function (event) {
            $(this).toggleClass('open');
        });

        //metis menu
        $("#side-menu").metisMenu();

        // right side-bar toggle
        $('.right-bar-toggle').on('click', function(e){
            $('body').toggleClass('right-bar-enabled');
        });

        $(document).on('click', 'body', function (e) {
            if($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                return;
            }
            $('body').removeClass('right-bar-enabled');
            return;
        });

        // activate the menu in left side bar based on url
        $("#sidebar-menu a").each(function () {
            let pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().addClass("in");
                $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("in"); // add active to li of the current link
                $(this).parent().parent().parent().parent().parent().addClass("active");
            }
        });
    },

        /**
         * Init the layout - with broad sidebar or compact side bar
         */
        App.prototype.initLayout = function() {
            let $this = this;
            // in case of small size, add class enlarge to have minimal menu
            if ($this.$window.width() < 1025) {
                $this.$body.addClass('enlarged');
            } else {
                if ($this.$body.data('keep-enlarged') != true)
                    $this.$body.removeClass('enlarged');
            }
        },

        //initializing
        App.prototype.init = function() {
            let $this = this;
            this.initLayout();
            this.initMenu();

            // handle responsiveness when reload
            this.$window.on('resize', function(e) {
                e.preventDefault();
                $this.initLayout();
            });
        },

        $.App = new App, $.App.Constructor = App


}(window.jQuery),
    //initializing main application module
    function($) {
        "use strict";
        $.App.init();
    }(window.jQuery);
