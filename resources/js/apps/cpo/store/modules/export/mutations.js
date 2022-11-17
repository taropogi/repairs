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
};
