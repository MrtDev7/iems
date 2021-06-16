<template>
  <div>
    <!-- Hero -->
    <base-page-heading title="Spam Cause" subtitle="">
      <template #extra>
        <b-breadcrumb class="breadcrumb-alt">
          <b-breadcrumb-item href="javascript:void(0)">Tools</b-breadcrumb-item>
          <b-breadcrumb-item active>Spam cause</b-breadcrumb-item>
        </b-breadcrumb>
      </template>
    </base-page-heading>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
      <!-- Switches -->
      <base-block rounded>
        <b-form>
          <b-row class="push">
            <b-col lg="5" xl="5" md="12">
              <b-form-group label="value">
                <b-form-textarea
                  id="textarea"
                  placeholder="gggruggvucftvghtrhh......"
                  rows="3"
                  v-model="value"
                  style="height: 500px; overflow: outo"
                  max-rows="6"
                ></b-form-textarea>
              </b-form-group>
            </b-col>

            <b-col lg="2" xl="2" md="12">
              <b-row
                class="select-droplets py-7"
                align-h="center"
                align-v="center"
              >
                <b-col sm="12" class="d-flex justify-content-center">
                  <b-button
                    block
                    :disabled="!value.length > 0"
                    @click="getResult"
                    variant="outline-primary"
                  >
                    <i class="fa fa-chevron-right"></i
                  ></b-button>
                </b-col>
              </b-row>
            </b-col>

            <b-col lg="5" xl="5" md="12">
             <b-form-group label="result">
                  <div
                style="height: 500px; overflow: hidden"
                class="border rounded p-4"
              >
                <div
                  v-for="val in result"
                  :class="val.includes('Spam') ? 'text-danger' : 'text-primary'"
                  :key="val"
                >
                  {{ val }}
                </div>
              </div>
             </b-form-group>
            </b-col>
          </b-row>
        </b-form>
      </base-block>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Vue from "vue";
import VueSweetalert2 from "vue-sweetalert2";

const options = {
  buttonsStyling: false,
  customClass: {
    confirmButton: "btn btn-success m-1",
    cancelButton: "btn btn-danger m-1",
    input: "form-control",
  },
};

// Register Vue SweetAlert2 with custom options
Vue.use(VueSweetalert2, options);
Vue.prototype.Routes = window.routes;
export default {
  data: function () {
    return {
      value: "",
      result: [],
    };
  },
  methods: {
    getResult: function () {
        const headers = {
        "x-api-key": this.$store.getters.apiKey,
        Authorization: "Bearer " + this.$store.getters.userToken,
      };
      this.result = [];
      const url = "http://cloud.iems.io/app/api/tools/spam-clause";
      this.$store.commit("pageLoader", { mode: "on" });
      axios
        .post(url, { value: this.value } , {headers:headers})
        .then((response) => {
          this.result = response.data;
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });

          console.log(error.response.data);
        });
    },
    swalSimple() {
      this.$swal("Hi, this is just a simple message!");
    },
    swalSuccess() {
      this.$swal("Success", "Everything was updated perfectly!", "success");
    },
    swalInfo() {
      this.$swal("Info", "Just an informational message!", "info");
    },
    swalWarning() {
      this.$swal("Warning", "Something needs your attention!", "warning");
    },
    swalError(error) {
      this.$swal("Oops...", error, "error");
    },
    swalQuestion() {
      this.$swal("Question", "Are you sure about that?", "question");
    },
    swalConfirm(title, text, onConfirm) {
      this.$swal({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        customClass: {
          confirmButton: "btn btn-danger m-1",
          cancelButton: "btn btn-secondary m-1",
        },
        confirmButtonText: "Yes, delete!",
        html: false,
        preConfirm: () => {
          return new Promise((resolve) => {
            setTimeout(() => {
              resolve();
            }, 50);
          });
        },
      }).then((result) => {
        if (result.value) {
          onConfirm();
        } else if (result.dismiss === "cancel") {
          this.$swal("Cancelled", "cancled", "error");
        }
      });
    },
    swalCustomPosition() {
      this.$swal({
        position: "top-end",
        title: "Perfect!",
        text: "Nice Position!",
        icon: "success",
      });
    },
    toast(
      title,
      content,
      variant = null,
      append = false,
      toaster = "b-toaster-bottom-right",
      autoHideDelay = 3000
    ) {
      this.$bvToast.toast(content, {
        title: title,
        toaster: toaster,
        variant: variant,
        autoHideDelay: autoHideDelay,
        appendToast: append,
      });
    },
  },
};
</script>
<style lang="scss">
// SweetAlert2
@import "~sweetalert2/dist/sweetalert2.min.css";

.select-droplets {
  height: 500px !important;
}
.request-options-container {
  padding-top: 20px;
  margin: 10px 0px;
}
</style>