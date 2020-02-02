<template>
    <div style="padding-top: 35px;">
        <Table border :columns="cols" :data="list" />
        <div class="page-wrapper">
            <Page show-total :total="total" size="small" :current="current" :page-size="pageSize" @on-page-size-change="handleSizeChange" @on-change="handleChange" show-elevator show-sizer />
        </div>
    </div>
</template>

<script>
    import {Table,Button,Page} from "iview";
    import {api} from "../../utils/client";
    import config from "../../config";
    export default {
        name: "Comment",
        components:{
            Table,Page
        },
        created(){
            this.getList();
        },
        data(){
            return {
                cols:[
                    {key:"title",title:"文章",render(h,params){
                        return h("span",[params["row"]["article"]["title"]]);
                    }},
                    {key:"content",title:"评论"},
                    {key:"nickname",title:"用户"},
                    {key:"created_at",title:"评论时间"},
                    {key:"disabled",title:"是否屏蔽",render:(h,params)=>{
                            let disabled = params["row"]["disabled"],id = params["row"]["id"];
                        return h(Button,{
                            props:{
                                type:disabled?"default":"success",
                                size:"small"
                            },
                            on:{
                                click:()=>{
                                    api.patch("comment/update",{id,disabled:Number(!disabled)})
                                        .then(()=>{
                                            this.list.find(i=>i.id===id)["disabled"]=!disabled;
                                        });
                                }
                            }
                        },disabled?"是":"否");
                    }}
                ],
                list:[],
                current:1,
                pageSize:config['pageSize'],
                total:0,
            }
        },
        methods:{
            getList(pageIndex=0,pageSize=0){
                pageIndex = pageIndex?pageIndex:this.current;
                pageSize = pageSize?pageSize:this.pageSize;
                api.get("comment",{pageIndex,pageSize}).then(res => {
                    this.list = res.list || [];
                    this.total = res.total;
                    this.pageIndex = pageIndex;
                    this.pageSize = pageSize;
                });
            },
            handleChange(index){
                this.getList(index,this.pageSize);
            },
            handleSizeChange(pageSize){
                this.getList(this.current,pageSize);
            }
        }
    }
</script>

<style scoped>

</style>
