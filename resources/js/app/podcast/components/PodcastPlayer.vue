<template>
  <transition name="slide-up">
    <div class="player" v-if="player">
      <p class="close-btn" @click="clearPlayer">X</p>
      <div class="player__header">
        <span>Now Playing</span> : {{ player.title }}
      </div>
      <audio
        :src="player.fileUrl"
        controls
        autoplay
        ref="player"
        class="player__audio"
      ></audio>
    </div>
  </transition>
</template>
<script>
import { mapActions } from "vuex";
export default {
  name: "PodcastPlayer",
  props: {
    player: {
      required: true,
      type: Object,
    },
  },
  watch: {
    player() {
      this.$refs.player.load();
    },
  },
  mounted() {
    this.$refs.player.addEventListener("ended", () => {
      this.clearPlayer();
    });
  },
  methods: {
    ...mapActions({
      clearPlayer: "player/clearPlayer",
    }),
  },
};
</script>
<style scoped lang="scss">
.player {
  position: fixed;
  z-index: 1000;
  bottom: 0;
  left: 20%;
  right: 20%;
  height: 120px;
  padding: 10px;
  background-color: #f3a9a9;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;

  .close-btn {
    position: absolute;
    right: 20px;
    cursor: pointer;
  }

  &__header {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    width: 100%;
    font-weight: 800;
  }

  &__audio {
    width: 100%;
  }
}

.slide-up-enter-active,
.slide-up-leave-active {
  transform: translateY(0);
  opacity: 1;
  transition: all 0.8s ease-in-out;
}

.slide-up-enter,
.slide-up-leave-to {
  transform: translateY(100px);
  transition: all 0.3s ease-in-out;
  opacity: 0;
}
</style>
