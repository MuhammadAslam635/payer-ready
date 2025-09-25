@props([
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'label' => null,
    'triggerLabel' => null,
    'placeholder' => null,
    'searchable' => false,
    'multiple' => false,
    'clearable' => false,
    'disabled' => false,
    'icon' => null,
    'iconAfter' => 'chevron-up-down',
    'checkIcon' => 'check',
    'checkIconClass' => null,
    'invalid' => null,
    'triggerClass' => null,
])

<div
    x-data="{
        search: '',
        open: false,
        isTyping: false,
        // responsible for (like) combobox pattern https://www.w3.org/WAI/ARIA/apg/patterns/combobox/
        // it keeps focus on the input while navigating results
        activeIndex: null,
        options:[],
        filteredOptions:[],
        // more states
        isMultiple: @js($multiple),
        isDisabled: @js($disabled),
        isSearchable: @js($searchable),
        state: @js($multiple) ? [] : null,
        placeholder: @js($placeholder) ?? 'select ...',

        init() {
            this.$nextTick(() => {
                this.filteredOptions = this.options = Array
                    .from(this.$el.querySelectorAll('[data-slot=option]:not([hidden])'))
                    .map((option) => ({
                        value: option.dataset.value,
                        label: option.dataset.label,
                        element: option
                    }));
                // grab the initial x-model or wire:model value
                this.state = this.$root?._x_model?.get();
            });

            this.$watch('activeIndex',(val) => console.log(val))

            this.$watch('state', (value) => {
                // Sync back with Alpine state
                this.$root?._x_model?.set(value);

                // Sync back with Livewire state if any
                let wireModel = this?.$root.getAttributeNames().find(n => n.startsWith('wire:model'))

                if(this.$wire && wireModel){
                    let prop = this.$root.getAttribute(wireModel)
                    this.$wire.set(prop, value, wireModel?.includes('.live'));
                }
            });

           this.$watch('search', (val) => {
                // reset highlighted item whenever search text changes I don't like, you may so here it is comented
                // this.activeIndex = null;

                if (val.trim() === '') {
                    // empty search → restore full option list
                    // (important for accessibility keyboard navigation)
                    this.filteredOptions = this.options;
                } else {
                    // filter options by search query
                    this.filteredOptions = this.options.filter(option =>
                        option.label.toLowerCase().includes(val.toLowerCase().trim())
                    );
                }
            })

        },

        isSelected(option) {
            return this.isMultiple ? this.state?.includes(option) : this.state === option;
        },

        select(option) {
            this.isTyping = false;
            this.search = '';

            if (!this.isMultiple) {
                this.open = false;
                this.state = option;
                return;
            }

            if(!Array.isArray(this.state)){
                console.error('Multiple select requires an array value. Please bind an array property using x-model or wire:model.');
            }

            const itemIndex = this.state.findIndex(item => item === option);

            if (itemIndex === -1) {
                this.state.push(option);
            } else {
                this.state.splice(itemIndex, 1);
            }
        },

        clear() {
            this.state = this.isMultiple ? [] : '';
            this.open = false;
        },

        isItemShown(value) {
            if (!this.isSearchable || !this.isTyping) return true;
            const option = this.options.find(opt => opt.value === value);
            return option ? option.label.toLowerCase().includes(this.search.toLowerCase().trim()) : false;
        },

        close() {
            this.open = false;
            this.search = '';
            this.isTyping = false;
            this.activeIndex = null;
        },

        toggle() {

            if (this.isDisabled) return;

            this.open = !this.open;

            if((open && !this.hasSelection) && this.searchable){
                this.activeIndex = 0
            };
        },

        // A11y managment
        handleKeydown(event) {
            if (event.key === 'ArrowDown') {
                if (this.activeIndex === null || this.activeIndex >= this.filteredOptions.length - 1) {
                    this.activeIndex = 0;
                } else {
                    this.activeIndex++;
                }
            }

            if (event.key === 'ArrowUp') {
                if (this.activeIndex === null || this.activeIndex <= 0) {
                    this.activeIndex = this.filteredOptions.length - 1;
                } else {
                    this.activeIndex--;
                }
            }

            if (event.key === 'Enter' && this.activeIndex !== null) {
                let option = this.filteredOptions[this.activeIndex];
                this.select(option.value);
            }
        },

        // Get the filtered index for a given value
        getFilteredIndex(value) {
            return this.filteredOptions.findIndex(option => option.value === value);
        },

        // Handle mouse enter - find the index in filtered results
        handleMouseEnter(value) {
            this.activeIndex = this.getFilteredIndex(value);
        },

        // Check if item is focused based on its position in filtered results
        isFocused(value) {
            return this.activeIndex !== null && this.getFilteredIndex(value) === this.activeIndex;
        },

        get hasFilteredResults() {
            return this.filteredOptions.length > 0;
        },

        get label() {
            if (!this.hasSelection) return this.placeholder;

            if (!this.isMultiple) {
                // find the option object for the current state value
                const option = this.options.find(opt => opt.value === this.state);
                return option?.label ?? this.placeholder;
            }

            if (this.state.length === 1) {
                const option = this.options.find(opt => opt.value === this.state[0]);
                return option?.label ?? this.state[0];
            }

            return ` ${this.state.length} items selected`;
        },

        get hasSelection() {
            return this.isMultiple ? this.state?.length > 0 : this.state !== null;
        },
    }"
    {{ $attributes->class([
            'relative [--round:--spacing(2)] [--padding:--spacing(1)]',
            'dark:border-red-400! dark:shadow-red-400 text-red-400! placeholder:text-red-400!' => $invalid,
        ]),
     }}
>

     {{-- for classic form submission if your using livewire remove this --}}
    @if ($name)
        <input type="hidden" name="{{ $name }}" x-bind:value="isMultiple ? state.join(',') : state" />
    @endif

    <div>
        <x-ui.select.trigger/>

        <x-ui.select.options
            :checkIconClass="$checkIconClass"
            :checkIcon="$checkIcon"
        >
            {{ $slot }}
        </x-ui.select.options>
    </div
    >
</div>
