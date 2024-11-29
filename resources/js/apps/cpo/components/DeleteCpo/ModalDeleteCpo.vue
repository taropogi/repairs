<template>
  <base-modal>
    <template #header>
      <h5 class="modal-title text-white">
        <strong> Are you sure you want to delete this CPO?</strong>
      </h5>
      <button
        type="button"
        class="btn-close"
        @click="$emit('close-modal-delete-cpo')"
      ></button>
    </template>
    <template #body v-if="headerRow">
      <table class="table table-sm">
        <thead>
          <tr class="table-primary">
            <th scope="col">CPO#</th>
            <th scope="col">Customer</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ headerRow.formatted_id }}</th>
            <td>{{ headerRow.customer_name }}</td>
            <td>{{ headerRow.status.status }}</td>
          </tr>
        </tbody>
      </table>
    </template>
    <template #default v-if="!isDeleting">
      <button type="button" class="btn btn-danger" @click="confirmDelete">
        Yes
      </button>
      <button
        type="button"
        class="btn btn-primary"
        @click="$emit('close-modal-delete-cpo')"
      >
        No
      </button>
    </template>
  </base-modal>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["cpoId"],

  emits: ["deleted-cpo", "close-modal-delete-cpo"],
  data() {
    return {
      headerRow: null,
      isDeleting: false,
    };
  },

  methods: {
    ...mapActions("cpo", ["removeSelectedPo", "addDeletedCpos"]),
    unselectPo() {
      this.removeSelectedPo({
        id: this.cpoId,
      });
    },
    async confirmDelete() {
      this.isDeleting = true;
      try {
        const res = await axios.post("api/cpo/destroy", {
          cpoId: this.cpoId,
        });
        if (res.data) {
          this.unselectPo();
          // this.addDeletedCpos({
          //     id: this.cpoId,
          // });
          // this.isDeleted = true;

          this.$emit("deleted-cpo", { id: this.cpoId });
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.isDeleting = false;
      }
    },
    async getCpoHeader() {
      try {
        const res = await axios.get("api/cpo/" + this.cpoId);
        this.headerRow = res.data.cpo;
      } catch (error) {
        console.log(error);
      }
      //   axios
      //     .get("api/cpo/" + this.cpoId)
      //     .then((response) => {
      //       this.headerRow = response.data.cpo;
      //     })
      //     .catch((error) => {
      //       console.log(error);
      //     });
    },
  },
  mounted() {
    this.getCpoHeader();
  },
};
</script>

<style></style>
