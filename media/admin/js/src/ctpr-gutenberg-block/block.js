document.addEventListener("DOMContentLoaded", function(){
	( function( blocks, editor, i18n, element ) {
		const smart_tag_value = '{{CTPR_PROMOTING_ITEM}}';
	
		blocks.registerBlockType( 'content-promoter/smart-tag', {
			title: i18n.__('Content Promoter Smart Tag', 'content-promoter'),
			icon: 'megaphone',
			category: 'design',
			edit: function() {
				const title = React.createElement(
					'h4',
					{
						className: 'title'
					},
					i18n.__('Content Promoter Smart Tag', 'content-promoter')
				);
				const description = React.createElement(
					'div',
					{
						className: 'description'
					},
					i18n.__('Adds the Smart Tag to this part of your post/page. This will be replaced by a Content Promoter > Promoting Content item.', 'content-promoter')
				);
				const smart_tag = React.createElement(
					'div',
					{
						className: 'smart-tag'
					},
					smart_tag_value
				);
				
				return React.createElement(
					'div',
					{
						className: 'ctpr-block-container'
					},
					title,
					description,
					smart_tag
				);
			},
			save: function() {
				return smart_tag_value;
			},
		} );
	}(
		window.wp.blocks,
		window.wp.editor,
		window.wp.i18n,
		window.wp.element
	) );
});