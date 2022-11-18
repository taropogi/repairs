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
    setCpoChangedStatusDate(context, payload) {
        context.commit("setCpoChangedStatusDate", payload);
    },
    setCpoChangedStatusTo(context, payload) {
        context.commit("setCpoChangedStatusTo", payload);
    },

    setCpoChangedStatusCurrent(context, payload) {
        context.commit("setCpoChangedStatusCurrent", payload);
    },
};
