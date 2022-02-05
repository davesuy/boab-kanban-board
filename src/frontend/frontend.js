import Vue from 'vue'
import Vuex from 'vuex'
import Router from 'vue-router'
import store from '../store/index'
import App from './App.vue'
import KanbanBoard from './components/pages/KanbanBoard.vue'
import VueRouter from 'vue-router'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.use( Vuex )
Vue.use( Router )

const routes = [
    {
        path: '/', components: { default: KanbanBoard  },
    }
]

const router = new VueRouter({
    routes,
})

new Vue({
    el: '#bkb-frontend-app',
    store,
    router,
    render: h => h( App ),
    propsData: { taskData }
})