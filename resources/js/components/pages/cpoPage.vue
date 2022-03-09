<template>
    <encode-cpo-form></encode-cpo-form>
</template>

<script>
import encodeCpoForm from "../CPO/encodeCpoForm.vue";
export default {
    components: {
        encodeCpoForm,
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Pullout Form");
    },
};
</script>

<style></style>
