<template>
    <div>
        <div v-if="!isLoading">
            <p>Name: {{ user.name }}</p>
            <p>Email: {{ user.email }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            isLoading: true,
        };
    },
    mounted() {
        axios.get("/repairs/api/user").then((response) => {
            this.user = response.data;
            //  console.log(this.user);
            this.isLoading = false;
        });
    },
};
</script>

<style></style>
