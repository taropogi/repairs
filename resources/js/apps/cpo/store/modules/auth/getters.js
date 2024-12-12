export default {
  loggedUser(state) {
    return state.user;
  },
  isLoggedIn(state) {
    return state.isLoggedIn;
  },
  canDeleteCpo(state) {
    if (!state.user) return false;
    if (
      state.user.is_admin ||
      state.user.permissions?.find((p) => p.name == "cpo-delete")
    )
      return true;
  },
  canEncodeCpo(state) {
    if (!state.user) return false;
    if (
      state.user.is_admin ||
      state.user.permissions?.find((p) => p.name == "cpo-encode")
    )
      return true;
  },
  canEditCpo(state) {
    if (!state.user) return false;
    if (
      state.user.is_admin ||
      state.user.permissions?.find((p) => p.name == "cpo-edit")
    )
      return true;
  },
  canDownloadCpoPdf(state) {
    if (!state.user) return false;
    if (
      state.user.is_admin ||
      state.user.permissions?.find((p) => p.name == "cpo-download-pdf")
    )
      return true;
  },
  userHasPermission(state) {
    return state.user.permissions || state.user.is_admin ? true : false;
  },
  isAdmin(state) {
    return state.user.is_admin;
  },
  encodeLineFieldsPermission(state) {
    return (
      state.user.permissions?.find((p) => p.name == "cpo-encode")?.lineFields ||
      []
    );
  },
  editLineFieldsPermission(state) {
    return (
      state.user.permissions?.find((p) => p.name == "cpo-edit")?.lineFields ||
      []
    );
  },
};
