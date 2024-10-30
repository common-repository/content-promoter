class CTPR_TinyMCE_Editor_Button {
	constructor() {
		this.init();
	}

	init() {
		const i18n = wp.i18n;
		
		/**
         * Adds the Content Promoter TinyMCE button
         */
        tinymce.PluginManager.add('ctpr-tinymce-button', function( editor, url ) {
            editor.addButton( 'ctpr-tinymce-button', {
                title: i18n.__('Add a Content Promoter Smart Tag', 'content-promoter'),
                icon: 'ctpr-mce-icon dashicons dashicons-megaphone',
                onclick: function() {
                    editor.windowManager.open( {
                        title: i18n.__('Add a Content Promoter Smart Tag', 'content-promoter'),
                        body: [
                            {
                                type: 'label',
                                label: i18n.__('Adds the Smart Tag to this part of your post/page. This will be replaced by a Content Promoter > Promoting Content item.', 'content-promoter')
                            }
                        ],
                        onsubmit: function( e ) {
                            editor.insertContent('{{CTPR_PROMOTING_ITEM}}');
                        }
                    });
                }
            });
        });
	}
}
new CTPR_TinyMCE_Editor_Button();