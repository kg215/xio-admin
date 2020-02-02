<template>
    <el-dialog
        :visible.sync="dialogVisible"
        :before-close="close"
        width="80vw"
    >
        <template slot="title">
            <el-alert
                title="说句话试试"
                type="info"
                :closable="false"
            />
        </template>
        <chat-box :list="chatContent" :me="me" />
        <div slot="footer" class="dialog-footer">
            <div>
                <el-input
                    id="chat-send"
                    class="input-with-select"
                    placeholder="表害羞"
                    v-model="msg"
                    @keyup.enter.native="send"
                >
                </el-input>
            </div>
            <div class="o-sss">
                是是是，你说的是，我敢说不是么
            </div>
        </div>
    </el-dialog>
</template>

<script>
    import ChatBox from "./ChatBox";
    function dateFormat(date){
        return date.getFullYear()
            +"-"
            +(date.getMonth()+1)
            +"-"+date.getDate()
            +" "
            +date.getHours()
            +":"
            +date.getMinutes()
            +":"
            +date.getSeconds();
    }
    export default {
        name: "Chat",
        props: ["visible","close"],
        components:{
            "chat-box":ChatBox
        },
        data:function () {
            return {
                msg:"",
                time: dateFormat(new Date),
                me: 2,
                chatContent:[
                    {
                        uid:1,
                        name:"你的朋友",
                        headp:"public/images/tx.jpg",
                        msg: "发财了发财了"
                    },
                    {
                        uid:2,
                        name:"我",
                        headp:"public/images/tx-me.jpeg",
                        msg: "我也是"
                    }
                ]
            }
        },
        computed:{
            dialogVisible:function () {
                return this.visible;
            }
        },
        methods:{
            send:function(){
                console.log("event");
            }
        }
    }
</script>

<style scoped>
    .el-dialog{
        max-width: 800px;
    }
</style>
