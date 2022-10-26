export default {
    setEditingHeaderRow(context, payload) {
        context.commit("setEditingHeaderId", payload);
        context.commit("setEditingHeaderRow");
        console.log(context.state.editingHeaderRow);
    },
};
