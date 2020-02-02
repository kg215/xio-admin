<template>
    <div class="ql-container">
        <div class="ql-bubble ql-snow">
            <div class="ql-editor" v-html="content"></div>
        </div>
    </div>
</template>

<script>
    import {api} from "../../utils/client";

    export default {
        name: "Content",
        beforeRouteEnter(to,from,next){
            api.get("article",{id:[to.query.id]}).then(function ({list=[]}={}) {
                next(vm=>vm.article=list[0]);
            });
        },
        data(){
            return {
                article:{}
            };
        },
        computed:{
            content(){
                return this.article.content&&this.article.content.content;
            }
        }
    }
</script>

<style lang="css">
    @import "~vue2-editor/dist/vue2-editor.css";
    @import '~quill/dist/quill.core.css';
    @import '~quill/dist/quill.bubble.css';
    @import '~quill/dist/quill.snow.css';
</style>
