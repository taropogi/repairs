<template>
    <div>
        <!-- <h4 class="text-center bg-success text-white p-2">SEARCH</h4> -->
        <h1>Search</h1>

        <hr />
        <search-form @search-cpo-header="mySearch"></search-form>

        <cpo-header-list
            :cpoHeaderList="cpoHeaderList"
            @edit-cpo="editCpo"
            @delete-cpo="deleteCpo"
        ></cpo-header-list>
    </div>
</template>

<script>
import cpoHeaderList from "../CPO/cpoHeaderList.vue";
import SearchForm from "./SearchForm.vue";

export default {
    components: {
        cpoHeaderList,
        SearchForm,
    },

    data() {
        return {
            cpoHeaderList: null,
            onInputDelayedSeconds: 0,
            startSearch: false,
            searchCriteria: {
                searchName: "",
                searchAddress: "",
                searchContactNumber: "",
                searchRpoNumber: "",
                searchPreparedBy: "",
                searchAuthorizedBy: "",
            },
            selectedCpos: [],
        };
    },

    methods: {
        async deleteCpo(cpoItemHeader) {
            const res = await axios.post("/repairs/api/cpo/destroy", {
                cpoId: cpoItemHeader.id,
            });
            if (res.data) {
                this.getCpoHeaders();
            }
        },
        editCpo(cpoItemHeader) {
            this.isEdit = true;
            this.toEditCpoItemHeader = cpoItemHeader;
            //  alert("edit");
        },

        mySearch(searchCriteria) {
            this.getCpoHeaders(searchCriteria);
        },

        getCpoHeaders(searchCriteria) {
            if (searchCriteria === undefined) {
                searchCriteria = {};
            }
            // console.log("search CpoHeader");
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
                    this.cpoHeaderList = response.data.cpos;
                    //  console.log(this.cpoHeaderList);
                    // console.log(response.data.limit_per_page);
                    //console.log(response.data[0].updatedAtReadable);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Search");
    },
    mounted() {
        setInterval(() => {
            this.onInputDelayedSeconds++;
            // console.log(this.onInputDelayedSeconds);
        }, 1000);

        this.getCpoHeaders();
        // console.log("search page");
    },
};
</script>

<style></style>
