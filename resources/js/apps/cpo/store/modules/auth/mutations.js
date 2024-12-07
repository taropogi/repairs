export default {
  setIsLoggedIn(state, payload) {
    state.isLoggedIn = payload;
    if (payload) {
      localStorage.setItem("isLoggedIn", payload);
    }
  },
  async setUser(state, user) {
    state.user = user;
    const freshUser = await axios.get("api/user");

    const toUseUser = freshUser.data || user;

    state.user = toUseUser;
    if (toUseUser) {
      localStorage.setItem("loggedUser", JSON.stringify(toUseUser));
    }
  },
};
