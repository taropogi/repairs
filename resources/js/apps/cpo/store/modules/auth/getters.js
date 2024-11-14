export default {
  loggedUser(state) {
    return state.user;
  },
  isLoggedIn(state) {
    return state.isLoggedIn;
  },
  canDeleteCpo(state) {
    if (!state.user) return false;
    if (state.user.is_admin || state.user.permissions.includes("cpo-delete"))
      return true;
  },
  userHasPermission(state) {
    return state.user.permissions || state.user.is_admin ? true : false;
  },
  isAdmin(state) {
    return state.user.is_admin;
  },
};
