import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name:"home",
            path:'/',
            component: resolve =>resolve(require('./components/Index')),
            children:[
                {
                    name:"general-egg",
                    path:'general-egg',
                    component: resolve =>resolve(require('./components/egg/GeneralEgg'))
                },
                {
                    name:"orient-egg",
                    path:'orient-egg',
                    component: resolve =>resolve(require('./components/egg/OrientEgg'))
                },
                {
                    name:"krypton-gold-egg",
                    path:'krypton-gold-egg',
                    component: resolve =>resolve(require('./components/egg/KryptonGoldEgg'))
                }
            ]
        },
    ]
});

