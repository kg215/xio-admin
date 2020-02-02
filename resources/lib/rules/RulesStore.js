
const RulesStore = rules=>{
    return {
        validate(field,value){
            if(!field){return console.error("field不能为空");}
            let verifyFuncs = rules[field];
            if (typeof verifyFuncs === "function") {
                let res = verifyFuncs(value);
                return res ? [res] : [];
            }

            if (Array.isArray(verifyFuncs)) {
                return verifyFuncs.reduce(function (all, verify) {
                    let res = verify(value);
                    if (res) {
                        all.push(res);
                    }
                    return all;
                }, []);
            }

            //todo 输入字符串规则进行验证
            if (typeof verifyFuncs === "string") {
                console.log('string');
            }
        }
    };
};

const ApplyTips = tip => (...validators) => {
    return validators.map(validate=>validate(tip));
};

export {
    RulesStore,
    ApplyTips
};

