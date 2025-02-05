<template>
  <div>
    <div class="p-2">
      <label for="prepared-by" class="form-label mb-0">PREPARED BY</label>
      <input
        type="text"
        class="form-control shadow"
        id="prepared-by"
        required
        v-model="modelValue"
        @input="onInput"
        @focus="showSuggestions = true"
        @blur="hideSuggestions"
      />
      <ul
        v-if="showSuggestions && filteredSuggestions.length"
        class="suggestions-list"
      >
        <li
          v-for="suggestion in filteredSuggestions"
          :key="suggestion.id"
          @mousedown.prevent="selectSuggestion(suggestion)"
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
  },
  emits: ["update:modelValue"],
  data() {
    return {
      formData: {
        preparedBy: this.modelValue,
      },
      showSuggestions: false,
      suggestions: [],
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
    onInput() {
      //   console.log(this.modelValue);
      this.$emit("update:modelValue", this.modelValue.toUpperCase());
      this.showSuggestions = true;
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
  border: 1px solid #ccc;
  border-top: none;
  list-style: none;
  margin: 0;
  padding: 0;
  position: absolute;
  background-color: #f5f5f5;
  width: 300px;
  z-index: 1000;
  max-height: 150px; /* Set maximum height for the suggestions list */
  overflow-y: auto; /* Enable vertical scrolling */
}

.suggestions-list li {
  padding: 1px;
  cursor: pointer;
}

.suggestions-list li:hover {
  background-color: #f0f0f0;
}
</style>