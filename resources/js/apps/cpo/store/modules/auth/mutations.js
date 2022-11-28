export default {
    setIsLoggedIn(state, payload) {
        state.isLoggedIn = payload;
        if (payload) {
            localStorage.setItem("isLoggedIn", payload);
        }
    },
    setUser(state, user) {
        state.user = user;
        if (user) {
            localStorage.setItem("loggedUser", JSON.stringify(user));
        }
    },
};
