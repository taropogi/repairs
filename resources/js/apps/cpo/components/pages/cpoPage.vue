<template>
    <div>
        <router-view
            v-slot="slotProps"
            @inserted-cpo-header="gotoSearchPage"
            @updated-cpo-header="gotoSearchPage"
            @refresh-header-list="getCpoHeaders"
        >
            <transition name="router" mode="out-in">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isEdit: false,
            toEditCpoItemHeader: null,
        };
    },
    methods: {
        gotoSearchPage() {
            this.$router.push({
                name: "search-cpo",
            });
        },

        getCpoHeaders(searchCriteria) {
            if (searchCriteria === undefined) {
                searchCriteria = {};
            }
            console.log("search");
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
                    console.log(response.data.limit_per_page);
                    //console.log(response.data[0].updatedAtReadable);
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

<style>
.router-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}
.router-enter-active {
    transition: all 0.3s ease-out;
}
.router-enter-to {
    opacity: 1;
    transform: translateY(0);
}
.router-leave-from {
    opacity: 1;
    transform: translateY(0);
}
.router-leave-active {
    transition: all 0.3s ease-out;
}
.router-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
