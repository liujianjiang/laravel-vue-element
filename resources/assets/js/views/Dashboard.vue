<template>
    <el-row class="container">
        <el-col :span="24" class="header">
            <el-col :span="10" class="logo" :class="collapsed?'logo-collapse-width':'logo-width'">
                {{collapsed?'':sysName}}
            </el-col>
            <el-col :span="10">
                <div class="tools" @click.prevent="collapse">
                    <i class="fa fa-align-justify"></i>
                </div>
            </el-col>
            <el-col :span="4" class="userinfo">
                <el-dropdown trigger="hover">
                    <span class="el-dropdown-link userinfo-inner"><img :src="this.sysUserAvatar" /> {{sysUserName}}</span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>我的消息</el-dropdown-item>
                        <el-dropdown-item>设置</el-dropdown-item>
                        <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </el-col>
        </el-col>
        <el-col :span="24" class="main">
            <aside :class="collapsed?'menu-collapsed':'menu-expanded'">
                <!--<el-menu :default-active="$route.path" class="el-menu-vertical-demo" @open="handleopen" @close="handleclose" @select="handleselect" unique-opened router v-show="!collapsed">-->
                <el-menu default-active="$route.path" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose">
                    <template v-for="(item,index) in $router.options.routes" v-if="!item.hidden">
                        <el-submenu :index="index+''" v-if="!item.leaf">
                            <template slot="title"><i :class="item.iconCls"></i>{{item.name}}</template>
                            <li v-for="child in item.children" class="el-menu-item" @click="$router.push(child.path)" :class="$route.path==child.path?'is-active':''" v-if="!child.hidden">{{child.name}}</li>
                        </el-submenu>
                        <el-menu-item v-if="item.leaf&&item.children.length>0"  @click="$router.push(item.children[0].path)" :index="item.children[0].path" :class="$route.path==item.children[0].path?'is-active':''"><i :class="item.iconCls"></i>{{item.children[0].name}}</el-menu-item>
                    </template>
                </el-menu>

                <!--导航菜单-折叠后-->
                <ul class="el-menu el-menu-vertical-demo collapsed" v-show="collapsed" ref="menuCollapsed">
                    <li v-for="(item,index) in $router.options.routes" v-if="!item.hidden" class="el-submenu item">
                        <template v-if="!item.leaf">
                            <div class="el-submenu__title" style="padding-left: 20px;" @mouseover="showMenu(index,true)" @mouseout="showMenu(index,false)"><i :class="item.iconCls"></i></div>
                            <ul class="el-menu submenu" :class="'submenu-hook-'+index" @mouseover="showMenu(index,true)" @mouseout="showMenu(index,false)">
                                <li v-for="child in item.children" v-if="!child.hidden" class="el-menu-item" style="padding-left: 40px;" :class="$route.path==child.path?'is-active':''" @click="$router.push(child.path)">{{child.name}}</li>
                            </ul>
                        </template>
                        <template v-else>
                    <li class="el-submenu">
                        <div class="el-submenu__title el-menu-item" style="padding-left: 20px;height: 56px;line-height: 56px;padding: 0 20px;" :class="$route.path==item.children[0].path?'is-active':''" @click="$router.push(item.children[0].path)"><i :class="item.iconCls"></i></div>
                    </li>
