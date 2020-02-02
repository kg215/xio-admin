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
    import config from "../../config";
    import Pager from "../../../helper/pager";
    import OperateModule from "./OperateModule";
    export default {
        name: "ModuleList",
        components:{
            Table,Page,OperateModule
        },
        created(){
            this.getList();
        },
        data () {
            return {
                cols: [
                    {title: '标题',key: 'title'},
                    {title: '描述',key: 'desc'},
                    {title: '创建时间',key: 'created_at'},
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
                                            path:"/module/operate",
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
                totalPage:0
            }
        },
        methods: {
            getList(pageIndex=0,pageSize=0){
                pageIndex = pageIndex?pageIndex:this.current;
                pageSize = pageSize?pageSize:this.pageSize;
                api.get("module",{pageIndex,pageSize}).then(res => {
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
                api.delete("module",id).then(async ()=>{
                    await Message.success("删除成功");
                    let pageIndex = Pager(Number(this.total-1),this.pageSize,this.pageIndex).current();
                    this.getList(pageIndex,this.pageSize);
                });
            }
        }
    }
</script>

