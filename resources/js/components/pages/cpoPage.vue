<template>
    <div>
        <encode-cpo-form></encode-cpo-form>
        <hr />
        <cpo-header-list :cpoHeaderList="cpoHeaderList"></cpo-header-list>
    </div>
</template>

<script>
import encodeCpoForm from "../CPO/encodeCpoForm.vue";
import cpoHeaderList from "../CPO/cpoHeaderList.vue";
export default {
    components: {
        encodeCpoForm,
        cpoHeaderList,
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
