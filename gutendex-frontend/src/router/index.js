import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import BookList from '../pages/BookList.vue'
import BookDetail from '../pages/BookDetail.vue'
import Categories from '../pages/Categories.vue'
import Search from '../pages/Search.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/books', component: BookList },
  { path: '/books/:id', component: BookDetail },
  { path: '/categories', component: Categories },
  { path: '/search', component: Search },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
