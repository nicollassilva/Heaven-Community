Community = {
    init() {
        this.tooltip(),
        this.slidesCommunity(),
        this.minimizeCategorie(),
        this.iziToastInit(),
        this.formsBundle(),
        this.userDropdown(),
        this.userLogout()
    },

    tooltip() {
        $(document).tooltip({
            selector: '[data-toggle="tooltip"]',
            html: true
        });
        $('[data-toggle="popover"]').popover()
    },

    iziToastInit() {
        iziToast.settings({
            transitionIn: "flipInX",
            icon: "Fontawesome",
            transitionOut: "flipOutX",
            theme: 'dark',
            displayMode: 'replace',
            position: "topLeft",
            timeout: 3e3
        })
    },

    slidesCommunity() {
        new Swiper('.general-box .general-right-column .partners .swiper-container', {
            spaceBetween: 30,
            centeredSlides: true,
            loop: true,
            autoplay: {
              delay: 2500,
              disableOnInteraction: false,
            },
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            }
        });
    },

    minimizeCategorie() {
        $('.minimize').on('click', function() {
            $(this).parent().next('ul').slideToggle()
            if($(this).find('i').hasClass('fa-minus')) {
                $(this).html('<i class="fas fa-plus"></i>')
            } else {
                $(this).html('<i class="fas fa-minus"></i>')
            }
        })
    },

    formsBundle: function() {
        $("form:not(.active)").removeClass("active").addClass("active").on("submit", function(t) {
            t.preventDefault(), $(this);
            let a = $(this).find('button[type="submit"]'),
                e = $(this).attr("action"),
                i = new FormData($(this)[0]),
                o = $(this).attr("data-reset"),
                n = a.text();
                i.append("_token", $('meta[name="csrf-token"]').attr("content"));
            $.ajax({
                url: e,
                type: "POST",
                dataType: "JSON",
                data: i,
                processData: !1,
                contentType: !1,
                beforeSend: () => {
                    a.attr("disabled", !0), a.text("Processando...")
                },
                success: t => {
                    t.error && t.title ? iziToast.show({
                        title: t.title,
                        icon: 'fas fa-times',
                        progressBarColor: 'rgba(255, 94, 87,1.0)',
                        message: t.msg
                    }) : t.success ? (void 0 !== o && !1 !== o && $(this)[0].reset(), iziToast.show({
                        title: t.title,
                        icon: 'fas fa-check',
                        progressBarColor: 'rgba(68, 189, 50, 1.0)',
                        message: t.msg
                    }), t.href && "" != t.href && setTimeout(() => {
                        window.location.href = t.href
                    }, 2e3)) : t.warning && iziToast.warning({
                        title: t.title,
                        icon: 'fas fa-exclamation',
                        message: t.msg
                    }), setTimeout(() => {
                        a.attr("disabled", !1), a.text(n)
                    }, 1500)
                },
                error: (a) => {
                    console.log(a)
                    iziToast.show({
                        title: "Error!",
                        message: "Error Code AC01.",
                        closeOnClick: !0,
                        position: "bottomCenter"
                    })
                }
            })
        })
    },

    userDropdown() {
        $('.logged-box .dropdown').on('click', function() {
            $(this).toggleClass('active')
            $(this).find('.drop').slideToggle('fast')
            let i = $(this).find('.me i')
            if(i.hasClass('fa-chevron-down')) {
                i.removeClass('fa-chevron-down').addClass('fa-chevron-up')
            } else {
                i.removeClass('fa-chevron-up').addClass('fa-chevron-down')
            }
        })

        $('.logged-box .menuLogged').on('click', function() {
            $('.logged-box .menuLogged').removeClass('active')
            $(this).addClass('active')
            if($(this).hasClass('messages')) {
                $('.logged-box .notifications .box-notifications:not(.message)').hide()
                $('.logged-box .notifications .box-notifications.message').show()
            } else {
                $('.logged-box .notifications .box-notifications.message').hide()
                $('.logged-box .notifications .box-notifications:not(.message)').show()
            }
        })
    },

    userLogout: function() {
        $('.logged-box .box-me .dropdown a:last-of-type').on('click', function() {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-frown',
                title: 'Hey',
                message: $(this).attr('data-confirm'),
                position: 'bottomCenter',
                balloon: true,
                progressBarColor: '#0fbcf9',
                buttons: [
                    ['<button class="btn"><i class="far fa-thumbs-up"></i></button>', function (instance, toast) {
                        $.ajax({
                            url: "/logout",
                            type: "POST",
                            dataType: "JSON",
                            beforeSend: () => {
                                $("body").animate({
                                    opacity: "0.9"
                                }, 700)
                            },
                            success: t => {
                                setTimeout(() => {
                                    t.success && (iziToast.show({
                                        title: t.title,
                                        progressBarColor: 'rgba(68, 189, 50, 1.0)',
                                        message: t.msg
                                    }), setTimeout(() => {
                                        location.reload()
                                    }, 2e3))
                                }, 1e3)
                            },
                            error: () => false
                        })
                    }, true],
                    ['<button class="btn"><i class="far fa-thumbs-down"></i>', function (instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutLeft'
                        }, toast, 'buttonName');
                    }]
                ]
            });
        })
    },
}

$(document).ready(() => {
    Community.init()
})