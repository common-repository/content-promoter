class CTPR_Wizard {
    constructor() {
        this.nextID = 1;
        
        this.init();
    }

    init() {
        this.initWPEditors();
        
        this.setAutosizePromotingItemTitles();
        
        this.calculateNextID();

        this.initializePromotingItemsVisibility();

        this.initializeSavedPage();

        this.initItemsSelector();
        
        this.handleStepClickEvent();

        this.handleItemToggle();

        this.handleItemTypeChange();

        this.handleItemTypeButton();

        this.handlePublishItemTypeChange();

        this.handleFirstLastCheckboxOrdering();

        this.handleNavigationOfNavigator();

        this.handleSettingsModeSelector();

        this.handleCopyToClipboard();

        this.initializeDragManager();
    }

    initializeDragManager() {
        // drag manager
        const opts = {
            draggable_item: '.ctpr-move-promoting-item',
            draggable_container: '.ctpr-promoting-items-wrapper'
        };
        this.dragManager = new CTPR_DragManager(this, opts);
        this.dragManager.init();
    }

    handleFirstLastCheckboxOrdering() {
        // assign first item at the start
        if (document.querySelector('.ctpr-set-first-item-appear-at-start')) {
            document.querySelector('.ctpr-set-first-item-appear-at-start').addEventListener('change', function(evt) {
                let items = document.querySelectorAll('.ctpr-previewer .promoting-item:not(.last-bottom)');

                if (items.length == 0 || (items.length == 1 && items[0].classList.contains('last-bottom'))) {
                    return false;
                }

                let value = evt.target.checked;

                if (value) {
                    items[0].classList.add('first-top');
                } else {
                    document.querySelectorAll('.ctpr-previewer .promoting-item.first-top').forEach(element => {
                        element.classList.remove('first-top'); 
                    });

                    // if last-bottom is checked and we have 1 item then make the item have `last-bottom` class
                    if (items.length == 1 && this.isLastCheckboxInSelectionChecked()) {
                        items[0].classList.add('last-bottom');
                    }
                }
            }.bind(this));
        }

        // assign last item at the end
        if (document.querySelector('.ctpr-set-last-item-appear-at-end')) {
            document.querySelector('.ctpr-set-last-item-appear-at-end').addEventListener('change', function(evt) {
                let items = document.querySelectorAll('.ctpr-previewer .promoting-item:not(.first-top)');

                if (items.length == 0 || (items.length == 1 && items[0].classList.contains('first-top'))) {
                    return false;
                }

                let value = evt.target.checked;

                if (value) {
                    items[items.length - 1].classList.add('last-bottom');
                } else {
                    document.querySelectorAll('.ctpr-previewer .promoting-item.last-bottom').forEach(element => {
                        element.classList.remove('last-bottom'); 
                    });
                    
                    // if first-top is checked and we have 1 item then make the item have `first-top` class
                    if (items.length == 1 && this.isFirstCheckboxInSelectionChecked()) {
                        items[0].classList.add('first-top');
                    }
                }
            }.bind(this));
        }
    }

    handleSettingsModeSelector() {
        let modeSelector = document.querySelectorAll('.ctpr-publish-settings-mode-selector');
        if (modeSelector) {
            let replacementElementSelector = document.querySelector('.ctpr-publish-settings-replacement-element');
            if (replacementElementSelector) {
                modeSelector.forEach(elem => {
                    elem.addEventListener('change', function(evt) {
                        if (evt.target.value == 'auto') {
                            replacementElementSelector.classList.remove('ctpr-field-hidden');
                        } else {
                            replacementElementSelector.classList.add('ctpr-field-hidden');
                        }
                    });
                });
            }
        }
    }

    handleCopyToClipboard() {
        document.addEventListener('click', function(evt) {
            let btn = evt.target.closest('.ctpr-copy-to-clipboard');
            if (btn) {
                let content = btn.querySelector('.smart-tag').innerHTML;
                
                this.copyTextToClipboard(content);

                // update tooltip text
                let tooltipText = btn.querySelector('.ctpr-tooltiptext');
                let currentTooltipText = tooltipText.innerHTML;
                tooltipText.innerHTML = ctpr_js_object.SMART_TAG_COPIED_TO_CLIPBOARD;
                setTimeout(function(){
                    tooltipText.innerHTML = currentTooltipText;
                }, 1500);
                
                evt.preventDefault();
            }
        }.bind(this));
    }

    initWPEditors() {
        let editors = document.querySelectorAll('.ctpr-wpeditor-area');
        editors.forEach(editor => {
            const id = editor.getAttribute('id');
            
            this.initWPEditor(id);
        });
    }

    handlePublishItemTypeChange() {
        document.addEventListener('change', function(evt) {
            if (evt.target.classList.contains('ctpr-publish-settings-item-type-selector')) {

                let value = evt.target.value;

                let parentItem = evt.target.closest('.ctpr-publish-settings-item');

                if (value == 'include') {
                    parentItem.classList.remove('exclude');
                    parentItem.classList.add('include');
                } else if (value == 'exclude') {
                    parentItem.classList.remove('include');
                    parentItem.classList.add('exclude');
                } else {
                    parentItem.classList.remove('include');
                    parentItem.classList.remove('exclude');
                }
                
                evt.preventDefault();
            }
        }.bind(this));
    }

    setAutosizePromotingItemTitles() {
        const titles = document.querySelectorAll('.ctpr-configure-screen .ctpr-promoting-item-editor:not(.template) .ctpr-item-title');
        if (titles) {
            var delay = (function(){
                var timer = 0;
                return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            titles.forEach(element => {
                if (element.classList.contains('autosize-init')) {
                    return;
                }
                
                element.classList.add('autosize-init')
                
                autosizeInput(element);

                // update the text of promoting items within navigator
                element.addEventListener('keyup', function(evt) {
                    delay(function(){
                        // get which promoting item's title we are manipulating
                        let index = [].indexOf.call(evt.target.closest('.ctpr-promoting-items-wrapper').children, evt.target.closest('.ctpr-promoting-item-editor'));
                        
                        // try and get navigator item
                        let navigatorPromotingItem = document.querySelector('.ctpr-previewer-navigator .items').children[index];
                        if (navigatorPromotingItem) {
                            // update text of navigator item
                            navigatorPromotingItem.querySelector('.title').innerHTML = evt.target.value;
                        }
                        
                        // also try and update the previewers promoting item title
                        let previewerPromotingItems = document.querySelectorAll('.ctpr-previewer .promoting-item');
                        if (previewerPromotingItems) {
                            previewerPromotingItems[index].querySelector('.ctpr-sample-item-label').innerHTML = evt.target.value;
                        }
                    }, 150);
                });

                element.addEventListener('blur', function() {
                    if (!this.value) {
                        element.value = element.dataset.default_title;
                        element.dispatchEvent(new Event('change'));
                        element.dispatchEvent(new Event('input'));
                    }
                });
            });
        }
    }

    handleNavigationOfNavigator() {
        document.addEventListener('click', function(evt) {
            let previewerNavigatorItem = evt.target.closest('.ctpr-previewer-navigator-item');
            if (previewerNavigatorItem) {
                let index = [].indexOf.call(previewerNavigatorItem.closest('.items').children, previewerNavigatorItem.closest('.ctpr-previewer-navigator-item'));

                let promotingItems = document.querySelector('.ctpr-promoting-items-wrapper').children;
                
                if (promotingItems) {
                    let element = promotingItems[index];

                    if (element) {
                        let offset = element.getBoundingClientRect().top + window.pageYOffset - 50;

                        window.scrollTo({top: offset, behavior: 'smooth'});

                    }
                    evt.preventDefault();
                }
                
            }
        });
    }

    calculateNextID() {
        let items = document.querySelectorAll('.ctpr-configure-screen .ctpr-promoting-items-wrapper .ctpr-promoting-item-editor');
        if (items && items.length) {
            this.nextID = items.length;
        } else {
            this.nextID = 1;
        }
    }

    initItemsSelector() {
        let selector = document.querySelector('.ctpr-promoting-content-items-selector');

        if (!selector) {
            return;
        }

        selector.addEventListener('input', function(evt) {
            // set label
            let previwerItemsLabel = document.querySelector('.ctpr-promoting-content-items-number');
            previwerItemsLabel.innerHTML = evt.target.value;

            this.resetPromotingItemClasses();

            this.setTotalPromotingItemsToConfigure(evt.target.value);

            this.updatePreviwerItemsBasedOnSelectionCheckboxes();

            this.updatePreviewer(evt.target.value);
        }.bind(this));
    }

    updatePreviwerItemsBasedOnSelectionCheckboxes() {
        let items = document.querySelectorAll('.ctpr-previewer .promoting-item');
        
        if (this.isFirstCheckboxInSelectionChecked()) {
            items[0].classList.add('first-top');
        }

        if (this.isLastCheckboxInSelectionChecked()) {
            if (items.length > 1) {
                items[items.length - 1].classList.add('last-bottom');
            }
        }
    }

    isFirstCheckboxInSelectionChecked() {
        if (!document.querySelector('.ctpr-set-first-item-appear-at-start')) {
            return false;
        }

        return document.querySelector('.ctpr-set-first-item-appear-at-start').checked;
    }

    isLastCheckboxInSelectionChecked() {
        if (!document.querySelector('.ctpr-set-last-item-appear-at-end')) {
            return false;
        }

        return document.querySelector('.ctpr-set-last-item-appear-at-end').checked;
    }

    resetPromotingItemClasses() {
        let items = document.querySelectorAll('.ctpr-previewer .promoting-item');
        items.forEach(element => {
            element.classList.remove('first-top');
            element.classList.remove('last-bottom');
        });
    }

    handleItemTypeChange() {
        document.addEventListener('click', function(evt) {
            let btn = evt.target.closest('.ctpr-change-type-promoting-item');
            if (btn) {
                let parent = btn.closest('.ctpr-promoting-item-editor');
                let promotingItem = this.findPromotingItem(parent);

                if (btn.classList.contains('is-active')) {
                    btn.classList.remove('is-active');
                    parent.querySelector('.body .content').classList.remove('is-hidden');

                    // check if the body is empty, then make the item inactive
                    if (parent.querySelector('.body .content').innerHTML.trim() == '') {
                        parent.classList.remove('is-active');

                        // make the arrow down
                        promotingItem.classList.add('dashicons-arrow-down-alt2');
                        promotingItem.classList.remove('dashicons-arrow-up-alt2');
                    }

                    parent.querySelector('.body > .ctpr-content-chooser').classList.remove('is-visible');
                } else {
                    btn.classList.add('is-active');

                    if (!parent.classList.contains('is-active')) {
                        parent.classList.add('is-active');
                    }

                    if (promotingItem.classList.contains('dashicons-arrow-down-alt2')) {
                        // make the arrow up
                        promotingItem.classList.add('dashicons-arrow-up-alt2');
                        promotingItem.classList.remove('dashicons-arrow-down-alt2');
                    }

                    parent.querySelector('.body .content').classList.add('is-hidden');
                    parent.querySelector('.body > .ctpr-content-chooser').classList.add('is-visible');
                }

                evt.preventDefault();
            }
        }.bind(this));
    }

    findPromotingItem(elem) {
        const cls = '.ctpr-toggle-promoting-item';
        
        if (elem.closest(cls)) {
            return elem.closest(cls);
        } else {
            return elem.querySelector(cls);
        }
    }

    findPromotingItemEditor(elem) {
        const cls = '.ctpr-promoting-item-editor';

        if (elem.closest(cls)) {
            return elem.closest(cls);
        } else {
            return elem.querySelector(cls);
        }
    }

    handleItemTypeButton() {
        document.addEventListener('click', function(evt) {
            let btn = evt.target.closest('.item:not(.pro)');
            if (btn && btn.closest('.ctpr-content-chooser')) {
                btn.classList.add('disabled');

                const type = btn.getAttribute('data-type');

                // ContentChooser Field: set field type if it exists
                let hiddenTypeField = btn.closest('.ctpr-content-chooser-field');
                if (hiddenTypeField) {
                    hiddenTypeField.querySelector('input[type="hidden"]').value = type;
                }

                let parentItem = btn.closest('.ctpr-promoting-item-editor');

                const self = this;
                
                this.showConfigureLoader(btn);

                const typeID = parentItem.querySelector('input[type="hidden"].item_type').getAttribute('data-id') || 1;
                
                // data
                let data = new FormData();
                data.append('nonce', ctpr_js_object.nonce);
                data.append('action', 'ctpr_type_change');
                data.append('type', type);
                data.append('item_id', typeID);

                fetch(ctpr_js_object.ajax_url,
                {
                    method: 'POST',
                    body: data,
                })
                .then(function(response) {
                    btn.classList.remove('disabled');

                    self.hideConfigureLoader(btn);

                    return response.json();
                })
                .then(function(response) {
                    if (response.error) {
                        alert(response.data);
                        return;
                    }

                    // remove active class from previously active item
                    if (parentItem.querySelector('.ctpr-content-chooser .item.is-active')) {
                        parentItem.querySelector('.ctpr-content-chooser .item.is-active').classList.remove('is-active');
                    }
                    // make current button active
                    btn.classList.add('is-active');

                    self.hidePromotingItemTypeChooser(btn);
                    self.updatePromotingItemBody(btn, response.data);

                    self.updatePromotingItemType(type, typeID);

                    // set new color pickers
                    new CTPR_Colorpicker();
                })
                .catch(function (error) {
                    console.log(error);
                });

                evt.preventDefault();
            }
        }.bind(this));
    }

    hidePromotingItemTypeChooser(elem) {
        let item = elem.closest('.ctpr-promoting-item-editor');

        item.querySelector('.body > .ctpr-content-chooser').classList.remove('is-visible');
        item.querySelector('.ctpr-change-type-promoting-item').classList.remove('is-active');
    }

    updatePromotingItemBody(elem, data) {
        let item = elem.closest('.ctpr-promoting-item-editor');
        item.querySelector('.body .content').innerHTML = data;
        item.querySelector('.body .content').classList.remove('is-hidden');

        this.fixNames(item);
        
        // make the arrow up
        this.findPromotingItem(item).classList.add('dashicons-arrow-up-alt2');
        this.findPromotingItem(item).classList.remove('dashicons-arrow-down-alt2');
    }

    fixNames(item) {
        // change name attribute
        item.querySelectorAll('[name]').forEach(element => {
            let nameAttr = element.getAttribute('name');
            nameAttr = nameAttr.replace('[ITEM_ID]', '[' + this.nextID + ']');
            element.setAttribute('name', nameAttr);
        });
    }

    updatePromotingItemType(type, id) {
        let item = document.querySelector('input[type="hidden"].item_type[data-id="' + id + '"]').closest('.ctpr-promoting-item-editor');

        if (!item) {
            return;
        }
        
        item.querySelector('input[type="hidden"].item_type').value = type;
        item.querySelector('input[type="hidden"].item_type').setAttribute('data-id', id);

        // initialize the WP Editor
        if (type == 'Text') {
            let textarea = item.querySelector('.ctpr-wpeditor-area');
            let id = textarea.getAttribute('id');

            this.initWPEditor(id);
        }
    }

    initWPEditor(id) {
        let editor = document.querySelector('#' + id);
        let editorSettings = JSON.parse(editor.getAttribute('data-tinymce-configs'));
        
        wp.editor.remove(id);
        wp.editor.initialize(id, editorSettings);
    }

    showConfigureLoader(elem) {
        let loading = elem.closest('.ctpr-promoting-item-editor').querySelector('.ctpr-item-loader');
        loading.classList.add('is-active');
    }

    hideConfigureLoader(elem) {
        let loading = elem.closest('.ctpr-promoting-item-editor').querySelector('.ctpr-item-loader');
        loading.classList.remove('is-active');
    }

    updatePreviewer(total) {
        total = parseInt(total);

        let previewer = document.querySelector('.ctpr-previewer');

        // remove current templates
        previewer.querySelectorAll('.promoting-item').forEach(element => {
            element.remove();
        });

        // get total elements
        const totalElements = previewer.querySelectorAll('.item').length;

        let pos = Math.round(totalElements / (total + 1));
        const firstPos = pos;

        for (let i=1; i<=total; i++) {
            let node = previewer.querySelector('.item:nth-child(' + pos + ')');
            if (!node) {
                break;
            }
            let ele = document.querySelector('.promoting-item-template').cloneNode(true);
            ele.querySelector('.cptr-sample-promoting-item-number').innerHTML = i;
            ele.classList.remove('promoting-item-template');
            
            node.parentNode.insertBefore(ele, node.nextSibling);

            pos += firstPos;
        }

        // re-set the titles on each previewer promoting item
        previewer = document.querySelector('.ctpr-previewer');
        let promoting_items = document.querySelectorAll('.ctpr-promoting-item-editor:not(.template)');
        let index = 0;
        previewer.querySelectorAll('.promoting-item').forEach(element => {
            if (!promoting_items[index] || !element.querySelector('.ctpr-sample-item-label')) {
                return;
            }

            element.querySelector('.ctpr-sample-item-label').innerHTML = promoting_items[index].querySelector('.ctpr-item-title').value;
            index++;
        });
    }

    setTotalPromotingItemsToConfigure(total) {
        let configureScreen = document.querySelector('.ctpr-configure-screen');

        let currentTotalItems = configureScreen.querySelectorAll('.ctpr-promoting-items-wrapper .ctpr-promoting-item-editor');
        let previewerNavigatorTotalItems = document.querySelectorAll('.ctpr-previewer-navigator .items .ctpr-previewer-navigator-item');

        if (currentTotalItems.length > total) {
            // removing item
            const toBeRemovedItems = currentTotalItems.length - total;

            let pos = 0;
            for (let i = 0; i < toBeRemovedItems; i++) {
                if (currentTotalItems[currentTotalItems.length - 1 - pos]) {
                    currentTotalItems[currentTotalItems.length - 1 - pos].remove();
                }

                if (previewerNavigatorTotalItems[currentTotalItems.length - 1 - pos]) {
                    previewerNavigatorTotalItems[currentTotalItems.length - 1 - pos].remove();
                }
                pos++;
            }
        } else {
            this.nextID = this.nextID + 1;

            // adding item
            let template = configureScreen.querySelector('.ctpr-promoting-item-editor.template').cloneNode(true);
            template.classList.remove('template');

            // set item ID used by drag manager
            template.setAttribute('data-item-id', this.nextID);

            // set counter
            template.querySelector('.number span').innerHTML = total;

            // update item title ITEM_ID
            let itemTitleName = template.querySelector('.top .ctpr-item-title').getAttribute('name');
            itemTitleName = itemTitleName.replace('[ITEM_ID]', '[' + this.nextID + ']');
            template.querySelector('.top .ctpr-item-title').setAttribute('name', itemTitleName);

            // update item type ITEM_ID
            let itemTypeName = template.querySelector('.item_type').getAttribute('name');
            itemTypeName = itemTypeName.replace('[ITEM_ID]', '[' + this.nextID + ']');
            template.querySelector('.item_type').setAttribute('name', itemTypeName);
            template.querySelector('.item_type').setAttribute('data-id', this.nextID);
    
            let items = configureScreen.querySelector('.ctpr-promoting-items-wrapper');

            items.appendChild(template);

            // append the previewer navigaor item
            let clonePreviewerNavigatorItem = document.querySelector('.ctpr-previewer-navigator-item.template').cloneNode(true);
            clonePreviewerNavigatorItem.classList.remove('template');
            document.querySelector('.ctpr-previewer-navigator .items').appendChild(clonePreviewerNavigatorItem);

            // se auto size on new promoting item title
            this.setAutosizePromotingItemTitles();
        }
    }

    handleStepClickEvent() {
        document.addEventListener('click', function(evt) {
            let btn = evt.target;
            if (btn.classList.contains('step-button') && !btn.classList.contains('save-button')) {
                let nextPage = btn.getAttribute('data-page');
                let button_position = btn.getAttribute('data-button');

                this.showPage(button_position, nextPage);

                evt.preventDefault();
            }
        }.bind(this));
    }

    hideCurrentPageAndRelatives() {
        document.querySelector('.ctpr-wizard .wizard-pages .page.is-active').classList.remove('is-active');
        document.querySelector('.ctpr-wizard .wizard-nav li.is-active').classList.remove('is-active');
    }

    showPage(button_position, nextPage, direct) {
        this.swapRequiredSelectionPageItems(button_position, nextPage, direct);

        this.hideCurrentPageAndRelatives();

        // show page
        document.querySelector('.ctpr-wizard .wizard-pages .page[data-page="' + nextPage + '"]').classList.add('is-active');

        // set nav
        document.querySelector('.ctpr-wizard .wizard-nav li[data-page="' + nextPage + '"]').classList.add('is-active');

        // save which page we have selected so we always re-appear on this page
        this.saveSelectedPage(nextPage);

        this.afterPageAppears(nextPage);
    }

    saveSelectedPage(page) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const post_id = urlParams.get('post');

        if (!post_id) {
            return;
        }
        
        if (!page) {
            return;
        }

        const localStorateKey = 'ctpr_' + post_id + '_current_page';

        localStorage.setItem(localStorateKey, page);
    }

    initializeSavedPage() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const post_id = urlParams.get('post');

        if (!post_id) {
            return;
        }

        const localStorateKey = 'ctpr_' + post_id + '_current_page';

        let savedPage = localStorage.getItem(localStorateKey) || false;

        if (!savedPage) {
            return;
        }

        this.showPage('next', savedPage, true);
    }

    afterPageAppears(nextPage) {
        let previewer_navigator = document.querySelector('.ctpr-previewer-navigator');

        let second_btn = this.getWizardActions().querySelector('button[data-button="next"]');

        if (nextPage == 'configure') {
            if (previewer_navigator) {
                previewer_navigator.classList.add('is-visible');
            }
        } else {
            if (previewer_navigator) {
                previewer_navigator.classList.remove('is-visible');
            }
        }

        // run specific action if we click on publish settings
        if (nextPage == 'publish') {
            // make the "Save" button save the Promoting Content, same as "Update" on the right sidebar

            second_btn.setAttribute('name', 'save');
            second_btn.setAttribute('value', 'update');
            second_btn.setAttribute('type', 'submit');
            second_btn.classList.add('save-button');
        } else {
            second_btn.removeAttribute('name');
            second_btn.removeAttribute('value');
            second_btn.removeAttribute('type');
            second_btn.classList.remove('save-button');
        }
    }

    getWizardActions() {
        return document.querySelector('.ctpr-wizard .wizard-actions');
    }

    swapRequiredSelectionPageItems(button_position, nextPage, direct) {
        // if we are on the first page, set button position to previous page in order to get valid page data
        if (direct && nextPage == 'selection') {
            button_position = 'prev';
        }
        
        let data = this.getNewPageData(button_position, nextPage);

        if (!data) {
            return;
        }

        // if we are calling this function directly, we know which are the prev and next button
        if (direct) {
            // if we are not on selection page, set the prev button as selection
            if (nextPage != 'selection') {
                data.prevButtonSelector = 'selection';
            }
            data.nextButtonSelector = 'configure';
        }

        let leftButton = document.querySelector('.ctpr-wizard .wizard-actions .step-button[data-page="' + data.prevButtonSelector + '"]');
        let rightButton = document.querySelector('.ctpr-wizard .wizard-actions .step-button[data-page="' + data.nextButtonSelector + '"]');

        leftButton.innerHTML = data.prevButton;
        leftButton.setAttribute('data-page', data.prevButtonAtt);
        if (data.prevButtonDisabled) {
            leftButton.classList.add('is-disabled');
        } else {
            leftButton.classList.remove('is-disabled');
        }

        rightButton.innerHTML = data.nextButton;
        rightButton.setAttribute('data-page', data.nextButtonAtt);
        if (data.nextButtonDisabled) {
            rightButton.classList.add('is-disabled');
        } else {
            rightButton.classList.remove('is-disabled');
        }
    }

    handleItemToggle() {
        document.addEventListener('click', function(evt) {
            if (evt.target.closest('.ctpr-toggle-promoting-item')) {
                let btn = evt.target;
                let item = this.findPromotingItemEditor(btn);

                let status = '';

                if (item.classList.contains('is-active')) {
                    status = 'hidden';

                    this.hidePromotingItem(item);
                } else {
                    status = 'show';
                    
                    this.showPromotingItem(item);
                }

                this.setPromotingItemVisibilityStatus(item, status);
                
                evt.preventDefault();
            }
        }.bind(this));
    }

    showPromotingItem(item) {
        let btn = item.querySelector('.ctpr-toggle-promoting-item');

        btn.classList.add('dashicons-arrow-up-alt2');
        btn.classList.remove('dashicons-arrow-down-alt2');
        item.classList.add('is-active');

        // if content is empty, show the type selector
        if (item.querySelector('.body .content').innerHTML.trim() == '') {
            item.querySelector('.ctpr-change-type-promoting-item').classList.add('is-active');
            item.querySelector('.body .content').classList.add('is-hidden');
            item.querySelector('.body > .ctpr-content-chooser').classList.add('is-visible');
        }
    }

    hidePromotingItem(item) {
        let btn = item.querySelector('.ctpr-toggle-promoting-item');

        item.classList.remove('is-active');
        btn.classList.remove('dashicons-arrow-up-alt2');
        btn.classList.add('dashicons-arrow-down-alt2');

        // make type selector inactive
        item.querySelector('.ctpr-change-type-promoting-item').classList.remove('is-active');
        item.querySelector('.body .content').classList.remove('is-hidden');
        item.querySelector('.body > .ctpr-content-chooser').classList.remove('is-visible');
    }

    setPromotingItemVisibilityStatus(promoting_item, status) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const post_id = urlParams.get('post');

        if (!post_id) {
            return;
        }
        
        let item_id = promoting_item.querySelector('input[type="hidden"].item_type').getAttribute('data-id');
        
        if (!item_id) {
            return;
        }

        const localStorateKey = 'ctpr_' + post_id + '_promoting_items';

        let items = JSON.parse(localStorage.getItem(localStorateKey)) || {};

        items[item_id] = status;

        localStorage.setItem(localStorateKey, JSON.stringify(items));
    }

    initializePromotingItemsVisibility() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const post_id = urlParams.get('post');

        if (!post_id) {
            return;
        }

        const localStorateKey = 'ctpr_' + post_id + '_promoting_items';

        let items = JSON.parse(localStorage.getItem(localStorateKey)) || {};

        if (!items) {
            return;
        }

        for (let item in items) {
            let id = item;
            let status = items[item];

            let promotingItem = document.querySelector('.ctpr-promoting-item-editor input[type="hidden"][data-id="' + id + '"]');
            if (!promotingItem) {
                continue;
            }

            promotingItem = promotingItem.closest('.ctpr-promoting-item-editor');

            if (status == 'show') {
                this.showPromotingItem(promotingItem);
            } else {
                this.hidePromotingItem(promotingItem);
            }
        }
    }

    getNewPageData(button, nextPage) {
        let data = [];

        data.prevButtonDisabled = false;
        data.nextButtonDisabled = false;

        if (button == 'next') {
            if (nextPage == 'configure') {
                data.prevButtonSelector = 'selection';
                data.prevButtonAtt = 'selection';
                data.prevButton = ctpr_js_object.SELECTION;

                data.nextButtonSelector = 'configure';
                data.nextButtonAtt = 'publish';
                data.nextButton = ctpr_js_object.PUBLISH_SETTINGS;
            } else if (nextPage == 'publish') {
                data.prevButtonSelector = 'selection';
                data.prevButtonAtt = 'configure';
                data.prevButton = ctpr_js_object.CONFIGURE;
                
                data.nextButtonSelector = 'publish';
                data.nextButtonAtt = 'publish';
                data.nextButton = ctpr_js_object.SAVE;
            }
        } else {
            if (nextPage == 'selection') {
                data.prevButtonSelector = 'selection';
                data.prevButtonAtt = 'selection';
                data.prevButton = ctpr_js_object.SELECTION;
                data.prevButtonDisabled = true;

                data.nextButtonSelector = 'publish';
                data.nextButtonAtt = 'configure';
                data.nextButton = ctpr_js_object.CONFIGURE;
            } else if (nextPage == 'configure') {
                data.prevButtonSelector = 'configure';
                data.prevButtonAtt = 'selection';
                data.prevButton = ctpr_js_object.SELECTION;

                data.nextButtonSelector = 'publish';
                data.nextButtonAtt = 'publish';
                data.nextButton = ctpr_js_object.PUBLISH_SETTINGS;
            }
        }

        return data;
    }

    getCurrentPage() {
        let activePage = document.querySelector('.ctpr-wizard .wizard-nav li.is-active');
        return activePage.getAttribute('data-page');
    }

    copyTextToClipboard(text) {
        if (window.clipboardData && window.clipboardData.setData) {
            // Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.
            return clipboardData.setData("Text", text);
        }
        else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in Microsoft Edge.
            document.body.appendChild(textarea);
            textarea.select();
            try {
                return document.execCommand("copy");  // Security exception may be thrown by some browsers.
            }
            catch (ex) {
                console.warn("Copy to clipboard failed.", ex);
                return false;
            }
            finally {
                document.body.removeChild(textarea);
            }
        }
    }
}