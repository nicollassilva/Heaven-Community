Community = {
    init() {
        this.tooltip(),
        this.slidesCommunity(),
        this.minimizeCategorie()
    },

    tooltip() {
        $(document).tooltip({
            selector: '[data-toggle="tooltip"]',
            html: true
        });
        $('[data-toggle="popover"]').popover()
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
    }
}

$(document).ready(() => {
    Community.init()
})