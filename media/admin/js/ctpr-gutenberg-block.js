document.addEventListener("DOMContentLoaded",function(){var t,n,r;t=window.wp.blocks,window.wp.editor,n=window.wp.i18n,window.wp.element,r="{{CTPR_PROMOTING_ITEM}}",t.registerBlockType("content-promoter/smart-tag",{title:n.__("Content Promoter Smart Tag","content-promoter"),icon:"megaphone",category:"design",edit:function(){var t=React.createElement("h4",{className:"title"},n.__("Content Promoter Smart Tag","content-promoter")),e=React.createElement("div",{className:"description"},n.__("Adds the Smart Tag to this part of your post/page. This will be replaced by a Content Promoter > Promoting Content item.","content-promoter")),o=React.createElement("div",{className:"smart-tag"},r);return React.createElement("div",{className:"ctpr-block-container"},t,e,o)},save:function(){return r}})});
