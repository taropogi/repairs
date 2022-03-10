<template>
    <div>
        <confirm-modal></confirm-modal>
        <encode-cpo-form @inserted-cpo-header="getCpoHeaders"></encode-cpo-form>
        <hr />
        <search-cpo-header></search-cpo-header>
        <cpo-header-list :cpoHeaderList="cpoHeaderList"></cpo-header-list>
    </div>
</template>

<script>
import encodeCpoForm from "../CPO/encodeCpoForm.vue";
import cpoHeaderList from "../CPO/cpoHeaderList.vue";
import confirmModal from "../UI/confirmModal.vue";
import searchCpoHeader from "../CPO/searchCpoHeader.vue";

export default {
    components: {
        encodeCpoForm,
        cpoHeaderList,
        confirmModal,
        searchCpoHeader,
    },
    data() {
        return {
            cpoHeaderList: null,
        };
    },
    methods: {
        getCpoHeaders() {
            axios
                .get("/repairs/api/cpo")
                .then((response) => {
                    this.cpoHeaderList = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Pullout Form");
    },
    mounted() {
        this.getCpoHeaders();
    },
};
</script>

<style></style>
