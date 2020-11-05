import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import NotFound from '@/components/NotFound'

// Layouts
import Layout1 from '@/layout/Layout1'

Vue.use(Router)
Vue.use(Meta)

const router = new Router({
  base: '/',
  mode: 'history',
  routes: [{
    path: '/',
    component: Layout1,
    children: [{
      path: '',
      name: 'tickets',
      component: () => import('@/components/Tickets')
    }]
  }, {
    // 404 Not Found page
    path: '*',
    component: NotFound
  }]
})

export default router
