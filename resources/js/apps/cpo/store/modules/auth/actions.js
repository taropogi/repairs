export default {
  setIsLoggedIn(context, payload) {
    context.commit("setIsLoggedIn", payload);
  },
  setUser(context, payload) {
    context.commit("setUser", payload);
  },
  async tryLogin(context) {
    console.log("TRY LOGIN");

    const isLoggedIn = localStorage.getItem("isLoggedIn");
    const loggedUser = localStorage.getItem("loggedUser");

    if (isLoggedIn && loggedUser) {
      context.commit("setIsLoggedIn", true);
      context.commit("setUser", JSON.parse(loggedUser));
    }
  },
  logOutUser(context) {
    localStorage.removeItem("isLoggedIn");
    localStorage.removeItem("loggedUser");

    context.commit("setIsLoggedIn", null);
    context.commit("setUser", null);
  },
};
