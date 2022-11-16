<template>
    <div class="p-2">
        <form-header @searched-header-row="setHeaderRow" :id="id"></form-header>
        <header-lines
            class="mt-2"
            v-if="headerRow"
            :header-id="id"
            :header-is-locked="headerRow.locked"
        ></header-lines>
    </div>
</template>

<script>
import headerLines from "./headerLines.vue";
import FormHeader from "./FormHeader.vue";

export default {
    components: {
        FormHeader,
        headerLines,
    },
    props: ["id"],

    data() {
        return {
            headerRow: null,

            isUpdatedAllLinesSuccess: false,
        };
    },
    methods: {
        setHeaderRow(headerRow) {
            this.headerRow = headerRow;
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Edit");
        // this.$store.commit("setActiveNav", {
        //     nav: "edit-cpo",
        // });
    },
    mounted() {
        //  console.log("mounted");
        // this.getCpoHeaderRow();
    },
    updated() {
        //   console.log("new value: " + this.lineDetails.length);
    },
};
</script>

<style scoped>
.updated-header-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}

.updated-header-enter-active {
    transition: all 0.3s ease-out;
}
.updated-header-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.updated-header-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.updated-header-leave-active {
    transition: all 0.3s ease-in;
}
.updated-header-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
