<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Podcasts</div>
          <div class="card-body">
            <PodcastList></PodcastList>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import PodcastList from "@/app/podcast/components/PodcastList";
export default {
  name: "Dashboard",
  components: {
    PodcastList,
  },
};
</script>
