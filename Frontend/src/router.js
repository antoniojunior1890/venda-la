import Vue from 'vue'
import Router from 'vue-router'

import Home from './components/Home'
import Login from './components/Login'

import IndexProduct from './components/Product/Index'
import CreateProduct from './components/Product/Create'
import ViewProduct from './components/Product/View'

import IndexKit from './components/Kit/Index'
import CreateKit from './components/Kit/Create'
import ViewKit from './components/Kit/View'

import store from './store.js'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [{
        path: '/',
        component: Home,
        name: 'home'
    },{
        path: '/kit',
        name: 'kit',
        component: IndexKit,
    },{
        path: '/kit/create',
        name: 'kit-create',
        component: CreateKit,
    },{
        path: '/kit/view/:id',
        name: 'view-kit',
        component: ViewKit,
        props: true,
    },{
        path: '/product',
        name: 'product',
        component: IndexProduct,
    },{
        path: '/product/create',
        name: 'product-create',
        component: CreateProduct,
    },{
        path: '/product/view/:id',
        name: 'view-product',
        component: ViewProduct,
        props: true,
    },{
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '*',
        redirect: '/'
    }
]
})

router.beforeEach((to, from, next) => {
    if(to.path != 'login' && to.path != 'home' ){
        if(!store.state.token && to.path !== '/login'){
            next('/login')
        }
    }
    next()
})

export default router