<template>
  <footer
    class="py-0 bg-dark text-white mt-auto footer"
    style="position: fixed; bottom: 0; width: 100%; z-index: 1000"
  >
    <blockquote class="blockquote p-0 mb-0 mx-4 d-flex align-items-center">
      <p class="mb-0 d-inline quote-text">"{{ quote }}"</p>
      <footer class="blockquote-footer my-0 ms-2">
        {{ author }}
      </footer>
    </blockquote>
  </footer>
</template>

<script>
import { QUOTES } from "../../utils/constArray.js";

export default {
  data() {
    return {
      quote: "",
      author: "",
    };
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
    setInterval(() => {
      this.fetchQuote();
    }, 30000);
  },
};
</script>

<style scoped>
.footer {
  display: flex;
  height: 30px; /* Adjust height as needed */
}

.blockquote-footer {
  font-size: 0.9em; /* Adjust font size as needed */
  color: #ccc; /* Adjust color as needed */
}
</style>