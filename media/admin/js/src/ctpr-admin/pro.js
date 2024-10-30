class CTPR_Pro {
    constructor() {
        this.handleModalOpen();
        this.handleModalClose();
    }

    handleModalOpen() {
        document.addEventListener('click', function(evt) {
            let feature = evt.target.closest('[data-ctpr-pro-feature]');
            if (feature) {
                this.showPopup(feature.dataset.ctprProFeature);

                evt.preventDefault();
            }
        }.bind(this));
    }

    handleModalClose() {
        if (!document.querySelector('.ctpr-pro-modal-close')) {
            return;
        }
        
        document.querySelector('.ctpr-pro-modal-close').addEventListener('click', function(evt) {
            evt.target.closest('.ctpr-pro-modal-wrapper').classList.remove('is-visible');
            evt.preventDefault();
        });
    }

    showPopup(feature) {
        let popup = document.querySelector('.ctpr-pro-modal-wrapper');
        if (popup) {
            popup.querySelector('.feature-name').innerHTML = feature;
            popup.classList.add('is-visible');
        }
    }
}