export default {
    addSelectedStatus(context, payload) {
        context.commit("addSelectedStatus", payload);
    },
    removeSelectedStatus(context, payload) {
        context.commit("removeSelectedStatus", payload);
    },
};
