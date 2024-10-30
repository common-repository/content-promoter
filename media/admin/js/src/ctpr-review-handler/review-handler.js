class CTPR_Review_Handler {
    constructor() {
        this.noticeElement = document.querySelector('.ctpr-review-reminder');
        if (!this.noticeElement) {
            return false;
        }
        
        this.handleRemindMeLaterBtn();

        this.handleIAlreadyDid();
    }

    handleRemindMeLaterBtn() {
        const self = this;

        document.querySelector('.ctpr-ask-later').addEventListener('click', function(evt) {
            // data
            let data = new FormData();
            data.append('_ajax_nonce', ctpr_js_object.nonce);
            data.append('action', 'ctpr_update_rate_reminder');
            data.append('update', 'ctpr_ask_later');

            
            // do ajax call
            fetch(ctpr_js_object.ajax_url, {
                method: 'POST',
                body: data,
            })
            .then(function(response) {
                return response.json();
            })
            .then(function (data) {
                if(!data.error) {
                    self.noticeElement.remove();
                } else {
                    console.log('Could not delete rate reminder. Error : ' + data.error_type);
                }
            })
            .finally(function() {

            });

            evt.preventDefault();
        });
    }

    handleIAlreadyDid() {
        const self = this;

        document.querySelector('.ctpr-delete-rate-reminder').addEventListener('click', function(evt) {
            // data
            let data = new FormData();
            data.append('_ajax_nonce', ctpr_js_object.nonce);
            data.append('action', 'ctpr_update_rate_reminder');
            data.append('update', 'ctpr_delete_rate_reminder');

            
            // do ajax call
            fetch(ctpr_js_object.ajax_url, {
                method: 'POST',
                body: data,
            })
            .then(function(response) {
                return response.json();
            })
            .then(function (data) {
                if(!data.error) {
                    self.noticeElement.remove();
                } else {
                    console.log('Could not delete rate reminder.');
                }
            })
            .finally(function() {

            });

            evt.preventDefault();
        });
    }
}
document.addEventListener(
	'DOMContentLoaded',
	function(event) {
	new CTPR_Review_Handler();
});