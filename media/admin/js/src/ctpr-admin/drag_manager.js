class CTPR_DragManager {
    constructor(wizard, opts) {
        this.wizard = wizard;

        // draggable item
        this.draggable_item = opts.draggable_item;

        // draggable item container
        this.draggable_container = opts.draggable_container;
    }

    init() {
        if (!this.canRun()) {
            return;
        }

        const self = this;
        
        new Sortable(document.querySelector(this.draggable_container), {
            animation: 150,
            handle: this.draggable_item,
            onEnd: function (e) {
                const total = document.querySelectorAll('.ctpr-promoting-item-editor:not(.template)').length;
                self.wizard.updatePreviewer(total);
            }
        });
    }

    canRun() {
        if (!document.querySelector(this.draggable_container)) {
            return false;
        }

        return true;
    }
}