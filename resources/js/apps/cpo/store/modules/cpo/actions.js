export default {
    setEditingHeaderRow(context, payload) {
        context.commit("setEditingHeaderId", payload);
        context.commit("setEditingHeaderRow");
        console.log(context.state.editingHeaderRow);
    },

    updateSelectedCpoStatus(context, payload) {
        context.commit("updateSelectedCpoStatus", payload);
    },
};
