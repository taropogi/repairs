<template>
  <div>
    <div class="p-2">
      <label for="prepared-by" class="form-label mb-0">
        {{ label }}
      </label>
      <input
        type="text"
        class="form-control shadow"
        id="prepared-by"
        required
        v-model="modelValue"
        @input="onInput"
        @focus="showSuggestions = true"
        @blur="hideSuggestions"
        @keydown.down.prevent="highlightNext"
        @keydown.up.prevent="highlightPrevious"
        @keydown.enter.prevent="selectHighlighted"
        autocomplete="off"
      />
      <ul
        v-if="showSuggestions && filteredSuggestions.length"
        class="suggestions-list"
      >
        <li
          v-for="(suggestion, index) in filteredSuggestions"
          :class="{ highlighted: index === highlightedIndex }"
          :key="suggestion.id"
          @mousedown.prevent="selectSuggestion(suggestion)"
          @mouseover="highlightIndex(index)"
        >
          {{ suggestion.name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      default: "PREPARED BY",
    },
  },
  emits: ["update:modelValue"],
  data() {
    return {
      formData: {
        preparedBy: this.modelValue,
      },
      showSuggestions: false,
      suggestions: [],
      highlightedIndex: -1,
    };
  },
  computed: {
    filteredSuggestions() {
      return this.suggestions.filter((suggestion) =>
        suggestion.name.toUpperCase().includes(this.modelValue.toUpperCase())
      );
    },
  },
  methods: {
    highlightNext() {
      // console.log("next");
      if (this.highlightedIndex < this.filteredSuggestions.length - 1) {
        this.highlightedIndex++;
      }
    },
    highlightPrevious() {
      // console.log("prev");
      if (this.highlightedIndex > 0) {
        this.highlightedIndex--;
      }
    },
    selectHighlighted() {
      if (
        this.highlightedIndex >= 0 &&
        this.highlightedIndex < this.filteredSuggestions.length
      ) {
        this.selectSuggestion(this.filteredSuggestions[this.highlightedIndex]);
      }
    },
    highlightIndex(index) {
      this.highlightedIndex = index;
    },
    onInput() {
      //   console.log(this.modelValue);
      this.$emit("update:modelValue", this.modelValue.toUpperCase());
      this.showSuggestions = true;
      this.highlightedIndex = -1;
    },
    hideSuggestions() {
      this.showSuggestions = false;
    },
    selectSuggestion(suggestion) {
      const firstName = suggestion.firstName;
      this.$emit("update:modelValue", firstName);
      //   this.$emit("update:modelValue", suggestion.name);
      // this.modelValue = suggestion;
      //   console.log(suggestion);
      //   this.onInput();
      this.showSuggestions = false;
    },
    async fetchSuggestions() {
      try {
        const res = await axios.get("/api/prepared-by/suggestions");
        // console.log(res.data);
        this.suggestions = res.data.suggestions;
        // console.log(this.suggestions);
      } catch (error) {
        console.log(error.message);
      }
    },
  },
  mounted() {
    this.fetchSuggestions();
  },
};
</script>

<style scoped>
.suggestions-list {
  border: 1px solid green;
  border-top: none;
  list-style: none;
  margin: 0;
  padding: 0;
  position: absolute;
  background-color: #f5f5f5;
  width: 300px;
  z-index: 1000;
  max-height: 100px; /* Set maximum height for the suggestions list */
  overflow-y: auto; /* Enable vertical scrolling */
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.suggestions-list li {
  padding: 1px;
  cursor: pointer;
}

.suggestions-list li:hover {
  background-color: #f0f0f0;
}

.suggestions-list li.highlighted {
  background-color: #198754; /* Bootstrap success color */
  color: white;
}
</style>