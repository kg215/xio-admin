export {
    buildFromData,
    buildQuery
};

/**
 * 构造query数据
 * @param {*} data
 * @param {*} key
 */
function buildQuery(data=void 0,key=void 0) {
    if(!data||Object.keys(data).length===0){
        return "";
    }
    return Object.entries(data).map(item=>{
        if(typeof item[1]==="object" && item[1]!==null){
            return buildQuery(item[1],item[0]);
        }
        if(key){
            return key+"["+item[0]+"]"+"="+item[1];
        }
        return item.join("=");
    }).join("&");
}
/**
 * 将{}数据转为formdata
 * @param {*} data
 */
function buildFromData(data) {
    let formData = new FormData();
    Object.keys(data).forEach(key=>{
        formData.append(key,data[key]);
    });
    return formData;
}

