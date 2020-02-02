import Vue from "vue";
import ElementUI from 'element-ui';
import router from "./router";
import Admin from './components/Admin';
import 'element-ui/lib/theme-chalk/index.css';
import 'iview/dist/styles/iview.css';
Vue.use(ElementUI);

new Vue({
    el: '#admin',
    router,
    render: h => h(Admin)
});




