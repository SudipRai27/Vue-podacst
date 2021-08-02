import axios from "axios";

const auth = {
    namespaced: true,
    state: () => ({
        podcasts: [],
        page: {
            current: 1,
            max: null,
            hasMore() {
                return this.current < this.max;
            }
        }
    }),
    mutations: {
        SET_PODCASTS(state, payload) {
            state.podcasts = payload;
        },
        APPEND_PODCAST(state, payload) {
            state.podcasts.push(...payload);
        },
        SET_PAGE_DATA(state, { current, max }) {
            state.page.current = current;
            state.page.max = max || state.page.max;
        },
        REMOVE_PODCAST(state, payload) {
            state.podcasts = state.podcasts.filter(
                podcast => podcast.id != payload
            );
        }
    },
    actions: {
        async getPodcasts({ commit }, page = 1) {
            await axios.get(`/v1/podcast?page=${page}`).then(res => {
                commit("SET_PODCASTS", res.data.data);
                commit("SET_PAGE_DATA", {
                    current: res.data.meta.current_page,
                    max: res.data.meta.last_page
                });
            });
        },
        async getMorePodcasts({ commit, state }) {
            await axios
                .get(`/v1/podcast?page=${state.page.current + 1}`)
                .then(res => {
                    commit("APPEND_PODCAST", res.data.data);
                    commit("SET_PAGE_DATA", {
                        current: res.data.meta.current_page,
                        max: res.data.meta.last_page
                    });
                });
        },
        async getPodcast({ commit }, podcastId) {
            await axios.get(`/v1/podcast/${podcastId}`).then(res => {
                commit("player/SET_PLAYER_ITEM", res.data.data, { root: true });
            });
        },
        async fetchPodcast({ commit }, podcastId) {
            try {
                const res = await axios.get(`/v1/podcast/${podcastId}`);
                return res.data;
            } catch (err) {
                throw err;
            }
        },
        async destroyPodcast({ commit }, podcastId) {
            await axios.delete(`v1/podcast/${podcastId}`).then(res => {
                commit("REMOVE_PODCAST", podcastId);
            });
        }
    },
    getters: {
        podcasts(state) {
            return state.podcasts;
        },
        page(state) {
            return state.page;
        }
    }
};

export default auth;
