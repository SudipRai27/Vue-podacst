import Vue from "vue";
import Vuex from "vuex";

import auth from "./modules/auth";
import player from "./modules/player";
import podcast from "./modules/podcast";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        player,
        podcast
    }
});
