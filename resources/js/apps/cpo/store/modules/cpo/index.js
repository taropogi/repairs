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
        {
          description: "Encode CPO",
          name: "cpo-encode",
          lineFields: [
            {
              dbField: "description",
              description: "Description",
            },
            {
              dbField: "price",
              description: "Price",
            },
            {
              dbField: "hcopy",
              description: "Hcopy",
            },
            {
              dbField: "order_number",
              description: "Order Number",
            },
            {
              dbField: "qty_returned",
              description: "Qty Returned",
            },
            {
              dbField: "unit",
              description: "Unit",
            },
            {
              dbField: "qty_inspect",
              description: "Qty Inspected",
            },
            {
              dbField: "good_condition",
              description: "Good Condition",
            },
            {
              dbField: "minor_repair_clean",
              description: "Minor Repair Clean",
            },
            {
              dbField: "repair_parts_needed",
              description: "Repair Parts Needed",
            },
          ],
        },
        {
          description: "Edit CPO",
          name: "cpo-edit",
          lineFields: [
            {
              dbField: "description",
              description: "Description",
            },
            {
              dbField: "price",
              description: "Price",
            },
            {
              dbField: "hcopy",
              description: "Hcopy",
            },
            {
              dbField: "order_number",
              description: "Order Number",
            },
            {
              dbField: "qty_returned",
              description: "Qty Returned",
            },
            {
              dbField: "unit",
              description: "Unit",
            },
            {
              dbField: "qty_inspect",
              description: "Qty Inspected",
            },
            {
              dbField: "good_condition",
              description: "Good Condition",
            },
            {
              dbField: "minor_repair_clean",
              description: "Minor Repair Clean",
            },
            {
              dbField: "repair_parts_needed",
              description: "Repair Parts Needed",
            },
          ],
        },
        { description: "Delete CPO", name: "cpo-delete" },
        { description: "Download CPO PDF file", name: "cpo-download-pdf" },
      ],
    };
  },
  mutations,
  getters,
  actions,
};

export default cpoModule;
