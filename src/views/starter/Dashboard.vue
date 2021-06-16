<template>
  <div>
    <!-- Hero -->
    <div class="bg-body-light">
      <div class="content content-full">
        <div
          class="
            d-flex
            flex-column flex-sm-row
            justify-content-sm-between
            align-items-sm-center
            py-2
            text-center text-sm-left
          "
        >
          <div class="flex-sm-fill">
            <h1 class="h3 font-w700 mb-2">IEMS Dashboard</h1>
            <h2 class="h6 font-w500 text-muted mb-0">
              Welcome <a class="font-w600" href="javascript:void(0)">Admin</a>
            </h2>
          </div>
        </div>
      </div>
    </div>
    <!-- END Hero -->
    <div class="content">
      <h2 class="content-heading">Services</h2>
      <b-row>
        <b-col md="6" xl="3">
          <router-link :to="{ path: '/backend/linode/api' }">
            <base-block
              title="Linode"
              subtitle="service"
              href="javascript:void(0)"
              tag="a"
              class="service-card"
              rounded
              link-pop
            >
              <b-img
                class="push"
                src="https://cdn.freebiesupply.com/logos/large/2x/linode-logo-black-and-white.png"
                width="100"
              ></b-img>
            </base-block>
          </router-link>
        </b-col>

        <b-col md="6" xl="3">
          <router-link :to="{ path: '/backend/hetzner/api' }">
            <base-block
              title="Hetzner"
              subtitle="service"
              href="javascript:void(0)"
              tag="a"
              style="height: 320px"
              class="service-card"
              rounded
              link-pop
            >
              <b-img
                class="push"
                src="https://scdn1.plesk.com/wp-content/uploads/2016/08/19152622/hetzner-logo-clear-space.png"
                width="100"
              ></b-img>
            </base-block>
          </router-link>
        </b-col>
      </b-row>

      <h2 class="content-heading">Tools</h2>
      <b-row>
        <b-col md="6" xl="3">
          <router-link :to="{ path: '/backend/tools/spam-cause' }">
            <base-block
              title="Spam cause"
              subtitle="Tool"
              href="javascript:void(0)"
              tag="a"
              style="height: 320px"
              class="service-card"
              rounded
              link-pop
            >
              <b-img
                class="push"
                src="https://static.thenounproject.com/png/1531483-200.png"
                style="height: 50px"
              ></b-img>
            </base-block>
          </router-link>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {};
</script>


<style lang="scss" scoped>
.service-card {
  height: 130px !important;
}
</style>