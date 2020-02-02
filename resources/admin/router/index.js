import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

let router=new VueRouter({
    saveScrollPosition:true,
    routes:[
        {
            name:"Login",
            path:"/login",
            component:resolve=>resolve(require('../components/user/Login'))
        }
    ]
});

export {dynamicRoutes};
let dynamicRoutes =[
    {
        name:'Admin',
        path:'/',
        component: resolve =>resolve(require('../components/Index')),
        redirect:"article/list",
        children:[
           {
                name:"Article",
                path:"article",
                component: resolve =>resolve(require('../components/article/Article')),
                children: [
                    {
                        name:'Article List',
                        path:'list',
                        component: resolve =>resolve(require('../components/article/ArticleList'))
                    },{
                        name:'Operate Article',
                        path:'operate',
                        component: resolve =>resolve(require('../components/article/OperateArticle')),
                        meta: {
                            keepAlive: true
                        }
                    },{
                        name:'Article Content',
                        path:'content',
                        component: resolve =>resolve(require('../components/article/Content')),
                    }
                ]
            },{
                name:"Module",
                path:"module",
                component: resolve =>resolve(require('../components/module/Module')),
                children: [
                    {
                        name:'Module List',
                        path:'list',
                        component: resolve =>resolve(require('../components/module/ModuleList'))
                    },
                    {
                        name:'Operate Article Module',
                        path:'operate',
                        component: resolve =>resolve(require('../components/module/OperateModule')),
                        meta: {
                            keepAlive: true
                        }
                    }
                ]
            },{
                name:"Comment",
                path:"comment",
                component: resolve =>resolve(require('../components/comment/Comment')),
            }
        ]
    }
];


// router.beforeEach((to, from, next) => {
//     next({ path: '/login' });
// });

export default  router;
