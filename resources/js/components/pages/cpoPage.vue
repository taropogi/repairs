<template>
    <div>
        <router-view
            v-slot="slotProps"
            @inserted-cpo-header="getCpoHeaders"
            @search-cpo-header="getCpoHeaders"
            @updated-cpo-header="getCpoHeaders"
            @updated-header-lines="getCpoHeaders"
        >
            <transition name="router" mode="out-in">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>

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
