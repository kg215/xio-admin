<template>
    <div class="login-box">
        <el-form ref="login-form"  :model="form" :rules="rules" label-width="100px">
            <el-form-item label="用户名" prop="name">
                <el-input required placeholder="注册在哪里丫~在哪里丫~" v-model="form.name" />
            </el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input type="password" required auto-complete="new-password" @keydown.enter.native="submitForm" :placeholder="tips" v-model="form.password" />
            </el-form-item>
            <el-form-item v-if="showType" label="[root@? ?]#">
                <el-input v-model="form.type" @keydown.enter.native="submitForm" placeholder="login || register || enter" />
            </el-form-item>
        </el-form>
    </div>

</template>

<script>
    import {RulesStore,ApplyTips,empty,min} from "../../../lib/rules";
    let rulesStore=RulesStore({
        name:ApplyTips("用户名")(empty,min(10))
    });
    console.log(rulesStore.validate("name","aa"));

    export default {
        name: "Login",
        data(){
            function validateName(rule,value,cb) {

            }
            function validatePass(rule,value,cb) {
                console.log(rule,value,cb);
            }

            return {
                form:{
                    name:void 0,
                    password:void 0,
                    type:void 0
                },
                rules:{
                    name:[
                        {validator: validateName, trigger: 'blur'}
                    ],
                    password:[
                        {validator: validatePass, trigger: 'blur'}
                    ]
                }
            }
        },
        computed:{
            showType(){
                return this.form.name&&this.form.password
            },
            tips(){
                return this.form.name?"都输好了才能给你看":"";
            }
        },
        methods:{
            submitForm:function () {
                this.$refs['login-form'].validate(valid=>{

                });
            }
        }
    }
</script>
<style scoped>
    .login-box{
        width: 80%;
        margin: 0 auto;
    }
</style>
