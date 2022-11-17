<template>
    <div>
        <spinner-loading v-if="isSearching"> </spinner-loading>
        <div class="my-2" v-else>
            <modal-delete-cpo
                v-if="deleteCpo"
                :cpo-id="deleteCpo.id"
                @close-modal-delete-cpo="closeModalDeleteCpo"
                @deleted-cpo="closeModalDeleteCpo"
            ></modal-delete-cpo>

            <table
                class="table table-sm table-bordered table-striped table-hover"
            >
                <thead class="table-success">
                    <tr>
                        <th class="col tex-center">
                            [{{ selectedPosCount }}] CPO#
                            <!-- <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value=""
                            />
                        </div> -->
                        </th>

                        <th scope="col">RPO #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Contact#</th>
                        <th scope="col">Prepared By</th>
                        <th scope="col">Authorized By</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <header-list-item
                        v-for="item in cpoHeaderList"
                        :key="item.id"
                        :header-item="item"
                        @delete-cpo="openDeleteCpo"
                    ></header-list-item>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import HeaderListItem from "./HeaderListItem.vue";
import SpinnerLoading from "../UI/SpinnerLoading.vue";
import ModalDeleteCpo from "../DeleteCpo/ModalDeleteCpo.vue";
import { mapGetters } from "vuex";

export default {
    components: {
        HeaderListItem,
        SpinnerLoading,
        ModalDeleteCpo,
    },
    data() {
        return {
            cpoHeaderList: [],
            selectedHeaders: [],
            isSearching: false,

            deleteCpo: null,
        };
    },

    props: ["searchCriteria"],
    computed: {
        ...mapGetters("cpo", ["deletedCpos"]),
        selectedPosCount() {
            return this.selectedPos.length;
        },
        selectedPos() {
            return this.$store.getters["cpo/getSelectedPos"];
        },
    },
    watch: {
        searchCriteria: {
            handler(newValue, oldValue) {
                // console.log(newValue, oldValue);

                this.getCpoHeaders();

                // Note: `newValue` will be equal to `oldValue` here
                // on nested mutations as long as the object itself
                // hasn't been replaced.
            },
            deep: true,
        },
    },

    methods: {
        openDeleteCpo(cpoId) {
            this.deleteCpo = cpoId;
        },
        closeModalDeleteCpo() {
            this.deleteCpo = null;
        },
        getCpoHeaders() {
            this.isSearching = true;
            axios
                .get("api/cpo", {
                    params: {
                        ...this.searchCriteria,
                        // searchName: this.searchCriteria.searchName || "",
                        // searchAddress: this.searchCriteria.searchAddress || "",
                        // searchContact:
                        //     this.searchCriteria.searchContactNumber || "",
                        // searchRpo: this.searchCriteria.searchRpoNumber || "",
                        // searchPrepared:
                        //     this.searchCriteria.searchPreparedBy || "",
                        // searchAuthorized:
                        //     this.searchCriteria.searchAuthorizedBy || "",
                    },
                })
                .then((response) => {
                    // console.log(response.data);
                    this.cpoHeaderList = response.data.cpos;
                    this.isSearching = false;
                    // console.log(this.cpoHeaderList);
                    // console.log(response.data.limit_per_page);
                    //console.log(response.data[0].updatedAtReadable);
                })
                .catch((error) => {
                    // console.log(error);
                });
        },
    },
    mounted() {
        // this.getCpoHeaders();
    },
    updated() {
        // console.log(this.searchCriteria);
    },
};
</script>

<style scoped></style>
