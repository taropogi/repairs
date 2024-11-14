import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const cpoModule = {
  namespaced: true,
  state() {
    return {
      cpoHeaders: [],
      editingHeaderId: null, // what is currently editing cpo header
      editingHeaderRow: [], // what is currently editing cpo header, actual row from database
      genLinks: [],
      selectedPos: [],
      deletedCpos: [],
      permissions: [
        { description: "Encode CPO", name: "encode-cpo" },
        { description: "Edit CPO", name: "edit-cpo" },
        { description: "Delete CPO", name: "delete-cpo" },
      ],
    };
  },
  mutations,
  getters,
  actions,
};

export default cpoModule;
