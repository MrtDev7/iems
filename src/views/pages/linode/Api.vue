<template>
  <div>
    <!-- Hero -->
    <base-page-heading title="Linode" subtitle="">
      <template #extra>
        <b-breadcrumb class="breadcrumb-alt">
          <b-breadcrumb-item href="javascript:void(0)"
            >Linode</b-breadcrumb-item
          >
          <b-breadcrumb-item active>list</b-breadcrumb-item>
        </b-breadcrumb>
      </template>
    </base-page-heading>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
      <base-block rounded class="p-4">
        <b-row class="d-flex px-4 justify-content-between">
          <h5>Api</h5>
          <b-form-group label-for="accounts-input">
            <b-form-select
              id="accounts-select"
              v-model="token"
              v-on:change="onTokenChanged"
              :options="tokens"
              plain
            ></b-form-select>
          </b-form-group>
        </b-row>
        <b-table-simple responsive bordered striped table-class="table-vcenter">
          <b-thead>
            <b-tr>
              <b-th style="width: 10%">id</b-th>
              <b-th style="width: 10%">Ipv4</b-th>
              <b-th style="width: 10%">label</b-th>
              <b-th style="width: 10%">status</b-th>
              <b-th style="width: 10%">image</b-th>
              <b-th style="width: 10%">type</b-th>
              <b-th style="width: 10%">region</b-th>
              <b-th style="width: 10%">created</b-th>
              <b-th class="text-center" style="width: 5%">Actions</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr v-for="droplet in droplets" :key="droplet.id">
              <b-td class="font-size-sm text-center">
                {{ droplet.id }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ droplet.ipv4[0] }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ droplet.label }}
              </b-td>
              <b-td class="font-size-sm text-center">
                <span
                  :class="
                    droplet.status == 'running' ? 'bg-success' : 'bg-warning'
                  "
                  class="text-white px-4 py-2 rounded"
                  >{{ droplet.status }}</span
                >
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ droplet.image }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ droplet.type }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ droplet.region }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ droplet.created }}
              </b-td>
              <b-td class="text-center">
                <b-btn-group>
                  <b-button
                    v-on:click="deleteDroplet(droplet.id)"
                    size="sm"
                    variant="alt-primary"
                  >
                    <i class="fa fa-fw fa-times"></i>
                  </b-button>
                </b-btn-group>
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
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

export default {
  data: function () {
    return {
      droplets: [],
      currentPage: 1,
      pages: 1,
      pageSize: 20,
      token: "",
      tokens: [],
      accounts: [],
    };
  },
  beforeMount() {
    this.fetchParamters();
  },

  methods: {
    onTokenChanged: function () {
      this.droplets = [];
      this.selectedFiltredDroplets = [];
      this.accounts.forEach((e) => {
        console.log(e);
        if (e.token == this.token) {
          this.rootPass = e.rootPass;
        }
      });
      this.fetchDroplets();
    },
    deleteDroplet: function (dropletId) {
      const url = "https://api.linode.com/v4/linode/instances/" + dropletId;

      const headers = {
        Authorization: "Bearer " + this.token,
      };

      this.swalConfirm(
        "are you sure!",
        "you are going to delete drople " + dropletId,
        () => {
          axios
            .delete(url, {
              headers: headers,
            })
            .then((response) => {
              console.log(response);
              this.swalSuccess(
                "droplet " + dropletId + " deleted successfully"
              );
              this.fetchDroplets();
            })
            .catch((error) => {
              this.swalError(error.response.data.errors[0].reason);
            });
        }
      );
    },
    fetchParamters: function () {
      const headers = {
        "x-api-key": this.$store.getters.apiKey,
        Authorization: "Bearer " + this.$store.getters.userToken,
      };
      const url = "http://cloud.iems.io/app/api/services/linode";
      this.$store.commit("pageLoader", { mode: "on" });
      axios
        .get(url , {headers:headers})
        .then((response) => {
          this.accounts = response.data;
          this.token = response.data[0].token;
          response.data.forEach((e) => {
            this.tokens.push({ value: e.token, text: e.name });
          });
          this.fetchDroplets();
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });
          this.swalError(error.data);
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
        });
    },
    fetchDroplets: function () {
      const url =
        "https://api.linode.com/v4/linode/instances?page=" + this.currentPage;

      console.log(this.token);

      const headers = {
        Authorization: "Bearer " + this.token,
      };
      this.$store.commit("pageLoader", { mode: "on" });

      axios
        .get(url, {
          headers: headers,
        })
        .then((response) => {
          this.droplets = [];
          this.droplets = response.data.data;
          this.pages = response.data.pages;
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });

          this.swalError(error.response.data.errors[0].reason);
        });
    },

    swalSimple() {
      this.$swal("Hi, this is just a simple message!");
    },
    swalSuccess(message) {
      this.$swal("Success", message, "success");
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