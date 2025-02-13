export default {
    setEditingHeaderRow(context, payload) {
        context.commit("setEditingHeaderId", payload);
        context.commit("setEditingHeaderRow");
        // console.log(context.state.editingHeaderRow);
    },

    updateSelectedCpoStatus(context, payload) {
        context.commit("updateSelectedCpoStatus", payload);
    },

    updateSelectedCpoDeleted(context, payload) {
        context.commit("updateSelectedCpoDeleted", payload);
    },
    removeSelectedPo(context, payload) {
        context.commit("removeSelectedPo", payload);
    },
    addDeletedCpos(state, payload) {
        state.commit("addDeletedCpos", payload);
    },

    addSelectedPo(context, payload) {
        context.commit("addSelectedPo", payload);
    },
    resetSelectedCpos(context) {
        context.commit("resetSelectedCpos");
    },
};
