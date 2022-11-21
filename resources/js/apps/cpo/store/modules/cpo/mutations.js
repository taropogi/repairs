export default {
    setEditingHeaderId(state, payload) {
        state.editingHeaderId = payload.cpoId;
    },
    setEditingHeaderRow(state) {
        axios
            .get("/repairs/api/cpo/" + state.editingHeaderId)
            .then((response) => {
                state.editingHeaderRow = {
                    customerName: response.data.cpo.customer_name,
                    customerAddress: response.data.cpo.customer_address,
                    contactNumber: response.data.cpo.contact_number,
                    rpoNumber: response.data.cpo.rpo_number,
                    preparedBy: response.data.cpo.prepared_by,
                    authorizedBy: response.data.cpo.authorized_by,
                };
            });
    },
    setGenLinks(state, payload) {
        state.genLinks = payload;
    },
    addSelectedPo(state, payload) {
        state.selectedPos.push(payload);
    },
    addDeletedCpos(state, payload) {
        state.deletedCpos.push(payload);
    },
    removeSelectedPo(state, payload) {
        const myArray = state.selectedPos.filter((el) => el.id !== payload.id);
        state.selectedPos = myArray;
    },
    updateSelectedCpoStatus(state, payload) {
        const selectedItem = state.selectedPos.find(
            (el) => el.id === payload.id
        );

        const myArray = state.selectedPos.filter((el) => el.id !== payload.id);

        selectedItem.isStatusUpdated = payload.isStatusUpdated;
        // const isStatusUpdated = {
        //     ...selectedItem,
        //     isStatusUpdated: payload.isStatusUpdated,
        // };

        // console.log(selectedItem);
        myArray.push(selectedItem);
        state.selectedPos = myArray;
    },

    updateSelectedCpoDeleted(state, payload) {
        const selectedItem = state.selectedPos.find(
            (el) => el.id === payload.id
        );
        const myArray = state.selectedPos.filter((el) => el.id !== payload.id);

        selectedItem.isDeleted = payload.isDeleted;

        myArray.push(selectedItem);
        state.selectedPos = myArray;
    },
};
