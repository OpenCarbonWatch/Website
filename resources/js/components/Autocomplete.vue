<template>
  <div ref="root">
    <slot
      :rootProps="rootProps"
      :inputProps="inputProps"
      :inputListeners="inputListeners"
      :resultListProps="resultListProps"
      :resultListListeners="resultListListeners"
      :results="results"
      :resultProps="resultProps"
    >
      <div v-bind="rootProps">
        <input class="form-control" :id="id" :name="id"
          ref="input"
          v-bind="inputProps"
          @input="handleInput"
          @keydown="core.handleKeyDown"
          @focus="core.handleFocus"
          @blur="core.handleBlur"
          v-on="$listeners"
        />
        <ul
          ref="resultList"
          v-bind="resultListProps"
          v-on="resultListListeners"
        >
          <template v-for="(result, index) in results">
            <slot name="result" :result="result" :props="resultProps[index]">
              <li :key="resultProps[index].id" v-bind="resultProps[index]">
                {{ getResultValue(result) }}
              </li>
            </slot>
          </template>
        </ul>
      </div>
    </slot>
  </div>
</template>

<script>
// Credit https://autocomplete.trevoreyre.com/
import AutocompleteCore from '../autocomplete/AutocompleteCore.js'
import uniqueId from '../autocomplete/util/uniqueId.js'
import getRelativePosition from '../autocomplete/util/getRelativePosition.js'
import debounce from '../autocomplete/util/debounce.js'

export default {
  name: 'Autocomplete',
  inheritAttrs: false,

  props: {
    id: {
      type: String,
      default: 'autocomplete-input',
    },
    search: {
      type: Function,
      required: true,
    },
    baseClass: {
      type: String,
      default: 'autocomplete',
    },
    autoSelect: {
      type: Boolean,
      default: false,
    },
    getResultValue: {
      type: Function,
      default: result => result,
    },
    defaultValue: {
      type: String,
      default: '',
    },
    debounceTime: {
      type: Number,
      default: 0,
    },
  },

  data() {
    const core = new AutocompleteCore({
      search: this.search,
      autoSelect: this.autoSelect,
      setValue: this.setValue,
      onUpdate: this.handleUpdate,
      onSubmit: this.handleSubmit,
      onShow: this.handleShow,
      onHide: this.handleHide,
      onLoading: this.handleLoading,
      onLoaded: this.handleLoaded,
    });
    if (this.debounceTime > 0) {
      core.handleInput = debounce(core.handleInput, this.debounceTime)
    }

    return {
      core,
      value: this.defaultValue,
      resultListId: uniqueId(`${this.baseClass}-result-list-`),
      results: [],
      selectedIndex: -1,
      expanded: false,
      loading: false,
      position: 'below',
      resetPosition: true,
    }
  },

  computed: {
    rootProps() {
      return {
        class: this.baseClass,
        style: { position: 'relative' },
        'data-expanded': this.expanded,
        'data-loading': this.loading,
        'data-position': this.position,
      }
    },
    inputProps() {
      return {
        class: `${this.baseClass}-input`,
        value: this.value,
        role: 'combobox',
        autocomplete: 'off',
        autocapitalize: 'off',
        autocorrect: 'off',
        spellcheck: 'false',
        'aria-autocomplete': 'list',
        'aria-haspopup': 'listbox',
        'aria-owns': this.resultListId,
        'aria-expanded': this.expanded ? 'true' : 'false',
        'aria-activedescendant':
          this.selectedIndex > -1
            ? this.resultProps[this.selectedIndex].id
            : '',
        ...this.$attrs,
      }
    },
    inputListeners() {
      return {
        input: this.handleInput,
        keydown: this.core.handleKeyDown,
        focus: this.core.handleFocus,
        blur: this.core.handleBlur,
      }
    },
    resultListProps() {
      const yPosition = this.position === 'below' ? 'top' : 'bottom';
      return {
        id: this.resultListId,
        class: `${this.baseClass}-result-list`,
        role: 'listbox',
        style: {
          position: 'absolute',
          zIndex: 1,
          width: '100%',
          visibility: this.expanded ? 'visible' : 'hidden',
          pointerEvents: this.expanded ? 'auto' : 'none',
          [yPosition]: '100%',
        },
      }
    },
    resultListListeners() {
      return {
        mousedown: this.core.handleResultMouseDown,
        click: this.core.handleResultClick,
      }
    },
    resultProps() {
      return this.results.map((result, index) => ({
        id: `${this.baseClass}-result-${index}`,
        class: `${this.baseClass}-result`,
        'data-result-index': index,
        role: 'option',
        ...(this.selectedIndex === index ? { 'aria-selected': 'true' } : {}),
      }))
    },
  },

  mounted() {
    document.body.addEventListener('click', this.handleDocumentClick)
  },

  beforeDestroy() {
    document.body.removeEventListener('click', this.handleDocumentClick)
  },

  updated() {
    if (!this.$refs.input || !this.$refs.resultList) {
      return
    }
    if (this.resetPosition && this.results.length > 0) {
      this.resetPosition = false;
      this.position = getRelativePosition(
        this.$refs.input,
        this.$refs.resultList
      )
    }
    this.core.checkSelectedResultVisible(this.$refs.resultList)
  },

  methods: {
    setValue(result) {
      this.value = result ? this.getResultValue(result) : ''
    },

    handleUpdate(results, selectedIndex) {
      this.results = results;
      this.selectedIndex = selectedIndex
    },

    handleShow() {
      this.expanded = true
    },

    handleHide() {
      this.expanded = false;
      this.resetPosition = true
    },

    handleLoading() {
      this.loading = true
    },

    handleLoaded() {
      this.loading = false
    },

    handleInput(event) {
      this.value = event.target.value;
      this.core.handleInput(event)
    },

    handleSubmit(selectedResult) {
      this.$emit('submit', selectedResult)
    },

    handleDocumentClick(event) {
      if (this.$refs.root.contains(event.target)) {
        return
      }
      this.core.hideResults()
    },
  },
}
</script>

<style scoped>
    .autocomplete-input {
        box-sizing: border-box;
        position: relative;
        flex: 1;
    }

    .autocomplete-input:focus,
    .autocomplete-input[aria-expanded="true"] {
        border-color: rgba(0, 0, 0, 0.12);
        background-color: #fff;
        outline: none;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.16);
    }

    [data-position="below"] .autocomplete-input[aria-expanded="true"] {
        border-bottom-color: transparent;
        border-radius: 8px 8px 0 0;
    }

    [data-position="above"] .autocomplete-input[aria-expanded="true"] {
        border-top-color: transparent;
        border-radius: 0 0 8px 8px;
        z-index: 2;
    }

    .autocomplete-result-list {
        margin: 0;
        border: 1px solid rgba(0, 0, 0, 0.12);
        padding: 0;
        box-sizing: border-box;
        max-height: 296px;
        overflow-y: auto;
        background: #fff;
        list-style: none;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.16);
    }

    [data-position="below"] .autocomplete-result-list {
        margin-top: -1px;
        border-top-color: transparent;
        border-radius: 0 0 8px 8px;
        padding-bottom: 8px;
    }

    [data-position="above"] .autocomplete-result-list {
        margin-bottom: -1px;
        border-bottom-color: transparent;
        border-radius: 8px 8px 0 0;
        padding-top: 8px;
    }

    /* Single result item */
    .autocomplete-result {
        cursor: default;
        padding: 12px 12px 12px 12px;
    }

    .autocomplete-result:hover,
    .autocomplete-result[aria-selected="true"] {
        background-color: rgba(0, 0, 0, 0.06);
    }
</style>
