<script>
    /**
     * Formats an input value with thousands separators (commas)
     * Handles cursor positioning to prevent jumps during typing
     */
    function formatNumberInput(input, allowDecimal = true) {
        let cursor = input.selectionStart;
        let oldLen = input.value.length;

        let regex = allowDecimal ? /[^0-9.]/g : /[^0-9]/g;
        let value = input.value.replace(regex, '');

        let parts = value.split('.');
        if (parts.length > 2) parts = [parts[0], parts.slice(1).join('')];

        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        input.value = allowDecimal ? parts.join('.') : parts[0];

        let newLen = input.value.length;
        input.setSelectionRange(cursor + (newLen - oldLen), cursor + (newLen - oldLen));
    }

    /**
     * Strips commas from all inputs with 'comma-input' class within a form
     */
    function stripCommasBeforeSubmit(form) {
        form.querySelectorAll('.comma-input').forEach(i => {
            i.value = i.value.replace(/,/g, '');
        });
    }

    /**
     * Budget Manager Alpine.data component
     * Registered here to avoid regex and special chars breaking inline x-data HTML attributes
     */
    document.addEventListener('alpine:init', () => {
        Alpine.data('budgetManager', () => ({
            activeTab: sessionStorage.getItem('budget_active_tab_{{ $project->id ?? "global" }}') || 'summary',
            showLogModal: false,
            showLaborModal: false,
            showExpenseModal: false,
            
            init() {
                this.$watch('activeTab', value => {
                    sessionStorage.setItem('budget_active_tab_{{ $project->id ?? "global" }}', value);
                });
            },
            showEditModal: false,
            editItem: { id: null, type: '', data: {}, url: '' },
            originalItem: null,

            isDirty() {
                if (!this.originalItem) return false;
                return JSON.stringify(this.editItem.data) !== this.originalItem;
            },

            formatWithCommas(value) {
                if (!value && value !== 0) return '';
                // Remove trailing zeros by parsing and converting back to string
                let valStr = parseFloat(value).toString();
                let parts = valStr.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return parts.join('.');
            },

            openEdit(type, item) {
                this.editItem.type = type;
                this.editItem.id = item.id;
                this.editItem.data = JSON.parse(JSON.stringify(item));

                // Format numeric values for display with commas
                if (this.editItem.data.unit_price_at_time) {
                    this.editItem.data.unit_price_at_time = this.formatWithCommas(this.editItem.data.unit_price_at_time);
                }
                if (this.editItem.data.amount) {
                    this.editItem.data.amount = this.formatWithCommas(this.editItem.data.amount);
                }
                if (this.editItem.data.quantity) {
                    this.editItem.data.quantity = this.formatWithCommas(this.editItem.data.quantity);
                }

                // Fallback for material name/unit from relation
                if (type === 'material' && item.material) {
                    if (!this.editItem.data.custom_material_name) {
                        this.editItem.data.custom_material_name = item.material.name;
                    }
                    if (!this.editItem.data.custom_unit) {
                        this.editItem.data.custom_unit = item.material.unit;
                    }
                }

                // Format dates to YYYY-MM-DD for HTML date inputs
                if (this.editItem.data.cost_date) {
                    this.editItem.data.cost_date = new Date(this.editItem.data.cost_date).toISOString().split('T')[0];
                }
                if (this.editItem.data.labor_date) {
                    this.editItem.data.labor_date = new Date(this.editItem.data.labor_date).toISOString().split('T')[0];
                }
                if (this.editItem.data.expense_date) {
                    this.editItem.data.expense_date = new Date(this.editItem.data.expense_date).toISOString().split('T')[0];
                }

                this.editItem.url = type === 'material'
                    ? `/admin/costs/${item.id}`
                    : (type === 'labor' ? `/admin/labors/${item.id}` : `/admin/expenses/${item.id}`);

                this.originalItem = JSON.stringify(this.editItem.data);
                this.showEditModal = true;
                this.$dispatch('open-modal', 'edit-log');
            }
        }));
    });
</script>
