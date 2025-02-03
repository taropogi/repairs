<template>
  <div class="card shadow-lg border-0" v-if="isNavSearchActive">
    <div class="card-header text-center">
      <h5 class="mb-0">Random Inspirational Quote</h5>
    </div>
    <div class="card-body text-center p-3">
      <blockquote class="blockquote mb-2">
        <p class="fs-5 fst-italic text-primary fw-bold">"{{ quote }}"</p>
      </blockquote>
      <footer class="blockquote-footer text-muted mt-2">{{ author }}</footer>
      <button class="refresh-button" @click="fetchQuote">
        <i class="bi bi-arrow-clockwise"></i>
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { QUOTES } from "../../utils/constArray.js";

export default {
  data() {
    return {
      quote: "",
      author: "",
    };
  },
  computed: {
    ...mapGetters(["activeNav"]),
    isNavSearchActive() {
      return this.activeNav?.nav === "search-cpo" ? true : false;
    },
  },
  methods: {
    async fetchQuote() {
      const randomIndex = Math.floor(Math.random() * QUOTES.length);
      const randomQuote = QUOTES[randomIndex];
      this.quote = randomQuote.text;
      this.author = randomQuote.author;
    },
  },
  mounted() {
    this.fetchQuote();
  },
};
</script>

<style scoped>
.card-body {
  position: relative;
  padding: 1rem; /* Reduced padding */
}

.blockquote {
  margin-bottom: 0.5rem; /* Reduced margin */
}

.fs-5 {
  font-size: 1.25rem; /* Smaller font size */
}

.refresh-button {
  /* position: absolute; */
  /* bottom: 10px; */
  /* left: 10px; */
  background: none;
  border: none;
  color: #007bff;
  cursor: pointer;
  font-size: 1.5rem;
  padding: 0;
}

.refresh-button:hover {
  color: green;
}
</style>
