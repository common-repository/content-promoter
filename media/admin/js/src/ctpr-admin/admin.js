class CTPR_Admin {
    constructor() {
        this.wizard = new CTPR_Wizard();

        this.pro = new CTPR_Pro();

        this.image_uploader = new CTPR_ImageUploader();
        this.wp_item_selector = new CTPR_WPItemSelector();
        this.color_picker = new CTPR_Colorpicker();
    }
}

document.addEventListener("DOMContentLoaded", function(){
    new CTPR_Admin();
});