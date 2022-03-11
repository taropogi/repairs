<template>
    <div>
        <router-view
            @inserted-cpo-header="getCpoHeaders"
            @search-cpo-header="getCpoHeaders"
        ></router-view>

        <cpo-header-list
            :cpoHeaderList="cpoHeaderList"
            @editCpo="editCpo"
        ></cpo-header-list>
    </div>
</template>

<script>
import encodeCpoForm from "../CPO/encodeCpoForm.vue";
import cpoHeaderList from "../CPO/cpoHeaderList.vue";
import confirmModal from "../UI/confirmModal.vue";
import searchCpoHeader from "../CPO/searchCpoHeader.vue";
import editCpoHeader from "../CPO/editCpoHeader.vue";

export default {
    components: {
        encodeCpoForm,
        cpoHeaderList,
        confirmModal,
        searchCpoHeader,
        editCpoHeader,
    },
    data() {
        return {
            cpoHeaderList: null,
            isEdit: false,
            toEditCpoItemHeader: null,
        };
    },
    methods: {
        editCpo(cpoItemHeader) {
            this.isEdit = true;
            this.toEditCpoItemHeader = cpoItemHeader;
        },
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
