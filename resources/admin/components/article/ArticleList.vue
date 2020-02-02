<template>
    <div>
        <Table border :columns="cols" :data="list" />
        <div class="page-wrapper">
            <Page show-total :total="total" size="small" :current="current" :page-size="pageSize" @on-page-size-change="handleSizeChange" @on-change="handleChange" show-elevator show-sizer />
        </div>
    </div>
</template>

<script>
    import {Table,Page,Button,Message} from "iview";
    import {api} from "../../utils/client";
    import config from "../../config"
    import Pager from "../../../helper/pager"

    export default {
        name: "ArticleList",
        components:{
            Table,Page
        },
        created(){
            this.getList();
        },
        data () {
            return {
                cols: [
                    {title: '标题',key: 'title',render:(h,params)=>{
                        let title=params['row']['title'],id=params['row']['id'];
                        return h(Button, {
                            props: {
                                type:'text',
                                size: 'small'
                            },
                            style: {
                                marginRight: '5px'
                            },
                            on: {
                                click:async ()=>{
                                    await this.$router.push({
                                        path:"/article/content",
                                        query:{id}
                                    });
                                }
                            }
                        }, title)
                    }},
                    {title: '栏目',key: 'module',render:(h,params)=>{
                        return h("span",[params.row.module&&params.row.module.title]);
                    }},
                    {title: '作者',key: 'nickname'},
                    {title: '公开',key: 'disabled',render:(h,params)=>{
                        let id=params['row']['id'],disabled=Boolean(params['row']&&params['row']['disabled']);
                        return h(Button,{
                            props: {
                                type: disabled?"default":"primary",
                                size: 'small'
                            },
                            style: {
                                marginRight: '5px'
                            },
                            on: {
                                click: () => {
                                    this.disabled(id,!disabled)
                                }
                            }
                        },disabled?"已发布":"未发布")
                    }},
                    {title: 'Action',key:'key',render:(h,params)=>{
                        let id = params['row']['id'];
                        return h('div', [
                            h(Button, {
                                props: {
                                    type: 'success',
                                    size: 'small'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click:async ()=>{
                                        await this.$router.push({
                                            path:"/article/operate",
                                            query:{id}
                                        });
                                    }
                                }
                            }, '修改'),
                            h(Button, {
                                props: {
                                    type: 'error',
                                    size: 'small'
                                },
                                on: {
                                    click: () => {
                                        this.remove(id)
                                    }
                                }
                            }, '删除')
                        ]);
                    }}
                ],
                list:[],
                current:1,
                pageSize:config['pageSize'],
                total:0,
            }
        },
        methods: {
            getList(pageIndex=0,pageSize=0){
                pageIndex = pageIndex?pageIndex:this.current;
                pageSize = pageSize?pageSize:this.pageSize;
                api.get("article",{pageIndex,pageSize}).then(res => {
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
            },
            remove(id){
                api.delete("article",id).then(async ()=>{
                    let pageIndex = Pager(Number(this.total-1),this.pageSize,this.pageIndex).current();
                    this.getList(pageIndex,this.pageSize);
                });
            },
            disabled(id,disabled){
                api.patch("article",{disabled:Number(disabled),id}).then(async () => {
                     this.list.find(i=>i.id===id)["disabled"]=disabled;
                });
            }
        }
    }
</script>

