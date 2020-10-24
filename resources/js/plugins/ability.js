import Vue from 'vue';
import { abilitiesPlugin } from '@casl/vue';
//import ability from './services/ability';
import ability from './defineAbility';
 
Vue.use(abilitiesPlugin, ability);

export default ability
 
/* import Vue from 'vue';
import abilitiesPlugin from '@casl/vue';

const defineAbilitiesFor = require('./defineAbility');
let user = { id: 1, name: 'George' };
let ability = defineAbilitiesFor(user.id);
Vue.use(abilitiesPlugin, ability); */

