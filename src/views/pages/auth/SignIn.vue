<template>
  <!-- Page Content -->
  <div class="hero-static d-flex align-items-center">
    <div class="w-100">
      <!-- Sign In Section -->
      <div class="bg-white">
        <div class="content content-full">
          <b-row class="justify-content-center">
            <b-col md="8" lg="6" xl="4" class="py-4">
              <!-- Header -->
              <div class="text-center">
                <p class="mb-2">
                  <i class="fa fa-2x fa-circle-notch text-primary"></i>
                </p>
                <h1 class="h4 mb-1">IEMS</h1>
              </div>
              <!-- END Header -->

              <!-- Sign In Form -->
              <b-form @submit.stop.prevent="onSubmit">
                <div class="py-3">
                  <div class="form-group">
                    <b-form-input
                      size="lg"
                      class="form-control-alt"
                      id="username"
                      name="username"
                      placeholder="Username"
                      v-model="$v.form.username.$model"
                      :state="!$v.form.username.$error && null"
                      aria-describedby="username-feedback"
                    ></b-form-input>
                  </div>
                  <div class="form-group">
                    <b-form-input
                      type="password"
                      size="lg"
                      class="form-control-alt"
                      id="password"
                      name="password"
                      placeholder="Password"
                      v-model="$v.form.password.$model"
                      :state="!$v.form.password.$error && null"
                      aria-describedby="password-feedback"
                    ></b-form-input>
                  </div>
                </div>
                <b-row class="form-group row justify-content-center mb-0">
                  <b-col md="6" xl="5">
                    <b-button type="submit" variant="primary" block>
                      <span v-if="!loading"><i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In</span
              ><b-spinner
                v-if="loading"
                small
                variant="white"
                label="Loading..."
              ></b-spinner
            >
                      
                    </b-button>
                  </b-col>
                </b-row>
              </b-form>
              <!-- END Sign In Form -->
            </b-col>
          </b-row>
        </div>
      </div>
      <!-- END Sign In Section -->

      <!-- Footer -->
      <div class="font-size-sm text-center text-muted py-3">
        <strong>{{
          $store.getters.appName + " " + $store.getters.appVersion
        }}</strong>
        &copy; {{ $store.getters.appCopyright }}
      </div>
      <!-- END Footer -->
    </div>
  </div>
  <!-- END Page Content -->
</template>

<script>
// Vuelidate, for more info and examples you can check out https://github.com/vuelidate/vuelidate
import { validationMixin } from "vuelidate";
import { required, minLength } from "vuelidate/lib/validators";
import router from '../../../router';

import axios from "axios";

export default {
  mixins: [validationMixin],
  data() {
    return {
      loading: false,
      form: {
        username: null,
        password: null,
      },
    };
  },
  validations: {
    form: {
      username: {
        required,
        minLength: minLength(3),
      },
      password: {
        required,
        minLength: minLength(5),
      },
    },
  },
  methods: {
    
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
    login(authdata) {
      
      this.loading = true;

      const headers = {
        'x-api-key': this.$store.getters.apiKey,
      };


    
      axios
        .post(
          "http://cloud.iems.io/app/api/auth/login",
          {
            username: authdata.username,
            password: authdata.password,
          },
          {
          headers: headers,
        }
        )
        .then((res) => {
          localStorage.setItem("token", res.data.data.token);

          this.toast("Welcome", "login successfully", "success");
          this.loading = false;
          router.go(0)
        })
        .catch((error) => {
          this.toast("Error", error.response.data.message, "danger");
          this.loading = false;
        });
    },
    onSubmit() {
      this.$v.form.$touch();

      if (this.$v.form.$anyError) {
        return;
      }

      this.login({
        username: this.form.username,
        password: this.form.password,
      });
    },
  },
};
</script>
