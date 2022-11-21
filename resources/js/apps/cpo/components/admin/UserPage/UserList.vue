<template>
    <div class="p-5">
        <table class="table table-striped" v-if="userList">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <user-item
                    v-for="user in userList"
                    :key="user.id"
                    :user="user"
                ></user-item>
            </tbody>
        </table>
    </div>
</template>

<script>
import UserItem from "./UserItem.vue";
export default {
    components: {
        UserItem,
    },
    props: ["searchCriteria"],
    watch: {
        searchCriteria: {
            handler(newVal, oldVal) {
                this.getUserList();
            },
            deep: true,
        },
    },
    data() {
        return {
            userList: null,
        };
    },
    methods: {
        async getUserList() {
            await axios
                .get("/api/users/list", {
                    params: {
                        ...this.searchCriteria,
                    },
                })
                .then((response) => {
                    this.userList = response.data.users;
                    // console.log(response.data);
                })
                .catch((error) => {
                    // console.log(error);
                });
        },
    },
    mounted() {
        this.getUserList();
    },
};
</script>

<style></style>
