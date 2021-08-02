const auth = {
    namespaced: true,
    state: () => ({
        player: null
    }),
    mutations: {
        SET_PLAYER_ITEM(state, payload) {
            state.player = payload;
        },
        REMOVE_PLAYER(state) {
            state.player = null;
        }
    },
    actions: {
        clearPlayer({ commit }) {
            commit("REMOVE_PLAYER");
        }
    },
    getters: {
        player(state) {
            return state.player;
        }
    }
};

export default auth;
