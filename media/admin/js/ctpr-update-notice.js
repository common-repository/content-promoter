var CTPR_Update_Notice=function(){function t(){this.load()}return t.prototype.load=function(){var e={action:"ctpr_show_update_notice"},t=Object.keys(e).map(function(t){return encodeURIComponent(t)+"="+encodeURIComponent(e[t])}).join("&");fetch(ctpr_js_object.ajax_url+"?"+t).then(function(t){return t.json()}).then(function(t){if(t.html){var e=document.createElement("div");e.innerHTML=t.html,document.querySelector(".ctpr-page-content").insertBefore(e.firstChild,document.querySelector(".ctpr-page-content").firstChild)}})},t}();document.addEventListener("DOMContentLoaded",function(t){new CTPR_Update_Notice});
