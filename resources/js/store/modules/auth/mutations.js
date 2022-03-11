export default {
    setIsLoggedIn(state, payload) {
        state.isLoggedIn = payload;
        localStorage.setItem("isLoggedIn", payload);
    },
    setUser(state, user) {
        state.user = user;
    },
};
