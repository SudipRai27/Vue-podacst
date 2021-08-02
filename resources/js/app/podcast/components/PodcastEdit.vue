<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Edit Podcast</div>
          <div class="card-body">
            <form method="POST" @submit.prevent="submit">
              <div class="form-group">
                <label for="title">Title</label>
                <div class="col-md-12">
                  <input
                    id="title"
                    type="text"
                    class="form-control"
                    name="title"
                    autocomplete="title"
                    v-model="form.title"
                    @input="removeErrors('title')"
                  />
                  <span
                    class="invalid-feedback"
                    style="display: block"
                    role="alert"
                    v-if="errors.title"
                  >
                    {{ errors.title[0] }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label for="body">Body</label>
                <div class="col-md-12">
                  <textarea
                    id="body"
                    type="text"
                    class="form-control"
                    name="body"
                    autocomplete="body"
                    v-model="form.body"
                    @input="removeErrors('body')"
                  />
                  <span
                    class="invalid-feedback"
                    style="display: block"
                    role="alert"
                    v-if="errors.body"
                  >
                    {{ errors.body[0] }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <input
                  type="radio"
                  value="1"
                  v-model="form.is_public"
                  selected
                  @change="removeErrors('is_public')"
                />
                Public
                <input
                  type="radio"
                  value="0"
                  v-model="form.is_public"
                  selected
                  @change="removeErrors('is_public')"
                />
                Private
                <div>
                  <span
                    class="invalid-feedback"
                    style="display: block"
                    role="alert"
                    v-if="errors.is_public"
                  >
                    {{ errors.is_public[0] }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label for="body">File</label><br />
                <input type="file" @input="fileSelected" ref="file" />
                <span
                  class="invalid-feedback"
                  style="display: block"
                  role="alert"
                  v-if="errors.file"
                >
                  {{ errors.file[0] }}
                </span>
              </div>
              <div class="form-group mb-0">
                <div class="col-md-6">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="updating"
                  >
                    Update Podcast
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { removeValidationErrors, redirectTo } from "@/helpers";
import { mapActions } from "vuex";
export default {
  name: "Podcast",
  data() {
    return {
      form: {
        title: "",
        body: "",
        file: null,
        is_public: "",
      },
      updating: false,
      errors: [],
    };
  },
  mounted() {
    this.fetchPodcast();
  },
  methods: {
    ...mapActions({
      getPodcast: "podcast/fetchPodcast",
    }),
    fetchPodcast() {
      this.getPodcast(this.$route.params.id)
        .then((res) => {
          this.form.title = res.data.title;
          this.form.body = res.data.body;
          this.form.is_public = res.data.is_public === true ? 1 : 0;
        })
        .catch((err) => {
          if (err.response) {
            redirectTo(err.response.status);
          }
        });
    },
    removeErrors(field) {
      this.errors = removeValidationErrors(this.errors, field);
    },
    fileSelected(e) {
      this.removeErrors("file");
      this.form.file = e.target.files[0];
    },
    async submit() {
      let loader = this.$loading.show({
        // Optional parameters
        container: null,
        canCancel: false,
        onCancel: this.onCancel,
      });
      !_.isEmpty(this.errors) ? (this.errors = {}) : "";
      let formData = new FormData();
      for (var key in this.form) {
        formData.append(key, this.form[key]);
        formData.append("_method", "PUT");
      }
      this.updating = true;
      axios
        .post(`v1/podcast/${this.$route.params.id}`, formData)
        .then((res) => {
          this.$displaySuccess(
            res.data.message + ". Go to dashboard to view your podcasts."
          );
          this.$router.push({
            name: "dashboard",
          });
          loader.hide();
        })
        .catch((err) => {
          this.updating = false;
          loader.hide();
          if (err.response && err.response.status === 422) {
            this.errors = err.response.data.errors;
          }
        });
    },
  },
};
</script>
