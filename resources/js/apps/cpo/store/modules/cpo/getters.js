export default {
  getEditingHeaderId(state) {
    // console.log(state);
    return state.editingHeaderId;
  },
  getGenLinks(state) {
    return state.genLinks;
  },
  getSelectedPos(state) {
    return state.selectedPos;
  },
  selectedPos(state) {
    return state.selectedPos;
  },
  deletedCpos(state) {
    return state.deletedCpos;
  },
  permissions(state) {
    return state.permissions;
  },
};
