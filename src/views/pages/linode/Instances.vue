<template>
  <div>
    <!-- Hero -->
    <base-page-heading title="Linode" subtitle="">
      <template #extra>
        <b-breadcrumb class="breadcrumb-alt">
          <b-breadcrumb-item href="javascript:void(0)"
            >Linode</b-breadcrumb-item
          >
          <b-breadcrumb-item active>create</b-breadcrumb-item>
        </b-breadcrumb>
      </template>
    </base-page-heading>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
      <!-- Switches -->
      <base-block rounded>
        <b-row
          class="request-options-container"
          align-v="end"
          align-h="center"
          align-content="center"
        >
          <b-col xl="3">
            <b-form-group
              label="How many droplets?"
              label-for="example-text-input"
            >
              <b-form-input
                id="example-text-input"
                type="number"
                placeholder="droplets count"
                :max="maxDropletsPerRequest"
                v-model="dropletsCount"
              ></b-form-input>
            </b-form-group>
          </b-col>

          <b-col xl="3">
            <b-form-group label="Data Center region" label-for="region-input">
              <b-form-select
                id="region-select"
                v-model="selectedRegion"
                :options="regions"
                plain
              >
              </b-form-select>
            </b-form-group>
          </b-col>
          <b-col xl="4">
            <b-form-group label="Accounts" label-for="accounts-input">
              <b-form-select
                id="accounts-select"
                v-model="token"
                v-on:change="onTokenChanged"
                :options="tokens"
                plain
              ></b-form-select>
            </b-form-group>
          </b-col>
          <b-col xl="2">
            <b-button v-on:click="create" block class="push" variant="primary"
              ><span v-if="!loading">create</span
              ><b-spinner
                v-if="loading"
                small
                variant="white"
                label="Loading..."
              ></b-spinner
            ></b-button>
          </b-col>
        </b-row>
        <b-form>
          <b-row class="push">
            <b-col lg="5" xl="5" md="12">
              <b-row>
                <b-col sm="12">
                  <b-form-group
                    :label="
                      'droplets' +
                      ' : ' +
                      droplets.length +
                      ' | ' +
                      selectedDroplets.length
                    "
                    label-for="select-droplets"
                  >
                    <b-form-select
                      id="select-droplets"
                      class="select-droplets"
                      v-model="selectedDroplets"
                      multiple
                      plain
                    >
                      <b-form-select-option
                        v-for="droplet in droplets"
                        :value="droplet"
                        :key="droplet.value"
                        >{{ droplet }}</b-form-select-option
                      >
                    </b-form-select>
                  </b-form-group>
                </b-col>
                <b-col sm="12">
                  <b-row class="px-4">
                    <b-button
                      v-on:click="selectAll"
                      :disabled="!droplets.length > 0"
                      variant="outline-primary mr-1"
                      class="mb-2"
                      >select all</b-button
                    >
                    <b-button
                      v-on:click="unselectAll"
                      :disabled="!selectedDroplets.length > 0"
                      variant="outline-primary mx-1"
                      class="mb-2"
                      >unselect</b-button
                    >
                    <b-button
                      :disabled="!selectedDroplets.length > 0"
                      variant="outline-danger mx-1"
                      class="mb-2"
                      v-on:click="deleteSelected"
                      >delete</b-button
                    >
                    <b-button
                      :disabled="!selectedDroplets.length > 0"
                      variant="outline-success mx-1"
                      v-on:click="testIp"
                      class="mb-2"
                      >{{ testIpLable }}</b-button
                    >
                    <b-button
                      :disabled="!selectedDroplets.length > 0"
                      variant="outline-success mx-1"
                      class="mb-2"
                      v-on:click="configIp"
                      >{{ configIpLable }}</b-button
                    >
                  </b-row>
                </b-col>

                <b-col sm="12 mt-2 py-1 px-4">
                  <b-row align-content="center" align-h="center">
                    <b-col class="col-sm-8">
                      <b-form-input
                        id="to-text-input"
                        type="email"
                        placeholder="email"
                        v-model="email"
                      ></b-form-input>
                    </b-col>
                    <b-col class="col-sm-4">
                      <b-button
                        v-b-modal.testIpConfig-block-vcenter
                        size="sm"
                        variant="outline-primary"
                      >
                        <i class="fa fa-fw fa-sliders-h"></i>
                      </b-button>
                    </b-col>
                  </b-row>
                </b-col>

                <b-col sm="12 mt-2 py-1 px-4">
                  <b-button
                    v-if="logs.length > 0"
                    v-b-modal.logs-block-vcenter
                    variant="outline-primary"
                  >
                    show test logs</b-button
                  >
                  <b-button
                    v-if="configLogs.length > 0"
                    v-b-modal.configLogs-block-vcenter
                    variant="outline-primary"
                  >
                    show config logs</b-button
                  >
                </b-col>
              </b-row>
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
                    :disabled="!selectedFiltredDroplets.length > 0"
                    v-on:click="moveSelectedDropletsFromFiltedList"
                    variant="outline-primary"
                  >
                    <i class="fa fa-chevron-left"></i
                  ></b-button>
                </b-col>
                <b-col sm="12" class="d-flex justify-content-center">
                  <b-button
                    block
                    :disabled="!filtredDroplets.length > 0"
                    v-on:click="moveDropletsFromFiltedList"
                    variant="outline-primary"
                  >
                    <i class="fa fa-angle-double-left"></i
                  ></b-button>
                </b-col>
                <b-col sm="12" class="d-flex justify-content-center">
                  <b-button
                    block
                    :disabled="!selectedDroplets.length > 0"
                    v-on:click="moveSelectedDropletsToFiltedList"
                    variant="outline-primary"
                  >
                    <i class="fa fa-chevron-right"></i
                  ></b-button>
                </b-col>
                <b-col sm="12" class="d-flex justify-content-center">
                  <b-button
                    block
                    :disabled="!droplets.length > 0"
                    v-on:click="moveDropletsToFiltedList"
                    variant="outline-primary"
                  >
                    <i class="fa fa-angle-double-right"></i
                  ></b-button>
                </b-col>
              </b-row>
            </b-col>

            <b-col lg="5" xl="5" md="12">
              <b-row>
                <b-col sm="12">
                  <b-form-group
                    :label="
                      'droplets : ' +
                      this.filtredDroplets.length +
                      ' | ' +
                      this.selectedFiltredDroplets.length
                    "
                    label-for="select-filtred-droplets"
                  >
                    <b-form-select
                      id="select-filtred-droplets"
                      class="select-droplets"
                      v-model="selectedFiltredDroplets"
                      multiple
                      plain
                    >

                         <b-form-select-option
                        v-for="drop in filtredDroplets"
                        :value="drop"
                        :key="drop"
                        >{{ drop }}</b-form-select-option
                      >
                    </b-form-select>
                  </b-form-group>
                </b-col>
                <b-col sm="12">
                  <b-row class="px-4">
                    <b-button
                      v-on:click="selectAllFilted"
                      :disabled="!filtredDroplets.length > 0"
                      variant="outline-primary mx-2"
                      class="m-2"
                      >select all</b-button
                    >
                    <b-button
                      v-on:click="unselectSelected"
                      :disabled="!selectedFiltredDroplets.length > 0"
                      class="m-2"
                      variant="outline-primary mx-2"
                      >unselect</b-button
                    >
                    <b-button
                      :disabled="!selectedFiltredDroplets.length > 0"
                      variant="outline-danger mx-2"
                      class="m-2"
                      v-on:click="deleteSelectedFilted"
                      >delete</b-button
                    >

                    <b-button
                      :disabled="!selectedFiltredDroplets.length > 0"
                      variant="outline-warning mx-2"
                      class="m-2"
                      v-on:click="reboteSelected"
                      >Reboot</b-button
                    >

                    <b-button
                      variant="outline-success"
                      class="m-2"
                      :disabled="!selectedFiltredDroplets.length > 0"
                      v-b-modal.modal-block-vcenter
                    >
                      Export
                    </b-button>
                    
                  </b-row>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </b-form>
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
          <h3 class="block-title">Export Linodes</h3>

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
        <div class="block-content font-size-sm py-4">
          <div v-for="droplet in selectedFiltredDroplets" :key="droplet">
            {{
              droplet.split("|")[1].trim() +
              "," +
              22 +
              "," +
              "root" +
              "," +
              rootPass
            }}
          </div>
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
            @click="$bvModal.hide('modal-block-vcenter')"
            >Ok</b-button
          >
        </div>
      </div>
    </b-modal>

    <b-modal
      id="logs-block-vcenter"
      body-class="p-0"
      centered
      size="xl"
      hide-footer
      hide-header
    >
      <div class="block block-rounded block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Test Logs</h3>

          <div class="block-options">
            <button
              type="button"
              class="btn-block-option"
              @click="$bvModal.hide('logs-block-vcenter')"
            >
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <p class="align-start">
            {{ logs }}
          </p>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <b-button
            variant="alt-primary"
            class="mr-1"
            @click="$bvModal.hide('logs-block-vcenter')"
            >Close</b-button
          >
          <b-button
            variant="primary"
            @click="$bvModal.hide('logs-block-vcenter')"
            >Ok</b-button
          >
        </div>
      </div>
    </b-modal>

    <b-modal
      id="configLogs-block-vcenter"
      body-class="p-0"
      centered
      size="xl"
      hide-footer
      hide-header
    >
      <div class="block block-rounded block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Config Logs</h3>

          <div class="block-options">
            <button
              type="button"
              class="btn-block-option"
              @click="$bvModal.hide('configLogs-block-vcenter')"
            >
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <p class="align-start">
            {{ configLogs }}
          </p>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <b-button
            variant="alt-primary"
            class="mr-1"
            @click="$bvModal.hide('configLogs-block-vcenter')"
            >Close</b-button
          >
          <b-button
            variant="primary"
            @click="$bvModal.hide('configLogs-block-vcenter')"
            >Ok</b-button
          >
        </div>
      </div>
    </b-modal>
    <b-modal
      id="testIpConfig-block-vcenter"
      body-class="p-0"
      centered
      hide-footer
      hide-header
    >
      <div class="block block-rounded block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Test Config</h3>

          <div class="block-options">
            <button
              type="button"
              class="btn-block-option"
              @click="$bvModal.hide('testIpConfig-block-vcenter')"
            >
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <b-row>
            <b-col sm="12">
              <b-form-group label="from" label-for="from-input">
                <b-form-input id="from-input" v-model="from"> </b-form-input>
              </b-form-group>
            </b-col>

            <b-col sm="12">
              <b-form-group
                label="server username"
                label-for="server-username-input"
              >
                <b-form-input id="server-username-input" v-model="username">
                </b-form-input>
              </b-form-group>
            </b-col>

            <b-col sm="12">
              <b-form-group
                label="server password"
                label-for="server-password-input"
              >
                <b-form-input id="server-password-input" v-model="password">
                </b-form-input>
              </b-form-group>
            </b-col>
          </b-row>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <b-button
            variant="alt-primary"
            class="mr-1"
            @click="$bvModal.hide('testIpConfig-block-vcenter')"
            >Close</b-button
          >
          <b-button
            variant="primary"
            @click="$bvModal.hide('testIpConfig-block-vcenter')"
            >Ok</b-button
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
Vue.prototype.Routes = window.routes;
export default {
  data: function () {
    return {
      selectedRegion: "us-central",
      counter: 0, // count the clicks
      timer: null,
      regions: [],
      error: "",
      info: "",
      loading: false,
      data: [],
      tokens: [],
      dropletsCount: 1,
      maxDropletsPerRequest: 0,
      droplets: [],
      selectedDroplets: [],
      filtredDroplets: [],
      selectedFiltredDroplets: [],
      accounts: [],
      configLogs: "",
      logs: "",
      image: "linode/centos7",
      type: "g6-standard-1",
      token: "",
      booted: true,
      rootPass: "",
      errorMessage: "",
      username: "root",
      password: "vF7sExpCGn8V4DSm",
      email: "simosimo@mailnesia.com",
      from: "noreply@orange.com",
    };
  },
  beforeMount() {
    this.getRegions();
    this.fetchParamters();
  },
  computed: {
    testIpLable: function () {
      if (this.selectedDroplets.length > 1) {
        return "test ips";
      }
      return "test ip";
    },
    configIpLable: function () {
      if (this.selectedDroplets.length > 1) {
        return "config ips";
      }
      return "config ip";
    },
  },

  methods: {
    setTokens: function (e) {
      this.tokens = [];

      e.forEach((x) => {
        this.tokens.push({
          text: x.name,
          value: x.token,
        });
      });

      console.log(this.tokens);
    },
    onTokenChanged: function () {
      this.droplets = [];
      this.selectedDroplets = [];
      this.filtredDroplets = [];
      this.selectedFiltredDroplets = [];
      this.accounts.forEach((e) => {
        console.log(e);
        if (e.token == this.token) {
          this.rootPass = e.rootPass;
        }
      });
      this.fetchDroplets();
    },

    moveOneToFilted: function (drp) {
      var self = this;
      this.counter++;
      if (this.counter == 1) {
        this.timer = setTimeout(function () {
          self.filtredDroplets.push(drp);
          self.droplets.splice(self.droplets.indexOf(drp), 1);
          self.selectedDroplets.splice(self.droplets.indexOf(drp), 1);
          self.counter = 0;
        }, 200); // increase delay as you like
      } else {
        clearTimeout(this.timer);
        // COLUMN_DEFINITION[c]+=50
        self.counter = 0;
      }
    },
    moveOneToDroplets: function (drp) {
      var self = this;
      this.counter++;
      if (this.counter == 1) {
        this.timer = setTimeout(function () {
          self.droplets.push(drp);
          self.filtredDroplets.splice(self.filtredDroplets.indexOf(drp), 1);
          self.selectedFiltredDroplets.splice(self.filtredDroplets.indexOf(drp), 1);

          self.counter = 0;
        }, 200); // increase delay as you like
      } else {
        clearTimeout(this.timer);
        // COLUMN_DEFINITION[c]+=50
        self.counter = 0;
      }
    },
    getRegions: function () {
      const url = "https://api.linode.com/v4/regions";
      axios
        .get(url)
        .then((response) => {
          console.log(response.data.data);
          response.data.data.forEach((e) => {
            this.regions.push({ text: e.id, value: e.id });
          });
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    sendRebootRequest: function (droplet) {
      const dropletId = this.getDropletId(droplet);

      const url =
        "https://api.linode.com/v4/linode/instances/" + dropletId + "/reboot";

      const headers = {
        Authorization: "Bearer " + this.token,
      };
      axios
        .post(
          url,
          {},
          {
            headers: headers,
          }
        )
        .then((response) => {
          console.log(response);

          this.toast(
            "reboot",
            "droplet id : " + dropletId + " rebooted successfully",
            "success"
          );
        })
        .catch((error) => {
          console.log(error.response.data.errors[0].reason);
          this.toast(
            "Failed",
            "there an error accured when rebooting droplet id : " +
              dropletId +
              " with error : " +
              error.response.data.errors[0].reason,
            "danger"
          );
        });
      this.selectedDroplets = [];
    },
    unselectSelected: function () {
      this.selectedFiltredDroplets = [];
    },
    sendTestIpRequest: function (ip, username, password, subject, to, from) {
      const headers = {
        "x-api-key": this.$store.getters.apiKey,
        Authorization: "Bearer " + this.$store.getters.userToken,
      };
      const url = "http://cloud.iems.io/app/api/services/ips/testIp";
      this.$store.commit("pageLoader", { mode: "on" });

      const params = {
        ip: ip,
        username: username,
        password: password,
        subject: subject,
        to: to,
        from: from,
      };
      axios
        .post(url, params , {headers:headers})
        .then((response) => {
          console.log(response.data);
          this.toast("email sent", "send successfully", "success");
          this.logs = this.log + response.data;
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });

          this.logs = this.log + error.response.data;
          this.swalError("ops something went wrong");
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
        });
    },
    sendConfigIpRequest: function (ip, username, password) {
        const headers = {
        "x-api-key": this.$store.getters.apiKey,
        Authorization: "Bearer " + this.$store.getters.userToken,
      };
      const url = "http://cloud.iems.io/app/api/services/ips/configIp";
      this.$store.commit("pageLoader", { mode: "on" });

      const params = {
        ip: ip,
        username: username,
        password: password,
      };
      axios
        .post(url, params , {headers:headers})
        .then((response) => {
          console.log(response.data);
          this.toast(
            "Done",
            "server " + ip + " configured successfully",
            "success"
          );
          this.configLogs = this.configLogs + response.data;
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });

          this.configLogs = this.configLogs + error.response.data;
          this.swalError("ops something went wrong");
        })
        .finally(() => {
          this.$store.commit("pageLoader", { mode: "off" });
        });
    },
    testIp: function () {
      if (this.email == "") {
        this.swalError("email cannot be empty");
        return;
      }

      this.logs = "";
      this.selectedDroplets.forEach((e) => {
        this.data.forEach((d) => {
          if (d.id == parseInt(this.getDropletId(e))) {
            this.sendTestIpRequest(
              d.ipv4[0],
              this.username,
              this.password,
              "test-ip-" + d.ipv4[0],
              this.email,
              this.from
            );
          }
        });
      });
    },
    configIp: function () {
      this.configLogs = "";
      this.selectedDroplets.forEach((e) => {
        this.data.forEach((d) => {
          if (d.id == parseInt(this.getDropletId(e))) {
            this.sendConfigIpRequest(d.ipv4[0], this.username, this.password);
          }
        });
      });
    },
    reboteSelected: function () {
      this.swalConfirm(
        "are you sure!",
        "you are going to reboot " +
          this.selectedFiltredDroplets.length +
          " droplets",
        () => {
          console.log("reboot");
          this.selectedFiltredDroplets.forEach((e) => {
            this.sendRebootRequest(e);
          });
        }
      );
    },
    export: function () {},
    selectAllFilted: function () {
      this.selectedFiltredDroplets = this.filtredDroplets;
    },
    deleteAllFiltred: function () {},
    deleteSelectedFilted: function () {},
    fetchDroplets: function () {
      const url = "https://api.linode.com/v4/linode/instances?pageSize=" + 100;

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
          this.data = response.data.data;
          this.droplets = [];
          response.data.data.forEach((e) => {
            this.droplets.push(e.id + " | " + e.ipv4);
          });
          this.$store.commit("pageLoader", { mode: "off" });
        })
        .catch((error) => {
          this.$store.commit("pageLoader", { mode: "off" });

          this.swalError(error.response.data.errors[0].reason);
        });
    },
    getDropletId: function (droplet) {
      const data = droplet.split("|")[0].trim();
      return data;
    },
    sendDeleteDropletRequest: function (droplet) {
      const dropletId = this.getDropletId(droplet);

      const url = "https://api.linode.com/v4/linode/instances/" + dropletId;

      const headers = {
        Authorization: "Bearer " + this.token,
      };
      axios
        .delete(url, {
          headers: headers,
        })
        .then((response) => {
          console.log(response);
          this.droplets.splice(this.droplets.indexOf(dropletId), 1);
          this.toast(
            "deleted",
            "droplet id : " + dropletId + " deleted successfully",
            "success"
          );
        })
        .catch((error) => {
          console.log(error.response.data.errors[0].reason);
          this.toast(
            "Failed",
            "there an error accured when deleting droplet id : " +
              dropletId +
              " with error : " +
              error.response.data.errors[0].reason,
            "danger"
          );
        });
      this.selectedDroplets = [];
    },
    deleteAll: function () {
      this.swalConfirm(
        "are you sure",
        "you are going to delete " + this.droplets.length + " droplet",
        () => {
          this.droplets.forEach((e) => this.sendDeleteDropletRequest(e));
        }
      );
    },
    deleteSelected: function () {
      this.selectedDroplets.forEach((e) => {
        for (var d = 0; d <= this.droplets.length; d++) {
          if ((d = e)) {
            this.sendDeleteDropletRequest(d);
          }
        }
      });
    },
    test: function () {
      console.log("im working");
    },
    selectAll: function () {
      this.selectedDroplets = this.droplets;
    },
    unselectAll: function () {
      this.selectedDroplets = [];
    },
    moveDropletsToFiltedList: function () {
      this.droplets.forEach((e) => this.filtredDroplets.push(e));
      this.droplets = [];
      this.selectedDroplets = [];
    },
    moveSelectedDropletsToFiltedList: function () {
      this.selectedDroplets.forEach((e) => {
        for (var d = 0; d <= this.droplets.length; d++) {
          if ((d = e)) {
            this.filtredDroplets.push(d);
            this.droplets.splice(this.droplets.indexOf(d), 1);
          }
        }
      });
    },
    moveDropletsFromFiltedList: function () {
      this.filtredDroplets.forEach((e) => this.droplets.push(e));
      this.filtredDroplets = [];
      this.selectedFiltredDroplets = [];
    },
    moveSelectedDropletsFromFiltedList: function () {
      this.selectedFiltredDroplets.forEach((e) => {
        for (var d = 0; d <= this.filtredDroplets.length; d++) {
          if ((d = e)) {
            this.droplets.push(d);
            this.filtredDroplets.splice(this.filtredDroplets.indexOf(d), 1);
          }
        }
      });
    },
    copyDroplets() {
      console.log("copy action");
      document.execCommand("copy");
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
          this.token = response.data[0].token;
          this.maxDropletsPerRequest = response.data[0].token;
          this.rootPass = response.data[0].rootPass;

          this.accounts = response.data;
          this.setTokens(response.data);
          this.fetchDroplets();
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
    createDroplet: function () {
      const apiUrl = "https://api.linode.com/v4/linode/instances";

      const headers = {
        Authorization: "Bearer " + this.token,
      };
      const params = {
        type: this.type,
        image: this.image,
        root_pass: this.rootPass,
        region: this.selectedRegion,
        booted: true,
      };
      axios
        .post(apiUrl, params, {
          headers: headers,
        })
        .then((response) => {
          this.toast(
            "success",
            "droplet create with id : " + response.data.id,
            "success"
          );
          this.fetchDroplets();
        })
        .catch((error) => {
          console.log(error.response.data.errors[0].reason);

          this.toast(
            "Failed",
            "there an error accured when creating droplet " +
              error.response.data.errors[0].reason,
            "danger"
          );
          this.swalError(error.response.data.errors[0].reason);
        });
    },
    create: function () {
      if (this.dropletsCount > parseInt(this.maxDropletsPerRequest)) {
        this.swalError(
          "droplets count cannot be higher than " + this.maxDropletsPerRequest
        );
      } else {
        this.loading = !this.loading;

        for (var i = 1; i <= this.dropletsCount; i++) {
          this.createDroplet();
        }
        this.loading = !this.loading;
      }
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