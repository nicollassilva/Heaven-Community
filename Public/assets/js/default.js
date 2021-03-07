Community = {
    url: window.location.pathname,
    urlArray: window.location.pathname.split('/'),
    userLogged: Number($('meta[name="logged"]').attr('content')),
    delayReactionPost: false,

    init() {
        this.tooltip(),
            this.slidesCommunity(),
            this.minimizeCategorie(),
            this.iziToastInit(),
            this.formsBundle(),
            this.userDropdown(),
            this.userLogout(),
            this.userProfile(),
            this.userFriendRequestsAction(),
            this.tinyMCEEditor()

            if(this.urlArray[1] === 'topic') {
                this.topicReaction()
            }
    },

    tooltip() {
        $(document).tooltip({
            selector: '[data-toggle="tooltip"]',
            html: true,
            boundary: 'window'
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
        $('.minimize').on('click', function () {
            $(this).parent().next('ul').slideToggle()
            if ($(this).find('i').hasClass('fa-minus')) {
                $(this).html('<i class="fas fa-plus"></i>')
            } else {
                $(this).html('<i class="fas fa-minus"></i>')
            }
        })
    },

    formsBundle: function () {
        $("form:not(.active)").removeClass("active").addClass("active").on("submit", function (t) {
            tinyMCE.triggerSave();
            t.preventDefault(), $(this);
            let a = $(this).find('button[type="submit"]'),
                e = $(this).attr("action"),
                i = new FormData($(this)[0]),
                o = $(this).attr("data-reset"),
                n = a.text();
            i.append("_token", $('meta[name="heavencsrftoken"]').attr("content"));
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
                error: (b) => {
                    console.log(b)
                    iziToast.show({
                        title: "Error!",
                        message: "Error Code AC01.",
                        closeOnClick: !0,
                        position: "bottomCenter"
                    })
                    setTimeout(() => {
                        a.attr("disabled", !1), a.text(n)
                    }, 1500)
                }
            })
        })
    },

    userDropdown() {
        $('.logged-box .dropdown').on('click', function () {
            $(this).toggleClass('active')
            $(this).find('.drop').slideToggle('fast')
            let i = $(this).find('.me i')
            if (i.hasClass('fa-chevron-down')) {
                i.removeClass('fa-chevron-down').addClass('fa-chevron-up')
            } else {
                i.removeClass('fa-chevron-up').addClass('fa-chevron-down')
            }
        })

        $('.logged-box .menuLogged').on('click', function () {
            $('.logged-box .menuLogged').removeClass('active')
            $(this).addClass('active')
            if ($(this).hasClass('messages')) {
                $('.logged-box .notifications .box-notifications:not(.message)').hide()
                $('.logged-box .notifications .box-notifications.message').show()
            } else {
                $('.logged-box .notifications .box-notifications.message').hide()
                $('.logged-box .notifications .box-notifications:not(.message)').show()
            }
        })
    },

    userLogout: function () {
        $('.logged-box .box-me .dropdown a:last-of-type').on('click', function () {
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

    userProfile() {
        if (this.urlArray[1] == 'profile') {
            $(document).on('click', '.profile-box .menuProfile ul li:not(.active)', function () {
                $('.profile-box .menuProfile ul li').removeClass('active')
                $(this).addClass('active')
                let classList = $(this).attr('class').split(/\s+/)
                switch (classList[0]) {
                    case 'default':
                        $('.profile-box .box-page').removeClass('active').hide()
                        $('.profile-box .box-page.default').addClass('active').show()
                        break;
                    case 'friends':
                        $('.profile-box .box-page').removeClass('active').hide()
                        $('.profile-box .box-page.friends').addClass('active').show()
                        break;
                    case 'topics':
                        $('.profile-box .box-page').removeClass('active').hide()
                        $('.profile-box .box-page.topics').addClass('active').show()
                        break;
                    default:
                        break;
                }
            })
        }
    },

    userFriendRequestsAction() {
        let thisAwesome = this
        if (this.urlArray[1] == 'profile' && this.urlArray[3] == 'friendRequests') {
            $('table.table-hover tbody tr td button').on('click', function () {
                let button = $(this)
                if (button.hasClass('accept') || button.hasClass('decline')) {
                    let tr = button.parent().parent();
                    let id = Number(tr.find('th[scope="row"]').html())

                    $.ajax({
                        url: thisAwesome.url,
                        method: 'POST',
                        dataType: 'JSON',
                        data: {
                            id,
                            decision: button.hasClass('accept') ? 'Y' : 'N'
                        },
                        success: function (response) {
                            if (response.success) {
                                tr.fadeOut('fast', function () {
                                    $(this).remove()
                                })
                                iziToast.show({
                                    title: response.title,
                                    icon: 'fas fa-check',
                                    progressBarColor: 'rgba(68, 189, 50, 1.0)',
                                    message: response.msg
                                })
                            } else {
                                iziToast.show({
                                    title: response.title,
                                    icon: 'fas fa-times',
                                    progressBarColor: 'rgba(255, 94, 87,1.0)',
                                    message: response.msg
                                })
                            }
                        },
                        error: a => console.log(a)
                    })
                } else {
                    return false;
                }
            })
        }
    },

    tinyMCEEditor() {
        tinymce.init({
            selector: '#text_editor_textarea',
            height: 435,
            branding: false,
            relative_urls: true,
            resize: false,
            theme: 'silver',
            default_link_target: "_blank",
            plugins: ['table advlist autolink lists link image charmap preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table',
            toolbar2: 'preview media | forecolor backcolor emoticons | codesample',
            image_advtab: true,
            templates: [{
                title: 'Test template 1',
                content: 'Test 1'
            }, {
                title: 'Test template 2',
                content: 'Test 2'
            }],
            content_css: ['https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i']
        });
    },

    topicReaction() {
        const thisClass = this

        $('.topic-actions button.reaction').on('click', function() {
            if(!thisClass.userLogged) {
                thisClass.alerts(_langs.register_to_react, 'error')
            } else {
                if(!thisClass.delayReactionPost) {
                    $.ajax({
                        url: 'topics/reaction',
                        dataType: 'JSON',
                        method: 'POST',
                        data: {
                            type: $(this)[0].classList[1],
                            topic: Number(thisClass.urlArray[2])
                        },
                        beforeSend: () => {
                            thisClass.delayReactionPost = true;
                        },
                        success: (response) => {
                            if(response.success) {
                                thisClass.alerts(response.msg, 'success', response.title)

                                const span = $(this).find('span')
                                span.html(Number(span.html() + 1))
                            } else {
                                thisClass.alerts(response.msg, 'error', response.title)
                            }

                            setTimeout(() => thisClass.delayReactionPost = false, 5000)
                        },
                        error: (error) => {
                            thisClass.alerts(_langs.error_ajax, "error")
                            setTimeout(() => thisClass.delayReactionPost = false, 5000)
                        }
                    })
                }
            }
        })
    },

    alerts(msg, type, title = '') {
        if (type === 'success') {
            title = 'Yeah'
            iziToast.show({
                title: title,
                icon: 'fas fa-check',
                progressBarColor: 'rgba(68, 189, 50, 1.0)',
                message: msg
            })
        } else if (type === 'error') {
            title = 'Oops'
            iziToast.show({
                title: title,
                icon: 'fas fa-times',
                progressBarColor: 'rgba(255, 94, 87,1.0)',
                message: msg
            })
        }
    }
}

$(document).ready(() => {
    Community.init()
})