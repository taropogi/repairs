export default {
  setIsLoggedIn(state, payload) {
    state.isLoggedIn = payload;
    if (payload) {
      localStorage.setItem("isLoggedIn", payload);
    }
  },
  async setUser(state, user) {
    try {
      state.user = user;
      const freshUser = await axios.get("api/user");

      const toUseUser = freshUser.data || user;

      state.user = toUseUser;
      if (toUseUser) {
        localStorage.setItem("loggedUser", JSON.stringify(toUseUser));
      }
    } catch (e) {
      console.log("Error in setUser mutation");
      console.error(e);
    }
  },
};
