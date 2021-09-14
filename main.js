jQuery(function ($) {
    let body = $("body");

    $('.carousel').carousel({
        interval: 8000
    })
    // new item init
    //selectric plugin for dropdowns
    $('.selectric').selectric();
    //selectric plugin for dropdowns END

    //date picker
    $( function() {
    $('.date-picker').datepicker({
        dateFormat: 'd-mm-yy',
        minDate: 0,
        inline: true,
    }); } );

    // // Try to get specific times in weekends
    // $(function() {
    //     $( ".date-picker" ).datepicker({ dateFormat: "dd-mm-yy" });
    //     $(".date-picker").on("change",function(){
    //         var selected = $(this).val();
    //         var noWeekend = $.datepicker.noWeekends();
    //         if (noWeekend[0]) {
    //             $('.timepicker').timepicker({
    //                 interval: 60,
    //                 minTime: '12',
    //                 maxTime: '21',
    //                 defaultTime: '12',
    //                 startTime: '12:00',
    //                 dynamic: false,
    //                 dropdown: true,
    //                 scrollbar: true
    //             });
    //         } else {
    //             $('.timepicker').timepicker({
    //                 interval: 60,
    //                 minTime: '12',
    //                 maxTime: '20',
    //                 defaultTime: '12',
    //                 startTime: '12:00',
    //                 dynamic: false,
    //                 dropdown: true,
    //                 scrollbar: true
    //             });
    //         }
    //     });
    // });

    //date picker END
    // Time picker
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        minTime: '12',
        maxTime: '19:30',
        startTime: '12:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        use24hours: true
    });
    // Time picker END
    //hides dot in navbar if current menu item is active
    $(function() {
        if (!$(".menu ul li").hasClass('current-menu-item')) {
            $(".nav-line-dot").removeClass('d-none')
        }
        if ($(".extra-logo-container").hasClass('current-menu-item')) {
            $(".nav-line-dot").addClass('d-none')
        }
    });

    // ACTIVE MENU NAVBAR - DOT
    $('.menu ul li').on('click', function () {
        $('.menu ul .current-menu-item, .extra-logo').removeClass('current-menu-item');
        $(this).addClass('current-menu-item');
        $('.menu ul .current-menu-item').remove('.nav-line-dot');
        // hides dot in navbar when added current menu item class to any item
        if ($(".menu ul li").hasClass('current-menu-item')) {
            $(".nav-line-dot").addClass('d-none')
        }
        if ($(".extra-logo-container").hasClass('current-menu-item')) {
            $(".extra-logo-container").removeClass('current-menu-item')
        }

    });

    $('.extra-logo').on('click', function () {
        $('.current-menu-item').removeClass('current-menu-item');
        $(this).parent().addClass('current-menu-item');
        $('.extra-logo').remove('.nav-line-dot');
        $('.menu ul .current-menu-item').remove('.nav-line-dot');
        // hides dot in navbar when added current menu item class to any item
        if ($(".extra-logo-container").hasClass('current-menu-item')) {
            $(".nav-line-dot").addClass('d-none')
        }
    });
    //hides dot in navbar if current menu item is active END

    $('.show-more').on('click', function () {
        $('.mobile-short-text').css({ "max-height": "100%"});
        $(".show-more").toggleClass('d-none');
        $(".show-less").toggleClass('d-none');
    });

    $('.show-less').on('click', function () {
        $('.mobile-short-text').css({ "max-height": "317px"});
        $('.show-more').toggleClass('d-none');
        $('.show-less').toggleClass('d-none');
    });

    // CLOSE LANDING popup window
    $('.close-info-button').on('click', function () {
        $('.popup-message').addClass('d-none');
        $('.popup-message').removeClass('d-flex');
    });


    // ACTIVE MENU NAVBAR
    //CLOSE & OPEN MOB MENU
    $(document).keyup(function(e) {
        if (e.keyCode == 27) { // escape key maps to keycode `27`
            e.preventDefault();
            $(".mobile-menu").addClass("mobile-menu-hidden");
            $(".mobile-background").addClass("mobile-background-hidden");
            $("#burger-mob").removeClass("collapsed");
            $('body').removeClass('modal-open');
        }
    });
    //GALLERY NEXT PREVIOUS
    //LEFT - PREV
    $(document).keyup(function(e) {
        if (e.keyCode == 37) {
            $('.carousel-control-prev').click();
        }
    });

    //RIGHT - NEXT
    $(document).keyup(function(e) {
        if (e.keyCode == 39) {
            $('.carousel-control-next').click();
        }
    });
    //GALLERY NEXT PREVIOUS END

    let header = $(".navbar-header");
    let lastScroll = $(window).scrollTop();
    (lastScroll == 0) ? header.removeClass('navbar-scroll') : header.addClass('navbar-scroll');
    let currentScroll;
    $(window).on("scroll", function () {
        currentScroll = $(this).scrollTop();
        if (currentScroll > lastScroll + 200) {
            lastScroll = $(this).scrollTop();

        }
        if (currentScroll < lastScroll) {
            lastScroll = $(this).scrollTop();
            header.fadeIn();
        }
        (currentScroll == 0) ? header.removeClass('navbar-scroll') : header.addClass('navbar-scroll');
    });
    /*END MENU HIDE ON SCROLLING*/

    /*MOBILE MENU*/
    $('body').on("click", ".menu-opener", function (e) {
        e.preventDefault();
        $(".mobile-menu").toggleClass("mobile-menu-hidden");
        $(".mobile-background").toggleClass("mobile-background-hidden");
        $("#burger-mob").toggleClass("collapsed");
        $('body').toggleClass('modal-open');
    });
    /*END MOBILE MENU*/

    /*SHOW SLIDE BY PREVIEW CLICK*/
    let imageNumber;
    let slideNumber;
    body.on("click", ".slider-image-link", function () {
        imageNumber = $(this).attr('data-counter');
        $('.image-modal-window').find('.carousel-item').each(function (index) {
            $(this).removeClass('active');
            slideNumber = $(this).attr("data-counter");
            if (slideNumber == imageNumber) {
                $(this).addClass('active');
            }
        });
    });
    /*END SHOW SLIDE BY PREVIEW CLICK*/

    /*CLOSE MODAL FIX*/
    body.on('click', ".image-modal-window .align-modal-helper", function (e) {
        if (e.target !== this) return;
        $(this).parents('.image-modal-window').find('.modal-cross').trigger('click');
    });
    /*CLOSE MODAL FIX*/
    /*HEIGHT SLIDER TRANSITION*/
    body.on('slide.bs.carousel', '.carousel', function (e) {
        let nextH = $(e.relatedTarget).height();
        $(this).find('.active.carousel-item').parent().animate({
            height: nextH
        }, 500);
    });
    $(window).on('hidden.bs.modal', function () {
        $('.carousel .carousel-inner').css("height", "auto");
    });
    $(window).resize(function () {
        $('.carousel .carousel-inner').css("height", "auto");
    });
    /*END HEIGHT SLIDER TRANSITION*/

    /*SUBSCRIBE FORM*/
    let preloader = $(".preloader");
    //name
    let nameInput = $(".input-name");

    //phone
    let phoneInput = $(".input-phone");
    //guest count
    let guestCountInput = $(".single-input .selectric .option");
    // let guestCountInputVal;
    //date
    let dateInput = $(".date-picker");
    let dateInputVal
    let timeInput = $(".timepicker");
    let timeInputVal
    //email
    let emailInput = $(".input-email");
    let  nonValidEmail = $(".non-valid-email-warning");
    //message
    let messageInput = $(".input-message");

    let  emptyFieldsValidationMessage = $(".empty-field-warning");

    /*CONTACT FORM*/
    body.on("submit", "#contact-form", function (e) {
        preloader.show();
        e.preventDefault(e);
        let contactFormData = $(this).serialize();
        dateInputVal = $( ".date-input" ).datepicker( "getDate" );
        timeInputVal = $( ".time-input" ).val();
        $.ajax({
            url: "/wp-admin/admin-ajax.php",
            type: "post",
            data: {
                action: 'contactFormHandler',
                contactFormData: contactFormData,
                dateInputVal: dateInputVal,
                dateInputVal: dateInputVal
            },
            dataType: 'json',
            success: function (response) {

                let contactFormChecker = 0;

                if (response["form-name"] == false) {
                    nameInput.parent().addClass("warning-validation");
                    contactFormChecker++;
                } else {
                    nameInput.parent().removeClass("warning-validation");
                }

                if (response["form-email"] == false) {
                    emailInput.parent().addClass("warning-validation");
                    nonValidEmail.addClass("warning-message-visible");
                    contactFormChecker++;
                } else {
                    emailInput.parent().removeClass("warning-validation");
                    nonValidEmail.removeClass("warning-message-visible");
                }

                if (response["form-phone"] == false) {
                    phoneInput.parent().addClass("warning-validation");
                    contactFormChecker++;
                } else {
                    phoneInput.parent().removeClass("warning-validation");
                }
                //##################################################################
                if (response["form-guest-count"] == false) {
                    guestCountInput.parent().addClass("warning-validation");
                    contactFormChecker++;
                } else {
                    guestCountInput.parent().removeClass("warning-validation");
                }

                if (response["form-date"] == false) {
                    dateInput.parent().addClass("warning-validation");
                    contactFormChecker++;
                } else {
                    dateInput.parent().removeClass("warning-validation");
                }

                if (response["form-time"] == false) {
                    timeInput.parent().addClass("warning-validation");
                    contactFormChecker++;
                } else {
                    timeInput.parent().removeClass("warning-validation");
                }
                //############################################################


                if ( (response["form-email"] == false) || (response["form-name"] == false) || (response["form-phone"] == false) ){
                    emptyFieldsValidationMessage.addClass("warning-message-visible");
                    contactFormChecker++
                } else {
                    emptyFieldsValidationMessage.removeClass("warning-message-visible");
                }

                    preloader.hide();
                if (contactFormChecker == 0) {
                    $("#contact-form").remove();
                    $(".success-submit-wrapper").addClass("show-success-message");
                }

            }
        });

    });
    /*END CONTACT FORM*/

});  // jQuery(function ($) END
