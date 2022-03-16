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
};