</template>
</li>
</ul>
</aside>
<section class="content-container">
    <div class="grid-content bg-purple-light">
        <el-col :span="24" class="breadcrumb-container">
            <strong class="title">{{$route.name}}</strong>
            <el-breadcrumb separator="/" class="breadcrumb-inner">
                <el-breadcrumb-item :key="item" v-for="item in $route.matched">
                    {{ item.name }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </el-col>
        <el-col :span="24" class="content-wrapper">
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </el-col>
    </div>
</section>
</el-col>
</el-row>
</template>


<script>
    import { mapActions } from 'vuex';
    import Headerbar from '../components/dashboard/particals/HeaderBar.vue';
    export default {
        components:{
            Headerbar,
            //Navbar,
            //FooterBar
        },
        data() {
        return {
            sysName:'VUEADMIN',
            collapsed:false,
            sysUserName: '',
            sysUserAvatar: '',
            form: {
                name: '',
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: ''
            }
        }
    },
    created: function () {
        // `this` 指向  vm实例

    },
    methods: {
        onSubmit() {
            console.log('submit!');
        },
        handleOpen(key, keyPath) {
            console.log(key, keyPath);
        },
        handleClose(key, keyPath) {
            console.log(key, keyPath);
        },
        handleselect: function (a, b) {
        },

        //折叠导航栏
        collapse:function(){
            this.collapsed=!this.collapsed;
        },
        showMenu(i,status){
            this.$refs.menuCollapsed.getElementsByClassName('submenu-hook-'+i)[0].style.display=status?'block':'none';
        },
        //退出登录
        logout: function () {
            var _this = this;
            var _duration = 2 * 1000;
            this.$confirm('确认退出吗 ?', '提示', {
            }).then(() => {
                axios.post('/api/auth/logout').then(function (response) {
                    let data = response.data;
                    if (data.status == 200) {
                        sessionStorage.removeItem('user');
                        _this.$message({
                            message: data.msg,
                            type:'success',
                            duration: _duration
                        });
                        setTimeout(function () {
                            _this.$router.replace('/login');
                        }, _duration);
                    } else {
                        _this.$message.error("退出失败");
                    }
                }).catch(function (error) {
                    _this.$message.error("退出失败");
                    console.log(error);
                });
            }).catch(() => {
            });
        },
    },

    mounted() {

        //var user = sessionStorage.getItem('user');
        var user = window.User;

        if (user) {
            console.log(user);
            //user = JSON.parse(user);

            this.sysUserName = user.name || '';
            this.sysUserAvatar = user.avatar || '';
        }

    }
    }

</script>



<style lang="scss">
    .container {
        position: absolute;
        top: 0px;
        bottom: 0px;
        width: 100%;
        margin-right: auto;
        margin-left: auto;
        padding-left: 0px;
        padding-right: 0px;
    .header {
        height: 60px;
        line-height: 60px;
        background: #464c5b;
        color:#fff;
    .userinfo {
        text-align: right;
        padding-right: 35px;
        float: right;
    .userinfo-inner {
        cursor: pointer;
        color:#fff;
    img {
        width: 40px;
        height: 40px;
        border-radius: 20px;
        margin: 10px 0px 10px 10px;
        float: right;
    }
    }
    }
    .logo {
    //width:230px;
        height:60px;
        font-size: 22px;
        padding-left:20px;
        padding-right:20px;
        border-color: rgba(238,241,146,0.3);
        border-right-width: 1px;
        border-right-style: solid;
    img {
        width: 40px;
        float: left;
        margin: 10px 10px 10px 18px;
    }
    .txt {
        color:#fff;
    }
    }
    .logo-width{
        width:230px;
    }
    .logo-collapse-width{
        width:60px
    }
    .tools{
        padding: 0px 23px;
        width:14px;
        height: 60px;
        line-height: 60px;
        cursor: pointer;
    }
    }
    .main {
        display: flex;
    // background: #324057;
        position: absolute;
        top: 60px;
        bottom: 0px;
        overflow: hidden;
    aside {
        flex:0 0 230px;
        width: 230px;
    // position: absolute;
    // top: 0px;
    // bottom: 0px;
    .el-menu{
        height: 100%;
    }
    .collapsed{
        width:60px;
    .item{
        position: relative;
    }
    .submenu{
        position:absolute;
        top:0px;
        left:60px;
        z-index:99999;
        height:auto;
        display:none;
    }

    }
    }
    .menu-collapsed{
        flex:0 0 60px;
        width: 60px;
    }
    .menu-expanded{
        flex:0 0 230px;
        width: 230px;
    }
    .content-container {
    //background-color: rgba(0,0,0,0.3);
        background-color: #FFFFFF;
        flex:1;
    // position: absolute;
    // right: 0px;
    // top: 0px;
    // bottom: 0px;
    // left: 230px;
        overflow-y: scroll;
        padding: 20px;
    .breadcrumb-container {
    //margin-bottom: 15px;
    .title {
        width: 200px;
        float: left;
        color: #475669;
    }
    .breadcrumb-inner {
        float: right;
    }
    }
    .content-wrapper {
        background-color: #fff;
        box-sizing: border-box;
    }
    }
    }
    }
</style>