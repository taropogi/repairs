<template>
  <div>
    <no-encode-permission v-if="!canEncodeCpo" />
    <form-cpo v-else />
  </div>
</template>

<script>
import FormCpo from "./FormCpo.vue";
import NoEncodePermission from "./NoEncodePermission.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    FormCpo,
    NoEncodePermission,
  },
  computed: {
    ...mapGetters("auth", ["canEncodeCpo"]),
  },
  beforeCreate() {
    this.$store.commit("setMainPageTitleHeader", "CPO - Encode");
    this.$store.commit("setActiveNav", {
      nav: "encode-cpo",
    });
  },
};
</script>
