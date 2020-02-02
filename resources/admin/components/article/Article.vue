<template>
    <div>
        <div class="operator">
            <Menu mode="horizontal" theme="light" :active-name="this.$router.currentRoute.path">
                <router-link :to="{path:'/article/list'}">
                    <MenuItem name="/article/list">
                        <Icon type="ios-list-box-outline" />
                        列表
                    </MenuItem>
                </router-link>
                <router-link :to="{path:'/article/operate'}">
                    <MenuItem name="/article/operate">
                        <Icon type="ios-create" />
                        编辑
                    </MenuItem>
                </router-link>
            </Menu>
        </div>
        <keep-alive>
            <router-view v-if='$route.meta.keepAlive'></router-view>
        </keep-alive>
        <router-view v-if='!$route.meta.keepAlive'></router-view>
    </div>
</template>

<script>
    import {Tag,Menu,MenuItem,Icon} from "iview";
    export default {
        name: "Article",
        components:{
            Tag,Menu,MenuItem,Icon
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
