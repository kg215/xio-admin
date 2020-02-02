export {Url};

function Url(action=void 0,chain=false,api=false) {
    if(new.target===undefined){
        return new Url(action,chain,api);
    }
    this._chain = chain;
    this._origin = window.document.location.origin+"/index.php";
    this._api="/api";
    this._isApi=api;
    this._apiToken="TOEFSAADKSLJLAGYJGNFGTREGLDA";
    this.action = action.startsWith("/")?action:"/"+action;
    this.url = this._origin+this.action;
    let apiUrl = this._origin+this._api+this.action;
    this.apiUrl =  apiUrl+(apiUrl.includes("?")?"":"?") + "api_token="+this._apiToken;
};
Url.prototype.value = function(){
    return this._isApi?this.apiUrl:this.url;
};

Url.api=function(action){
    const instance = new Url(action,false,true);
    return instance._chain?instance:instance.value();
};
