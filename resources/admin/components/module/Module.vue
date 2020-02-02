<template>
    <div>
        <div class="operator">
            <Menu mode="horizontal" theme="light" :active-name="this.$router.currentRoute.path">
                <router-link :to="{path:'/module/list'}">
                    <MenuItem name="/module/list">
                        <Icon type="ios-list-box-outline" />
                        列表
                    </MenuItem>
                </router-link>
                <router-link :to="{path:'/module/operate'}">
                    <MenuItem name="/module/operate">
                        <Icon type="ios-create" />
                        编辑
                    </MenuItem>
                </router-link>
            </Menu>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    import {Tag,Menu,MenuItem,Icon} from "iview";

    export default {
        name: "Module",
        components:{
            Tag,Menu,MenuItem,Icon
        },
        mounted(){
            this.$router.currentRoute.path==="/module"&&this.$router.push("/module/list");
        }
    }
</script>

<style scoped>
    .operator{
        padding-bottom: 20px;
    }
    .ivu-tag-text>a{
        color: #636b6f;
    }
</style>
