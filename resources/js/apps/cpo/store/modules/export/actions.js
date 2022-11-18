export default {
    addSelectedStatus(context, payload) {
        context.commit("addSelectedStatus", payload);
    },
    removeSelectedStatus(context, payload) {
        context.commit("removeSelectedStatus", payload);
    },
    setCpoModifiedDate(context, payload) {
        context.commit("setCpoModifiedDate", payload);
    },
    setCpoChangedStatusDate(state, payload) {
        context.commit("cpoChangedStatusDate", payload);
    },
};
