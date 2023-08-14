<template>
    <div>
        <h4 class="text-center bg-success text-white p-2">SEARCH CPO</h4>
        <search-form @search-cpo-header="mySearch"></search-form>

        <cpo-header-list
            :search-criteria="searchCriteria"
            @edit-cpo="editCpo"
            @delete-cpo="deleteCpo"
        ></cpo-header-list>
    </div>
</template>

<script>
import cpoHeaderList from "./cpoHeaderList.vue";
import SearchForm from "./SearchForm.vue";

export default {
    components: {
        cpoHeaderList,
        SearchForm,
    },

    data() {
        return {
            searchCriteria: {},
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
            this.searchCriteria = searchCriteria;
            // console.log("change criteria");
            // console.log(this.searchCriteria);
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Search");
        this.$store.commit("setActiveNav", {
            nav: "search-cpo",
        });
    },
};
</script>

<style></style>
