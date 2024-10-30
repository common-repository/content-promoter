class CTPR_Update_Notice {
    constructor() {
		this.load();
	}
	
	load() {
		// data
		const data = {
			action: 'ctpr_show_update_notice',
		};

		let query = Object.keys(data)
			.map(k => encodeURIComponent(k) + '=' + encodeURIComponent(data[k]))
			.join('&');

		// do ajax call
		fetch(ctpr_js_object.ajax_url + '?' + query)
		.then(function(response) {
			return response.json();
		})
		.then(function (data) {
			if (!data.html) {
				return;
			}

			var tmpElem = document.createElement("div");
			tmpElem.innerHTML = data.html;

			document.querySelector('.ctpr-page-content').insertBefore(tmpElem.firstChild, document.querySelector('.ctpr-page-content').firstChild);
		});
	}
}
document.addEventListener(
	'DOMContentLoaded',
	function(event) {
	new CTPR_Update_Notice();
});