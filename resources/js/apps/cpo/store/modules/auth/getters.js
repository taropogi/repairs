export default {
  loggedUser(state) {
    return state.user;
  },
  isLoggedIn(state) {
    return state.isLoggedIn;
  },
  hasDeletePermission(state) {
    return state.user.permissions.includes("cpo-delete");
  },
};
