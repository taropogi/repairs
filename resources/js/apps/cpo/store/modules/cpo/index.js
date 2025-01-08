import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";
import { LINEFIELDS } from "../../../utils/constArray.js";

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
        {
          description: "Encode CPO",
          name: "cpo-encode",
          lineFields: [...LINEFIELDS],
        },
        {
          description: "Edit CPO",
          name: "cpo-edit",
          lineFields: [...LINEFIELDS],
        },
        { description: "Delete CPO", name: "cpo-delete" },
        {
          description: "Can Change CPO Status",
          name: "cpo-change-status",
        },
        { description: "Download CPO PDF file", name: "cpo-download-pdf" },
      ],
    };
  },
  mutations,
  getters,
  actions,
};

export default cpoModule;
