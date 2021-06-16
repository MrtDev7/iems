/*
 * Default Router
 */

// Vue and Vue Router
import Vue from 'vue'
import Router from 'vue-router'

// Main layouts
import LayoutBackend from '@/layouts/variations/Backend.vue'
// import LayoutBackendBoxed from '@/layouts/variations/BackendBoxed.vue'
// import LayoutSimple from '@/layouts/variations/Simple.vue'

// Register Vue Router
Vue.use(Router)

// Frontend Page Example
const Landing = () => import("@/views/starter/Landing.vue")

// Backend Page Example
const Dashboard = () => import("@/views/starter/Dashboard.vue")

// linode pages 

const LinodeInstants = () => import("@/views/pages/linode/Instances.vue")
const LinodeAccounts = () => import("@/views/pages/linode/Accounts.vue")
const LinodeApi = () => import("@/views/pages/linode/Api.vue")

// hetzner pages 
const HetznerInstants = () => import("@/views/pages/hetzner/Instances.vue")
const HetznerAccounts = () => import("@/views/pages/hetzner/Accounts.vue")
const HetznerApi = () => import("@/views/pages/hetzner/Api.vue")

// tools
const SpamCause = () => import("@/views/pages/tools/SpamCause.vue")


// auth
const Login = ()=> import("@/views/pages/auth/SignIn.vue")

import store from '../store'

// Router Configuration
export default new Router({
  linkActiveClass: 'active',
  linkExactActiveClass: '',
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'welcome',
      component: Landing
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      beforeEnter (to, from, next) {
        if (!store.state.user.token) {
          next()
        } 
        else {
          next('/backend/dashboard')
        }
      },
    },
    {
      path: 'dashboard',
      name: 'Dashboard',
      component: Dashboard
    },
    {
      path: '/backend',
      beforeEnter (to, from, next) {
        if (store.state.user.token) {
          next()
        } 
        else {
          next('/login')
        }
      },
      component: LayoutBackend,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
        },

        {
          path: 'linode/',
          redirect: 'backend/linode/instances',
          component: {
            render(c) { return c('router-view') }
          },
          children: [
            {
              path: 'api/',
              name: 'linode api',
              component: LinodeApi
            },
            {
              path: 'instances/',
              name: 'create linode',
              component: LinodeInstants
            },
            {
              path: 'accounts/',
              name: 'linode account',
              component: LinodeAccounts
            },

          ]
        },

        {
          path: 'hetzner/',
          redirect: '/backend/hetzner/instances',
          component: {
            render(c) { return c('router-view') }
          },
          children: [
            {
              path: 'api/',
              name: 'hetzner api',
              component: HetznerApi
            },
            {
              path: 'instances/',
              name: 'create server',
              component: HetznerInstants
            },
            {
              path: 'accounts/',
              name: 'hetzner accounts',
              component: HetznerAccounts
            },

          ]
        },
        {
          path: 'tools/',
          redirect: '/tools/spam-cause',
          component: {
            render(c) { return c('router-view') }
          },
          children: [
            {
              path: 'spam-cause/',
              name: 'linode api',
              component: SpamCause
            },
          

          ]
        },

      ]
    }
    ,
    {
      path:'*',
      name:'notFound',
      redirect: '/backend/dashboard',
    }
  ]
})