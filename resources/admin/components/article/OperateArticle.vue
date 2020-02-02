<template>
    <div>
        <Form ref="operateArticleForm" :model="form" :rules="rules" style="width: 400px;margin-bottom: 30px;" :label-width="80">
            <FormItem label="标题" prop="title">
                <Input v-model="form.title" />
            </FormItem>
            <FormItem label="栏目" prop="module_id">
                <Select v-model="form.module_id" clearable>
                    <Option v-for="item in moduleList"  :value="item.id" :key="item.id">{{ item.title}}</Option>
                </Select>
            </FormItem>
            <FormItem label="是否发布" prop="disabled">
                <i-switch v-model="form.disabled" :true-value="0" :false-value="1" />
            </FormItem>
        </Form>
        <div style="padding: 0 50px;">
            <vue-editor v-model="form.content">
            </vue-editor>
        </div>
        <div class="button-box">
            <Button :disabled="loader" type="primary" v-on:click="commit">提交</Button>
        </div>
    </div>
</template>

<script>
    import {Form,FormItem,Input,Select,Option,Button,Message,Switch} from "iview";
    import { VueEditor } from "vue2-editor";
    import { api } from "../../utils/client";

    let initForm = new Map(Object.entries({
        title:"",
        module_id:0,
        content:"",
        disabled:0
    }));

    export default {
        name: "OperateArticle",
        components:{
            VueEditor,Form,FormItem,Input,Select,Option,Button,"i-switch":Switch
        },
        created(){
            //获取分类
            api.get("module").then(({list}) => {
                this.moduleList = list;
            });
        },
        beforeRouteEnter(to,from,next){
            if(to.query.id){
                //编辑
                api.get("article",{id:[to.query.id]}).then(function ({list=[]}={}) {
                    let article = list[0];
                    next(vm=>{
                        vm.form["id"] = article["id"];
                        vm.form["title"] = article["title"];
                        vm.form["module_id"] = article["module_id"];
                        vm.form["content"] = article["content"]&&article["content"]["content"];
                    });
                });
            }else{
                //添加走这里
                next(vm=>vm.form = Object.fromEntries(initForm.entries()));
            }
        },
        data(){
            return {
                form:Object.fromEntries(initForm.entries()),
                rules:{
                    title:[
                        { required: true, message: '标题不能为空', trigger: 'blur' }
                    ],
                    content:[
                        { required: true, message: '文章内容不能为空', trigger: 'blur' }
                    ]
                },
                loader:false,
                moduleList:[]
            }
        },
        methods:{
            commit(){
                this.$refs["operateArticleForm"].validate((valid) => {
                    if (valid) {
                        this.loader = true;
                        api.pick("article",this.form).then(()=>{
                            if(!this.form.id){
                                this.form=Object.fromEntries(initForm.entries());
                            }
                        }).finally(()=>this.loader=false);
                    }
                });
            }
        }
    }
</script>
<style scoped>
    .button-box{
        padding: 20px;
        margin-left: 30px;
    }
</style>
