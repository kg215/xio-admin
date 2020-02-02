<template>
    <el-container>
        <el-aside>
            <el-row class="tac">
                <el-col :offset="2" :span="20">
                    <h5>Home</h5>
                    <el-menu
                        default-active="2"
                        class="el-menu-vertical-demo">
                        <el-submenu index="1">
                            <template slot="title">
                                <i class="fa fa-gift fa-lg" aria-hidden="true"></i>
                                <span>发彩蛋</span>
                            </template>
                            <el-menu-item-group>
                                <router-link :to="{path:'general-egg'}">
                                    <el-menu-item index="1-1">普通彩蛋</el-menu-item>
                                </router-link>
                                <router-link :to="{path:'orient-egg'}">
                                    <el-menu-item index="1-2">定向彩蛋</el-menu-item>
                                </router-link>
                                <router-link :to="{path:'krypton-gold-egg'}">
                                    <el-menu-item index="1-3">氪金彩蛋</el-menu-item>
                                </router-link>
                            </el-menu-item-group>
                        </el-submenu>
                    </el-menu>
                </el-col>
            </el-row>
        </el-aside>
        <el-main>
            <router-view></router-view>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "Index"
    }
</script>

