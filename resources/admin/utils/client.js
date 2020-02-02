import {Message} from "iview";
import axios from "axios";
import router from "../router";
import {Url} from "../../helper/url";

/**
 * 拦截response
 */
axios.interceptors.response.use(res => res, function({response}) {
    let {status,data} = response;
    let {error=null} = data;
    if(status===401){
        localStorage.removeItem("login");
        /* 权限验证失败 */
        router.push("/login");
    }
    if(status===422){
        /* 参数验证失败 */
        let warn = Object.values(error||data).join("\n\s") || "";
        Message.warning(warn);
    }
    /* 把错误统一返回给调用者 */
    return Promise.reject(response);
});

/**
 * ajax万能调用
 * @param {*} url
 * @param {*} param1
 */
async function ajax(action,params,method="get",{
    headers={}
}={}) {
    let url = Url.api(action),
    isData = ["post","patch","put"].includes(method.toLocaleLowerCase());
    const { data: { data } } = await axios({
        method: method,
        url,
        data: isData ? params : null,
        headers,
        params: isData ? null : params,
    });
    return data;
}

/**
 * api对象
 * @param {*} action
 * @param {*} data
 * @param {*} method
 * @param {*} headers
 */
function api(action,data,method="GET",headers={}){
    return ajax(action,data,method,{headers});
}
/**
 * 获取list
 */
api.get = function (action,data,config) {
    return ajax(action,data,"GET",config);
};

api.post = function (action,data,config) {
    return ajax(action,data,"POST",config);
};

/**
 * 删除
 */
api.delete = async function (action,id,config) {
    const r = await ajax(action + "/" + id, {}, "DELETE", config);
    Message.success("删除成功");
    return r;
};
/**
 * 更新put|patch
 */
api.put = async function (action,data={id:""},config) {
    let id = data.id;
    const r = await ajax(action + "/" + id, data, "PUT", config);
    Message.success("修改成功");
    return r;
};
/**
 * 更新patch|put
 */
api.patch = async function (action,data={id:""},config) {
    let id = data.id;
    let r=await ajax(action+"/"+id,data,"PUT",config);
    Message.success("修改成功");
    return r;
};
/**
 * 创建和编辑同页面的时候，方便选择是编辑还是添加
 */
api.pick = async function(action,data={id:""},config){
    let id = data.id;
    const r = await (id ? this.put(action, data, config) : this.post(action, data, config));
    !id && Message.success("添加成功");
    return r;
};

/**
 * 登陆
 * @param {name:string,password:string} data
 */
api.login = async function (data={}){
    await this.post("admin/login", data);
    localStorage.setItem("login",true);
    location.replace(location.pathname);
};

/**
 * 登出
 */
api.logout = async function(){
    await this.get("admin/logout");
    localStorage.removeItem("login");
    router.push("/login");
};

export {api};


