export default {
    setSelectedStatus(state, payload) {
        state.selectedStatus = payload;
    },
    addSelectedStatus(state, payload) {
        state.selectedStatus.push(payload);
    },
    removeSelectedStatus(state, payload) {
        const myArray = state.selectedStatus.filter(
            (status) => status.id !== payload.id
        );
        state.selectedStatus = myArray;
    },
    setCpoModifiedDate(state, payload) {
        state.cpoModifiedDate = payload;
    },

    setCpoChangedStatusDate(state, payload) {
        state.cpoChangedStatusDate = payload;
    },
    setCpoChangedStatusTo(state, payload) {
        state.cpoChangedStatusTo = payload;
    },
    setCpoChangedStatusCurrent(state, payload) {
        state.cpoChangedStatusCurrent = payload;
    },
};
