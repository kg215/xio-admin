<template>
    <div class="layout">
        <Layout>
            <Header>
                <Row>
                    <Col span="10">
                        <span class="header-logo">
                            kaxio
                        </span>
                    </Col>
                    <Col span="1" offset="13">
                        <a @click="logout" title="退出登录" style="color:#FFFFFF;">
                            <Icon type="md-log-out" />
                        </a>
                    </Col>
                </Row>
            </Header>
            <Layout>
                <Sider hide-trigger :style="{background: '#FFFFFF'}">
                    <Menu theme="light" :active-name="activeName">
                        <MenuGroup title="内容管理">
                            <router-link :to="{path:'/article/list'}">
                                <MenuItem name="article">
                                    <Icon type="md-document" />
                                        文章管理
                                </MenuItem>
                            </router-link>
                            <router-link :to="{path:'/module/list'}">
                                <MenuItem name="module">
                                    <Icon type="logo-buffer" />
                                    栏目管理
                                </MenuItem>
                            </router-link>
                            <router-link :to="{path:'/comment'}">
                                <MenuItem name="comment">
                                    <Icon type="md-chatbubbles" />
                                    评论管理
                                </MenuItem>
                            </router-link>
                        </MenuGroup>
                        <MenuGroup title="用户管理">
                            <MenuItem name="4">
                                <Icon type="md-heart" />
                                用户留存
                            </MenuItem>
                            <MenuItem name="5">
                                <Icon type="md-leaf" />
                                流失用户
                            </MenuItem>
                        </MenuGroup>
                        <MenuGroup title="系统管理">
                            <MenuItem name="6">
                                <Icon type="ios-cog" />
                                网站配置
                            </MenuItem>
                            <MenuItem name="7">
                                <Icon type="md-images" />
                                轮播图
                            </MenuItem>
                            <MenuItem name="8">
                                <Icon type="md-link" />
                                友情链接
                            </MenuItem>
                        </MenuGroup>
                    </Menu>
                </Sider>
                <Layout>
                    <Content>
                        <div style="background: #fff;padding: 0 25px 20px 25px;">
                            <router-view></router-view>
                        </div>
                    </Content>
                </Layout>
            </Layout>
        </Layout>
    </div>
</template>

<script>
    import {api} from "../utils/client";
    import {Layout,Header,Menu,MenuItem,Content,Submenu,Icon,Sider,MenuGroup,Row,Col} from "iview";

    export default {
        name: "Index",
        components: {
            Layout,Header,Menu,MenuItem,Content,Submenu,Icon,Sider,MenuGroup,Row,Col
        },
        computed:{
            activeName(){
                return this.$router.currentRoute.path.split("/").filter(Boolean).shift();
            }
        },
        methods:{
            logout(){
                api.logout();
            }
        }
    }
</script>

