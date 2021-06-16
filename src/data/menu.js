/*
 * Main and demo navigation arrays
 */

export default {
  'main': [
    {
      name: 'Dashboard',
      to: '/backend/dashboard',
      icon: 'si si-speedometer'
    },
    {
      name: 'linode',
      icon: 'si si-layers',
      subActivePaths: '/backend/linode',
      sub: [
        {
          name: 'Instances',
          to: '/backend/linode/instances'
        },
        {
          name: 'Api',
          to: '/backend/linode/api'
        },
        {
          name: 'Accounts',
          to: '/backend/linode/accounts'
        },

      ]
    },
    {
      name: 'hetzner',
      icon: 'fa fa-hospital-symbol',
      subActivePaths: '/backend/hezner',
      sub: [
        {
          name: 'Instances',
          to: '/backend/hetzner/instances'
        },
        {
          name: 'Api',
          to: '/backend/hetzner/api'
        },
        {
          name: 'Accounts',
          to: '/backend/hetzner/accounts'
        },

      ]
    },


    {
      name: 'tools',
      icon: 'si si-wrench',
      subActivePaths: '/backend/tools',
      sub: [
        {
          name: 'Spam cause',
          to: '/backend/tools/spam-cause'
        },
        

      ]
    },
  ],

}
