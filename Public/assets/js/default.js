Community = {
    init() {
        this.tooltip()
    },

    tooltip() {
        $(document).tooltip({
            selector: '[data-toggle="tooltip"]',
            html: true
        });
    }
}

$(document).ready(() => {
    Community.init()
})