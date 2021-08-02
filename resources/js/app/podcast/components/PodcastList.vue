<template>
  <div>
    <PodcastPlayer v-if="player" :player="player"></PodcastPlayer>
    <template v-if="podcasts.length">
      <transition-group name="fade" class="row">
        <div v-for="podcast in podcasts" :key="podcast.id" class="col-sm-6">
          <div class="podcast">
            <p
              class="heading d-flex justify-content-between align-items-center"
            >
              <span> {{ podcast.title }} </span>
              <span>
                {{ podcast.created_at }}
              </span>
            </p>
            <p class="body">
              {{
                podcast.body && podcast.body.length > 100
                  ? podcast.body.substring(0, 8) + ".."
                  : podcast.body
              }}
            </p>
            <div class="row justify-content-center">
              <div class="dropdown">
                <button
                  class="btn btn-secondary dropdown-toggle"
                  type="button"
                  id="dropdownMenuButton"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  ...
                </button>
                &nbsp;
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <router-link
                    class="dropdown-item"
                    :to="{ name: 'podcast.edit', params: { id: podcast.id } }"
                    >Edit</router-link
                  >
                  <a
                    class="dropdown-item"
                    href="#"
                    @click="deletePodcast(podcast.id)"
                    >Delete (cannot be undone)</a
                  >
                </div>
              </div>
              <button
                class="btn btn-success"
                @click="getSinglePodcast(podcast.id)"
                :class="{ disabled: player && player.id === podcast.id }"
              >
                {{ player && player.id === podcast.id ? "Playing.." : "Play" }}
              </button>
            </div>
          </div>
        </div>
      </transition-group>
    </template>
    <template v-else>
      <div class="row justify-content-center">
        <h5>
          It seems that you dont have any podcast at the moment. Please upload
          it by going to the podcast
        </h5>
      </div>
    </template>
    <div class="mt-4 pl-5 pr-5">
      <button
        class="btn btn-danger w-100"
        @click.prevent="fetchMorePodcast"
        v-if="page.hasMore()"
      >
        Load More
      </button>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import PodcastPlayer from "./PodcastPlayer.vue";
export default {
  name: "PodcastList",
  components: {
    PodcastPlayer,
  },
  data() {
    return {};
  },
  mounted() {
    this.getPodcasts();
  },
  methods: {
    ...mapActions({
      fetchPodcast: "podcast/getPodcasts",
      fetchMorePodcast: "podcast/getMorePodcasts",
      fetchSinglePodcast: "podcast/getPodcast",
      destroyPodcast: "podcast/destroyPodcast",
    }),
    getSinglePodcast(podcastId) {
      try {
        this.fetchSinglePodcast(podcastId);
      } catch (e) {
        this.$displayError("Oops some errors occured");
      }
    },
    getPodcasts() {
      let loader = this.$loading.show({
        // container: this.$refs.podcast,
        container: null,
        canCancel: false,
        onCancel: this.onCancel,
      });
      this.fetchPodcast()
        .then((res) => {
          loader.hide();
        })
        .catch((e) => {
          loader.hide();
        });
    },
    deletePodcast(podCastId) {
      if (confirm("Do you really want to delete?")) {
        this.destroyPodcast(podCastId)
          .then((res) => {
            this.$displaySuccess("Deleted successfully");
          })
          .catch((e) => {
            this.$displayError("Oops some errors occured");
          });
      }
    },
  },
  computed: {
    ...mapGetters({
      podcasts: "podcast/podcasts",
      page: "podcast/page",
      player: "player/player",
    }),
  },
};
</script>
<style scoped lang="scss">
.podcast {
  background: #fff;
  padding: 10px;
  margin-bottom: 10px;
  font-size: 16px;
  box-shadow: 5px 5px 5px 5px rgba(#888888, 0.2);
}

.fade-enter-active,
.fade-enter-leave {
  transition: opacity 500ms ease-in-out;
  z-index: 100;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
  z-index: 100;
}
</style>
