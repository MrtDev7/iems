<template>
  <div>
    <!-- Hero -->
    <base-page-heading title="Hetzner" subtitle="">
      <template #extra>
        <b-breadcrumb class="breadcrumb-alt">
          <b-breadcrumb-item href="javascript:void(0)"
            >Hetzner</b-breadcrumb-item
          >
          <b-breadcrumb-item active>accounts</b-breadcrumb-item>
        </b-breadcrumb>
      </template>
    </base-page-heading>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
      <!-- Switches -->
      <base-block rounded>
        <b-card-body
          style="height: 40px"
          class="push px-4 d-flex justify-content-between"
        >
          <h4>hetzner accounts</h4>
          <b-button v-b-modal.create-block-vcenter variant="outline-primary"
            >create</b-button
          >
        </b-card-body>
        <b-table-simple
          responsive
          bordered
          striped
          title="accounts"
          table-class="table-vcenter"
        >
          <b-thead>
            <b-tr>
              <b-th style="width: 10%">id</b-th>
              <b-th style="width: 10%">name</b-th>
              <b-th style="width: 50%">token</b-th>
              <b-th class="text-center" style="width: 10%">Actions</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr v-for="account in accounts" :key="account.id">
              <b-td class="font-size-sm text-center">
                {{ account.id }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ account.name }}
              </b-td>
              <b-td class="font-size-sm text-center">
                {{ account.token }}
              </b-td>

              <b-td class="text-center">
                <b-button-group>
                  <b-button
                    v-b-modal.modal-block-vcenter
                    @click="getAccountFromList(account.id)"
                    size="sm"
                    variant="primary"
                  >
                    <i class="fa fa-fw fa-pencil-alt"></i>
                  </b-button>
                  <b-button
                    v-on:click="deleteAccount(account.id)"
                    size="sm"
                    variant="danger"
                  >
                    <i class="fa fa-fw fa-times"></i>
                  </b-button>
                </b-button-group>
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
      </base-block>
    </div>
    <b-modal
      id="modal-block-vcenter"
      body-class="p-0"
      centered
      hide-footer
      hide-header
    >
      <div class="block block-rounded block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Edit Account</h3>
          <div class="block-options">
            <button
              type="button"
              class="btn-block-option"
              @click="$bvModal.hide('modal-block-vcenter')"
            >
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <b-form>
            <b-row class="push" align-content="center">
              <b-col sm="12">
                <b-form-group label="name" label-for="name-text-input">
                  <b-form-input
                    id="name-text-input"
                    placeholder="Hetzner name"
                    v-model="name"
                    required
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col sm="12">
                <b-form-group label="tokens" label-for="token-text-input">
                  <b-form-input
                    id="token-text-input"
                    placeholder="Your tokens here"
                    v-model="token"
                    required
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col sm="12">
                <b-form-group
                  label="Max Droplets Per Request"
                  label-for="dropletsCount-text-input"
                >
                  <b-form-input
                    id="dropletsCount-text-input"
                    type="number"
                    placeholder="max droplet per request"
                    required
                    min="1"
                    v-model="maxServerPerRequest"
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col sm="12">
                <b-form-group
                  label="Root Pass"
                  label-for="root_pass-text-input"
                >
                  <b-form-input
                    id="root_pass-text-input"
                    type="text"
                    required
                    placeholder="root pass"
                    v-model="rootPass"
                  ></b-form-input>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <b-button
            variant="alt-primary"
            class="mr-1"
            @click="$bvModal.hide('modal-block-vcenter')"
            >Close</b-button
          >
          <b-button
            variant="primary"
            @click="
              () => {
                updateAccountParamters(), $bvModal.hide('modal-block-vcenter');
              }
            "
            >save</b-button
          >
        </div>
      </div>
    </b-modal>

    <b-modal
      id="create-block-vcenter"
      body-class="p-0"
      centered
      hide-footer
      hide-header
    >
      <div class="block block-rounded block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">create new Account</h3>
          <div class="block-options">
            <button
              type="button"
              class="btn-block-option"
              @click="$bvModal.hide('create-block-vcenter')"
            >
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <b-form>
            <b-row class="push" align-content="center">
              <b-col sm="12">
                <b-form-group label="name" label-for="name-text-input">
                  <b-form-input
                    id="name-text-input"
                    placeholder="Hetzner name"
                    v-model="name"
                    required
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col sm="12">
                <b-form-group label="tokens" label-for="token-text-input">
                  <b-form-input
                    id="token-text-input"
                    placeholder="Your tokens here"
                    v-model="token"
                    required
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col sm="12">
                <b-form-group
                  label="Max Droplets Per Request"
                  label-for="dropletsCount-text-input"
                >
                  <b-form-input
                    id="dropletsCount-text-input"
                    type="number"
                    placeholder="max droplet per request"
                    required
                    min="1"
                    v-model="maxServerPerRequest"
                  ></b-form-input>
                </b-form-group>
              </b-col>

              <b-col sm="12">
                <b-form-group
                  label="Root Pass"
                  label-for="root_pass-text-input"
                >
                  <b-form-input
                    id="root_pass-text-input"
                    type="text"
                    required
                    placeholder="root pass"
                    v-model="rootPass"
                  ></b-form-input>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <b-button
            variant="alt-primary"
            class="mr-1"
            @click="$bvModal.hide('create-block-vcenter')"
            >Close</b-button
          >
          <b-button
            variant="primary"
            @click="
              () => {
                createAccount(), $bvModal.hide('create-block-vcenter');
              }
            "
            >save</b-button
          >
        </div>
      </div>
    </b-modal>
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
  data() {
    return {
      accounts: [],
      accoutId: 0,
      token: "",
      rootPass: "",
      name: "",
      maxServerPerRequest: 1,
    };
  },
  beforeMount() {
    this.fetchAccounts();
  },
  methods: {
    getAccountFromList: function (hetznerId) {
      this.accounts.forEach((e) => {
        if (e.id == hetznerId) {
          this.accountId = e.id;
          this.token = e.token;
          this.rootPass = e.rootPass;
          this.name = e.name;
          this.maxServerPerRequest = e.maxServerPerRequest;
        }
      });
    },

    saveParamters: function () {
      console.log(this.accountId);
    },

    swalSimple() {
      this.$swal("Hi, this is just a simple message!");
    },

    swalSuccess() {
      this.$swal("Success", "hetzner parameters updated perfectly!", "success");
    },

    swalInfo() {
      this.$swal("Info", "Just an informational message!", "info");
    },

    swalWarning() {
      this.$swal("Warning", "Something needs your attention!", "warning");
    },

    swalError(error) {
      this.$swal("Oops...", error.data, "error");
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

    createAccount: function () {
      const headers = {
        'x-api-key':  this.$store.getters.apiKey,
        'Authorization' : 'Bearer ' + this.$store.getters.userToken
      };

      const url =
        "http://cloud.iems.io/app/api/services/hetzner/create";
      this.$store.commit("pageLoader", { mode: "on" });
      const params = {
        rootPass: this.rootPass,
        token: this.token,
        maxServerPerRequest: this.maxServerPerRequest,
        name: this.name,
      };
     
      axios
        .post(url, params , {headers:headers})
        .then((response) => {
          console.log(response);
          this.accounts = [];
          this.fetchAccounts();
          this.$store.commit("pageLoader", { mode: "off" });
        } , {
          headers: headers
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });
          this.swalError(error);
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
        });
    },

    deleteAccountRequest: function (accountId) {
     const headers = {
        'x-api-key':  this.$store.getters.apiKey,
        'Authorization' : 'Bearer ' + this.$store.getters.userToken
      };
      const url = "http://cloud.iems.io/app/api/services/hetzner/" + accountId;
      this.$store.commit("pageLoader", { mode: "on" });
      axios
        .delete(url , {
          headers: headers
        })
        .then((response) => {
          console.log(response);

          this.accounts = [];
          this.fetchAccounts();

          this.swalSuccess("account deleted successFully");
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          console.log(error);
          this.$store.commit("pageLoader", { mode: "off" });
          this.swalError("oops something went wrong");
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
        });
    },

    deleteAccount: function (accoutId) {
      this.swalConfirm(
        "are you sure!",
        "you are going to delete account " + accoutId,
        () => {
          this.deleteAccountRequest(accoutId);
        }
      );
    },

    updateAccountParamters: function () {
      this.sendUpdateAccountRequest(this.accountId);
    },

    sendUpdateAccountRequest: function (accountId) {
      const headers = {
        'x-api-key':  this.$store.getters.apiKey,
        'Authorization' : 'Bearer ' + this.$store.getters.userToken
      };
      const url =
        "http://cloud.iems.io/app/api/services/hetzner/update/" + accountId;
      this.$store.commit("pageLoader", { mode: "on" });
      const params = {
        rootPass: this.rootPass,
        token: this.token,
        maxServerPerRequest: this.maxServerPerRequest,
        name: this.name,
      };
      axios
        .post(url, params , {headers:headers})
        .then((response) => {
          console.log(response);
          this.accounts = [];
          this.fetchAccounts();
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });
          this.swalError(error);
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
        });
    },

    fetchAccounts: function () {
    const headers = {
        'x-api-key':  this.$store.getters.apiKey,
        'Authorization' : 'Bearer ' + this.$store.getters.userToken
      };
      const url = "http://cloud.iems.io/app/api/services/hetzner";
      this.$store.commit("pageLoader", { mode: "on" });
      axios
        .get(url , {
          headers:headers
          })
        .then((response) => {
          this.accounts = response.data;
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });
          this.swalError(error);
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
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