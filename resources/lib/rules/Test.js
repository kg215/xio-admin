let makeVerify=reg=>target=>reg.test(target)
    ,verifyChat = makeVerify(/chat|\u804a/u) // 聊
    ,verifyEgg = makeVerify(/\u86cb|dan/u); // 蛋

function Verify(target,chain=false) {
    if(new.target === undefined){
        return new Verify(target,chain);
    }
    this._target = target;
    this._value = false;
    this._chain = chain;
    this._errors = new Set();
}
Verify.prototype.value = function(){
    return this._value;
};
Verify.prototype.chain = function(){
    this._chain = true;
    return this;
};
Verify.prototype.chat = function (str=void 0) {
    return this.factory(verifyChat,str);
};
Verify.prototype.egg = function (str=void 0) {
    return this.factory(verifyEgg,str);
};
Verify.prototype.factory = function (verify,str) {
    let txt = this._chain?this._target:str
        ,res = verify(txt);
    if(new.target&&!res){
        this._errors.add("chat invalid");
        this._value = res;
    }
    return this._chain?this:res;
};
function _mixin(v,t) {
    for(let key in v.prototype){
        if(v.prototype.hasOwnProperty(key)){
            t[key] = v.prototype[key];
        }
    }
}


function t(target) {
    if(target === undefined){
        return false;
    }
    return new Verify(target,true);
}
t.chain = function (target) {
    return t(target);
};

{
    _mixin(Verify,t);
}

export {
    t,
    Verify,
    makeVerify
};
