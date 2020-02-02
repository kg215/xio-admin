import Vue from "vue";
import ElementUI from "element-ui";
import 'element-ui/lib/theme-chalk/index.css';
import router from "./router";
import Home from "./components/Home";
Vue.use(ElementUI);

const app = new Vue({
    el:"#home",
    router,
    render:h=>h(Home)
});
