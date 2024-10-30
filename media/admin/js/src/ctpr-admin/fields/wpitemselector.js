class CTPR_WPItemSelector {
    constructor() {
        // item wrapper
        this.wrapper = '.ctpr-wp-item-selector-wrapper';
        
        // selector input class
        this.inputClass = 'ctpr-wp-item-selector-input';

        this.resultsClass = '.ctpr-wp-item-selector-results';
        
        this.init();
    }

    init() {
        this.setInputEventListener();

        this.setupResultsClose();

        this.setupResultsItemEventListener();

        this.setupResultsItemRemoveEventListener();
    }

    /**
     * Init event listener
     * 
     * @return  void
     */
    setInputEventListener() {
        const self = this;

        let delay = (function(){
            let timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
        
        document.addEventListener('keyup', function(evt) {
            if (evt.target.classList.contains(this.inputClass)) {
                delay(function(){
                    let input = evt.target;

                    let type = input.getAttribute('data-type');
                    
                    self.searchForData(input, type);
                }, 350);
            }
        }.bind(this));
    }

    setupResultsItemEventListener() {
        document.addEventListener('click', function(evt) {
            if (evt.target.closest(this.resultsClass)) {
                let item = evt.target.closest('.item');

                if (!item) {
                    return false;
                }

                let id = item.getAttribute('data-id');
                if (id) {
                    // append result item to list of selected items
                    let selectedResult = item.cloneNode(true);
                    let selectedItems = evt.target.closest(this.wrapper).querySelector('.selected-items');
                    selectedItems.appendChild(selectedResult);
                    selectedItems.classList.add('is-visible');

                    // reset input field
                    evt.target.closest(this.wrapper).querySelector('.' + this.inputClass).value = '';
                    
                    // hide results
                    this.emptyAndHideResults();

                    evt.preventDefault();
                }
            }
        }.bind(this));
    }

    setupResultsItemRemoveEventListener() {
        document.addEventListener('click', function(evt) {
            if (evt.target.closest('.ctpr-wp-item-selector-remove-selected-item')) {
                // check if results items div is empty to hide it
                let selectedItems = evt.target.closest(this.wrapper).querySelector('.selected-items');

                evt.target.closest('.item').remove();
                
                if (selectedItems.innerHTML.trim() == '') {
                    selectedItems.classList.remove('is-visible');
                }

                evt.preventDefault();
            }
        }.bind(this));
    }
    
    setupResultsClose() {
        document.addEventListener('click', function(evt) {
            if (!evt.target.closest(this.resultsClass)) {
                this.emptyAndHideResults();
            }
        }.bind(this));
    }

    emptyAndHideResults() {
        document.querySelectorAll(this.resultsClass).forEach(res => {
            res.innerHTML = '';
            res.classList.remove('is-visible');
        });
    }

    /**
     * Search for wp item based on type and query
     * 
     * @param   {HTMLElement} input 
     * @param   {String} type 
     * 
     * @return  void
     */
    searchForData(input, type) {
        const self = this;
        
        input.classList.add('disabled');
        
        self.showLoader(input);

        const name = input.getAttribute('data-name');

        const no_ids = this.findAlreadySelectedItems(input);
        
        // data
        let data = new FormData();
        data.append('nonce', ctpr_js_object.nonce);
        data.append('action', 'ctpr_get_wp_item_selector_data');
        data.append('name', name);
        data.append('type', type);
        data.append('q', input.value);
        data.append('no_ids', no_ids);

        fetch(ctpr_js_object.ajax_url,
        {
            method: 'POST',
            body: data,
        })
        .then(function(response) {
            input.classList.remove('disabled');

            self.hideLoader(input);

            return response.json();
        })
        .then(function(response) {
            let results = input.closest(self.wrapper).querySelector(self.resultsClass);
            results.innerHTML = response.data;
            results.classList.add('is-visible');
        })
        .catch(function (error) {
            console.log(error);
        });
    }

    findAlreadySelectedItems(input) {
        let selectedItems = input.closest(this.wrapper).querySelectorAll('.selected-items.is-visible .item');

        let no_ids = [];

        selectedItems.forEach(element => {
            const id = element.querySelector('input[type="hidden"]').value;
            no_ids.push(id);
        });

        return no_ids;
    }

    showLoader(input) {
        input.closest(this.wrapper).querySelector('.ctpr-item-loader').classList.add('is-active');
    }

    hideLoader(input) {
        input.closest(this.wrapper).querySelector('.ctpr-item-loader').classList.remove('is-active');
    }
}