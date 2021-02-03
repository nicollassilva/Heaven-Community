Community = {
    init() {
        this.tooltip(),
        this.slidesCommunity()
    },

    tooltip() {
        $(document).tooltip({
            selector: '[data-toggle="tooltip"]',
            html: true
        });
    },

    slidesCommunity() {
        var swiperPartners = new Swiper('.general-box .general-right-column .partners .swiper-container', {
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
    }
}

$(document).ready(() => {
    Community.init()
})