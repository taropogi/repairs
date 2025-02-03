<template>
  <div class="card shadow-lg border-0" v-if="isNavSearchActive">
    <div class="card-header text-center">
      <h5 class="mb-0">Random Inspirational Quote</h5>
    </div>
    <div class="card-body text-center p-5">
      <blockquote class="blockquote mb-4">
        <p class="fs-4 fst-italic text-primary fw-bold">"{{ quote }}"</p>
      </blockquote>
      <footer class="blockquote-footer text-muted">{{ author }}</footer>
    </div>
  </div>

  <!-- <div
    v-if="isNavSearchActive"
    class="alert alert-info d-flex align-items-center mt-8"
    role="alert"
  >
    <div class="card shadow-lg border-0">
      <div class="card-body text-center p-5">
        <blockquote class="blockquote mb-4">
          <p class="fs-4 fst-italic text-primary">
            "Success is not final, failure is not fatal: it is the courage to
            continue that counts."
          </p>
        </blockquote>
        <footer class="blockquote-footer text-muted">Winston Churchill</footer>
      </div>
    </div>
    <div>
      <h4 class="quote-title">
        <i class="bi bi-info-circle me-2"></i>
        RANDOM QUOTE
      </h4>
      <hr />
      <blockquote class="blockquote quote-block">
        <p class="mb-0 quote-text my-2">
          "The only way to do great work is to love what you do." - Steve Jobs
        </p>
      </blockquote>
    </div>
  </div> -->
</template>

<script>
import axios from "axios";
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
/* .sidebar {
  padding: 20px;
  background-color: #f4f4f4;
  border-radius: 5px;
}
button {
  margin-top: 10px;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
} */

/* .quote-title {
  font-weight: bold;
  display: flex;
  align-items: center;
  color: #007bff;
}

.quote-block {
  border-left: 5px solid #007bff;
  padding-left: 15px;
  margin: 10px 0;
  background-color: #f8f9fa;
  border-radius: 5px;
}

.quote-text {
  font-style: italic;
  color: #343a40;
  font-size: 1.1em;
} */
</style>
