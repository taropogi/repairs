<template>
    <div>
        <confirm-modal></confirm-modal>
        <encode-cpo-form @inserted-cpo-header="getCpoHeaders"></encode-cpo-form>
        <hr />
        <search-cpo-header
            @search-cpo-header="getCpoHeaders"
        ></search-cpo-header>

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
        getCpoHeaders(searchCriteria) {
            if (searchCriteria === undefined) {
                searchCriteria = {};
            }

            // console.log(searchCriteria);

            axios
                .get("/repairs/api/cpo", {
                    params: {
                        searchName: searchCriteria.searchName || "",
                        searchAddress: searchCriteria.searchAddress || "",
                        searchContact: searchCriteria.searchContactNumber || "",
                        searchRpo: searchCriteria.searchRpoNumber || "",
                        searchPrepared: searchCriteria.searchPreparedBy || "",
                        searchAuthorized:
                            searchCriteria.searchAuthorizedBy || "",
                    },
                })
                .then((response) => {
                    this.cpoHeaderList = response.data;
                    //  console.log(searchCriteria);
                    // console.log(response);
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
