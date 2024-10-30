class CTPR_ImageUploader{
	constructor() {
		this.init();
	}

	/**
	 * Inits Media Uploader events
	 * 
	 * @return  void
	 */
	init() {
		this.initAddButton();

		this.initRemoveButton();
	}

	/**
	 * Handles Add button event
	 * 
	 * @return  void
	 */
	initAddButton() {
		document.addEventListener('click', function(evt) {
			const addButton = evt.target.closest('.ctpr-image-upload-browse');

			if (addButton) {
				let custom_uploader = wp.media({
					title: 'Insert image',
					library : {
						type : 'image'
					},
					button: {
						text: 'Use this image'
					},
					multiple: false // for multiple image selection set to true
				}).on('select', function() { // it also has "open" and "close" events 
					// get attachment
					var attachment = custom_uploader.state().get('selection').first().toJSON();

					// get wrapper
					let wrapper = addButton.closest('.ctpr-image-upload-wrapper');
					
					// set hidden input value
					wrapper.querySelector('input[type="hidden"]').value = attachment.url;

					// show close button
					wrapper.querySelector('.ctpr-image-upload-reset').classList.add('is-visible');

					// show preview image
					wrapper.querySelector('.ctpr-image-upload-preview img').setAttribute('src', attachment.url);
					wrapper.querySelector('.ctpr-image-upload-preview').classList.add('is-visible');
				})
				.open();
				
				evt.preventDefault();
			}

		});
	}

	/**
	 * Handles Remove button event
	 * 
	 * @return  void
	 */
	initRemoveButton() {
		document.addEventListener('click', function(evt) {
			const addButton = evt.target.closest('.ctpr-image-upload-reset');

			if (addButton) {
				// get wrapper
				let wrapper = addButton.closest('.ctpr-image-upload-wrapper');

				// set hidden input value
				wrapper.querySelector('input[type="hidden"]').value = '';

				// hide close button
				wrapper.querySelector('.ctpr-image-upload-reset').classList.remove('is-visible');
			
				// hide preview image
				wrapper.querySelector('.ctpr-image-upload-preview img').setAttribute('src', '');
				wrapper.querySelector('.ctpr-image-upload-preview').classList.remove('is-visible');
				
				evt.preventDefault();
			}
		});
	}
}