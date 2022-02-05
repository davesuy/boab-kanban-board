import Vue from 'vue'
import Vuex from 'vuex'
import Router from 'vue-router'
import store from '../store/index'
import App from './App.vue'
import Settings from './components/pages/Settings.vue'
import KanbanBoard from './components/pages/KanbanBoard.vue'
import Test from './components/pages/test.vue'
import TabNavigation from './components/tabs/Navigation.vue'
import GeneralTab from './components/tabs/GeneralTab.vue'
import AnotherTab from './components/tabs/AnotherTab.vue'
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
        path: '/', components: { default: GeneralTab, tab: TabNavigation, settings: Settings  },
    },
    {
        path: '/another', components: { default: AnotherTab, tab: TabNavigation },
    },
    {
        path: '/settings', components: { default: Settings },
    },
    {
        path: '/kanban-board', components: { default: KanbanBoard },
    },
    {
        path: '/test', components: { test: Test },
    }
]

const router = new VueRouter({
    routes,
})


new Vue({
    el: '#bkb-admin-app',
    store,
    router,
    render: h => h( App ),
    propsData: { taskData }
})