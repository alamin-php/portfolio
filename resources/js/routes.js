export let routes = 
[
    {path: '/user',component: require('./components/admin/UserComponent.vue').default},
    {path: '/tag',component: require('./components/admin/TagComponent.vue').default},
    {path: '/category',component: require('./components/admin/CategoryComponent.vue').default},
    {path: '/post',component: require('./components/admin/PostComponent.vue').default},
]