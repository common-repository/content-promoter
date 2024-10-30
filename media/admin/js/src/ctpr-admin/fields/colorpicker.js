class CTPR_Colorpicker {
    constructor() {
        this.init();
    }

    init() {
        let colorPickers = document.querySelectorAll('.ctpr-color-picker-input:not(.rendered)');

        colorPickers.forEach(element => {
            jQuery(element).wpColorPicker();
            element.classList.add('rendered');
        });
    }
}