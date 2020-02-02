<template>
    <div>
        <osoc />
        <el-container>
            <el-header style="height: 4rem">
                <el-row>
                    <el-col :span="20" :offset="2">
                        <div class="grid-content bg-purple-light">
                            <div class="o-hr">
                                输入点啥好
                            </div>
                        </div>
                    </el-col>
                    <el-col :span="2" class="who-box">
                        <span class="o-work-keeper" @click="login">
                            登陆
                        </span>
                    </el-col>
                </el-row>
            </el-header>
            <el-main>
                <div class="surprise-search say-some">
                    <el-input
                        placeholder="输入彩蛋试一试 ~~~"
                        class="input-with-select"
                        v-model="search"
                        @keyup.enter.native="enter"
                        autofocus
                    >
                    </el-input>
                </div>
            </el-main>
        </el-container>
        <ochat :visible="ochatVisible" :close="close" />
        <el-dialog title="登陆" class="login-width" :visible.sync="loginVisible">
            <login />
        </el-dialog>
    </div>
</template>

<script>
    import Osoc from "./Osoc";
    import Chat from "./Chat";
    import Login from "./whobox/Login";
    import {t} from "../../lib/rules/Test"
    export default {
        name: "Index",
        data:function () {
            return {
                search:"",
                tooltip:false,
                ochatVisible:false,
                loginVisible:false,
                stop:false,
                stopMsg:false,
            }
        },
        components:{
            osoc:Osoc,
            ochat:Chat,
            login:Login
        },
        mounted:function(){

        },
        methods:{
            enter() {
                if(this.stop) return ;
                let hit = false;
                this.ochatVisible=hit=t.chat(this.search);
                if(!hit&&!this.stopMsg&&t.egg(this.search)){
                    this.stopMsg=true;
                    this.$message({
                        message: '开发中...',
                    });
                    setTimeout(()=>this.stopMsg=false,3000)
                }
            },
            close(){
                this.ochatVisible=false;
            },
            login(){
                console.log("fdf");
                this.loginVisible=!this.loginVisible;
            }
        }
    }


</script>

<style>
    .el-input__inner{
        border-left: none;
        border-top: none;
        border-right: none;
        border-radius: unset;
    }
    .el-alert{
        width: 90%;
        margin: 0 auto;
    }
    .dialog-footer{
        width: 95%;
        margin: 0 auto;
    }
    .login-width .el-dialog{
        width: 80vw;
        max-width: 520px;
    }
</style>
