import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import axios from '~/plugins/axios'
import i18n from '~/plugins/i18n'
import fontawesome from '~/plugins/fontawesome'
//import ability from '~/plugins/ability'
import App from '~/components/App'
import Gate from "./Gate"


import '~/plugins'
import '~/components'

Vue.config.productionTip = false;

Vue.prototype.$gate = new Gate(window.user);
//window.user = @json(auth()->user())
/* eslint-disable no-new */
new Vue({
  axios,
  i18n,
  fontawesome,
  //ability,
  store,
  router,
  ...App
})

//const ability = require('./defineAbility');

// console.log('can read Post', ability.can('read', 'Post')) // true
// console.log('can read User', ability.can('read', 'User')) // true
// console.log('can update User', ability.can('update', 'User')) // true
// console.log('can delete User', ability.can('delete', 'User')) // false
// console.log('cannot delete User', ability.cannot('delete', 'User')) // true
// console.log('cannot update User', ability.cannot('update', 'User')) // false
// console.log('can manage all', ability.can('manage', 'Test')) // true
// console.log('User ID -->', Auth::user()->id)
//windows.user = Auth::user()->name