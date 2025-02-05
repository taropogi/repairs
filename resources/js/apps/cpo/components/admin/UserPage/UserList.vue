<template>
  <div class="p-5">
    <modal-delete-user
      v-if="deleteUser"
      :user="deleteUser"
      @close="deleteUser = null"
      @deleted-user="getUserList"
    ></modal-delete-user>
    <table class="table table-striped table-sm table-hover" v-if="userList">
      <thead>
        <tr class="table-primary">
          <th scope="col">Username</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Permissions</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <user-item
          v-for="user in userList"
          :key="user.id"
          :user="user"
          @delete-user="openDeleteUserModal"
        ></user-item>
      </tbody>
    </table>
  </div>
</template>

<script>
import UserItem from "./UserItem.vue";
import ModalDeleteUser from "./ModalDeleteUser.vue";
export default {
  components: {
    UserItem,
    ModalDeleteUser,
  },
  props: ["searchCriteria"],
  data() {
    return {
      deleteUser: null,
      userList: null,
    };
  },

  watch: {
    searchCriteria: {
      handler(newVal, oldVal) {
        this.getUserList();
      },
      deep: true,
    },
  },
  methods: {
    openDeleteUserModal(user) {
      this.deleteUser = user;
    },
    async getUserList() {
      this.deleteUser = null;
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
