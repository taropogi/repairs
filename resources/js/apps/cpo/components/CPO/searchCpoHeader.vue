<template>
    <div>
        <!-- <h4 class="text-center bg-success text-white p-2">SEARCH</h4> -->
        <form>
            <div class="row">
                <div class="col">
                    <label>Customer Name</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        @input="search"
                        v-model="searchCriteria.searchName"
                    />
                </div>
                <div class="col">
                    <label>Customer Address</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        @input="search"
                        v-model="searchCriteria.searchAddress"
                    />
                </div>
                <div class="col">
                    <label>Contact #</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        @input="search"
                        v-model="searchCriteria.searchContactNumber"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>RPO #</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        @input="search"
                        v-model="searchCriteria.searchRpoNumber"
                    />
                </div>
                <div class="col">
                    <label>Prepared By</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        @input="search"
                        v-model="searchCriteria.searchPreparedBy"
                    />
                </div>
                <div class="col">
                    <label>Authorized By</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        @input="search"
                        v-model="searchCriteria.searchAuthorizedBy"
                    />
                </div>
            </div>
        </form>

        <cpo-header-list
            :cpoHeaderList="cpoHeaderList"
            @edit-cpo="editCpo"
            @delete-cpo="deleteCpo"
        ></cpo-header-list>
    </div>
</template>

<script>
import cpoHeaderList from "../SearchCpo/cpoHeaderList.vue";

export default {
    components: {
        cpoHeaderList,
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
    watch: {
        onInputDelayedSeconds(value) {
            if (value === 1) {
                if (this.startSearch) {
                    this.actualSearch();
                }
            }
        },
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
        search() {
            if (!this.startSearch) {
                this.startSearch = true;
            }
            this.onInputDelayedSeconds = 0;
        },
        actualSearch() {
            this.$emit("search-cpo-header", this.searchCriteria);
            this.getCpoHeaders(this.searchCriteria);
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
