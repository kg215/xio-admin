<template>
    <div class="login">
        <div class="login-box">
            <div class="login-header">
                <div class="logo">
                    kaxio
                </div>
            </div>
            <div class="login-form">
                <el-form :model="form" label-position="left" label-width="100px">
                    <el-form-item label="用户名">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="密码">
                        <el-input type="password" v-model="form.password"></el-input>
                    </el-form-item>
                </el-form>
                <div class="submit" @click="login">
                    提交
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {api} from "../../utils/client";
    
    export default {
        name:"Login",
        data(){
            return {
                form:{
                    name:"",
                    password:""
                }
            }
        },
        methods:{
            login(){
                api.login(this.form);
            }
        }
    }
</script>


<style scoped>
    .login{
        display: flex;
        flex: 1;
        height: 100%;
        background-image: linear-gradient(#7da0ea,#526da9,#9ac7db);
        position: relative;
    }

    .login-box{
        display: flex;
        flex-direction: column;
        width: 480px;
        position: absolute;
        background: #FFFFFF;
        top:50%;
        left: 50%;
        transform: translate(-50%,-50%);
        font-size: 14px;
        border-radius: 5px;
        box-shadow: #526da9 1px 1px 10px 10px;
        padding: 20px 0;
    }
    .login-header{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-self: center;
    }
    .logo{
        width: 70px;
        height: 70px;
        line-height: 70px;
        text-align: center;
        border-radius: 100%;
        background: #bff7f6;
        box-shadow: #b8e6ff 1px 1px 16px 3px;
    }
    .login-form{
        width: 70%;
        margin: 20px auto;
    }
    .submit{
        text-align: center;
        cursor: pointer;
        width: 45px;
        margin: 0 auto;
        height: 45px;
        line-height: 45px;
        border-radius: 45px;
        background: #BFDCF9;
        color: #FFFFFF;
        transition: width .8s ease;
    }
    .submit:hover{
        width: 60%;
    }
</style>
