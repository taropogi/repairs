<template>
  <div class="permissions-container p-3 border rounded bg-light">
    <h3 class="mb-3">Select Permissions</h3>
    <div class="row">
      <div
        class="col-4"
        v-for="permission in permissions"
        :key="permission.name"
      >
        <div class="form-check mb-2">
          <input
            class="form-check-input"
            type="checkbox"
            :value="
              selectedPermissions.find(
                (selectedPermission) =>
                  selectedPermission?.name === permission.name
              ) || permission
            "
            :checked="!!isSelected(permission)"
            v-model="selectedPermissions"
          />
          <label class="form-check-label ms-2">
            <h4 class="p-3 bg-secondary text-white rounded">
              {{ permission.description }}
            </h4>

            <div v-if="permission.name === 'cpo-encode'" class="ms-4">
              <strong>Line Access</strong>
              <cpo-encode-lines
                :lineFields="permission.lineFields"
                v-model="cpoEncodeLineFields"
              />
            </div>
            <div v-if="permission.name === 'cpo-edit'" class="ms-4">
              <strong>Line Access</strong>
              <cpo-edit-lines
                :lineFields="permission.lineFields"
                v-model="cpoEditLineFields"
              />
              <hr />
              <strong>Header</strong>
              <div class="form-check mt-2">
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="canEditHeader"
                  id="canEditHeader"
                />
                <label class="form-check-label ms-2" for="canEditHeader'">
                  Can Edit Header
                </label>
              </div>
            </div>
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import CpoEncodeLines from "./CpoEncodeLines.vue";
import CpoEditLines from "./CpoEditLines.vue";

export default {
  emits: ["update:modelValue"],
  components: {
    CpoEncodeLines,
    CpoEditLines,
  },
  computed: {
    ...mapGetters("cpo", ["permissions"]),
  },
  props: {
    modelValue: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      selectedPermissions: this.modelValue,
      canEditHeader:
        this.modelValue?.find((permission) => permission.name === "cpo-edit")
          ?.canEditHeader || false,
      cpoEncodeLineFields:
        this.modelValue?.find((permission) => permission.name === "cpo-encode")
          ?.lineFields || [],
      cpoEditLineFields:
        this.modelValue?.find((permission) => permission.name === "cpo-edit")
          ?.lineFields || [],
    };
  },
  methods: {
    isSelected(permission) {
      return this.selectedPermissions.find(
        (selectedPermission) => selectedPermission.name === permission.name
      );
    },
    remapSelectedPermissions() {
      const mappedPermissions = this.selectedPermissions.map((permission) => {
        let modifiedPermission = {};

        modifiedPermission = {
          ...modifiedPermission,
          name: permission.name,
          description: permission.description,
        };

        if (permission.name === "cpo-encode") {
          modifiedPermission = {
            ...modifiedPermission,
            lineFields: this.cpoEncodeLineFields,
          };
        }
        if (permission.name === "cpo-edit") {
          console.log(this.cpoEditLineFields);
          modifiedPermission = {
            ...modifiedPermission,
            lineFields: this.cpoEditLineFields,
            canEditHeader: this.canEditHeader,
          };
        }

        return modifiedPermission;
      });
      // console.log(mappedPermissions);
      const filteredPermissions = mappedPermissions.filter(
        (permission) => permission.name
      );
      // console.log(this.canEditHeader);
      this.$emit("update:modelValue", filteredPermissions);

      // this.$emit("update:modelValue", mappedPermissions);
    },
  },
  watch: {
    selectedPermissions(newVal) {
      // console.log("selectedPermissions changed");

      this.remapSelectedPermissions();
    },
    cpoEncodeLineFields(newVal) {
      // console.log("cpoEncodeLineFields changed");
      if (newVal.length > 0) {
        this.selectedPermissions = this.selectedPermissions.filter(
          (permission) => permission.name !== "cpo-encode"
        );
        this.selectedPermissions.push({
          name: "cpo-encode",
          description: "CPO Encode",
          lineFields: newVal,
        });
      } else {
        this.selectedPermissions = this.selectedPermissions.filter(
          (permission) => permission.name !== "cpo-encode"
        );
      }
      this.remapSelectedPermissions();
    },
    cpoEditLineFields(newVal) {
      // console.log("cpoEditLineFields changed");
      // console.log(newVal.length);
      if (newVal.length > 0) {
        // check if there are selected line fields
        this.selectedPermissions = this.selectedPermissions.filter(
          (permission) => permission.name !== "cpo-edit"
        );
        this.selectedPermissions.push({
          name: "cpo-edit",
          description: "CPO Edit",
          lineFields: newVal,
          canEditHeader: this.canEditHeader,
        });
      } else {
        if (this.canEditHeader) return;
        this.selectedPermissions = this.selectedPermissions.filter(
          (permission) => permission.name !== "cpo-edit"
        );
      }

      this.remapSelectedPermissions();
    },
    canEditHeader(newValue) {
      if (newValue) {
        this.selectedPermissions = this.selectedPermissions.filter(
          (permission) => permission.name !== "cpo-edit"
        );
        this.selectedPermissions.push({
          name: "cpo-edit",
          description: "CPO Edit",
          lineFields: this.cpoEditLineFields,
          canEditHeader: newValue,
        });
      } else {
        // console.log(this.cpoEditLineFields.length);
        if (this.cpoEditLineFields.length > 0) return;
        this.selectedPermissions = this.selectedPermissions.filter(
          (permission) => permission.name !== "cpo-edit"
        );
      }

      this.remapSelectedPermissions();
    },
  },
  // mounted() {
  //   console.log(this.modelValue);
  //   console.log(this.modelValue?.canEditHeader);

  // },
};
</script>

<style scoped>
.permissions-container {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.permissions-container h3 {
  font-size: 1.25rem;
  font-weight: bold;
}

.form-check {
  display: flex;
  align-items: center;
}

.form-check-input {
  margin-right: 10px;
}

.form-check-label {
  font-size: 1rem;
}
</style>
