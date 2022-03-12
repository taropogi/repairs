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
import cpoHeaderList from "../CPO/cpoHeaderList.vue";
import editCpoHeader from "../CPO/editCpoHeader.vue";

export default {
    components: {
        cpoHeaderList,
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
            alert("edit");
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

    mounted() {
        this.getCpoHeaders();
    },
};
</script>

<style></style>
