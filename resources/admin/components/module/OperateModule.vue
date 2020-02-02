<template>
    <div>
        <Form ref="operateModuleForm" :model="form" :rules="rules" style="width: 400px;margin-bottom: 30px;" :label-width="80">
            <FormItem label="标题" prop="title">
                <Input v-model="form.title" />
            </FormItem>
            <FormItem label="描述" prop="desc">
                <Input type="textarea" v-model="form.desc" />
            </FormItem>
            <FormItem>
                <Button :disabled="loading" type="primary" v-on:click="commit">提交</Button>
            </FormItem>
        </Form>
    </div>
</template>

<script>
    import {Form,FormItem,Input,Button,Message} from "iview";
    import { api } from "../../utils/client";

    let initForm = new Map(Object.entries({
        title:"",
        desc:"",
    }));

    export default {
        name: "OperateArticle",
        components:{
            Form,FormItem,Input,Button
        },
        beforeRouteEnter(to,from,next){
            if(to.query.id){
                //编辑
                api.get("module",{id:[to.query.id]}).then(function ({list=[]}={}) {
                    let r = list[0];
                    next(vm=>{
                        vm.form["id"] = r["id"];
                        vm.form["title"] = r["title"];
                        vm.form["desc"] = r["desc"];
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
                    ]
                },
                loading:false
            }
        },
        methods:{
            commit(){
                let _this = this;
                this.$refs["operateModuleForm"].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        api.pick("module",this.form).then(function(){
                            if(!_this.form.id){
                                _this.form=Object.fromEntries(initForm.entries());
                            }
                        }).finally(()=>this.loading=false);
                    }
                });

            }
        }
    }
</script>

