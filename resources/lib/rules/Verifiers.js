import _ from 'loadsh';

let isMsg = tip=>startsWith("_msg:")

    ,isEmpty = value=>value===""
    ||value===null
    ||value===undefined
    ||Object.keys(value).length===0;


export const empty = tip=>value=>{
    if(isEmpty(value)){
        return isMsg(tip)?tip:tip+"不能为空";
    }
    return false;
};

export const min = opt => tip => value =>{
    const val = Number(value);
    if(Number.isNaN(val)){
        return value+"不是数字";
    }
    opt = Number(opt);
    if(val<=opt){
        return isMsg(tip)?tip:`${tip}不能小于${opt}`;
    }
    return false;
};


