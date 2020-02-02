import Vue from "vue";
import ElementUI from "element-ui";
import 'element-ui/lib/theme-chalk/index.css';
import router from "./router";
import VueAxios from 'vue-axios';
import App from "./components/App";
Vue.use(ElementUI);
Vue.use(VueAxios);

const app = new Vue({
    el:"#app",
    router,
    render:h=>h(App)
});
