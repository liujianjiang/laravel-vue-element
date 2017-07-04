<template>
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
                <span class="el-dropdown-link userinfo-inner"><img :src="this.sysUserAvatar" /> larlence</span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item>我的消息</el-dropdown-item>
                    <el-dropdown-item>设置</el-dropdown-item>
                    <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </el-col>
    </el-col>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        methods: mapActions([
            'toggle'
        ])
    }
</script>

<style lang="scss" scoped>
#repbar {
  margin-left: -15px;
}

.navbar-nav {
  li {
    a {
      padding-top: 0px;
      padding-bottom: 0px;
      line-height: 60px;
    }
  }
}

.navbar-toggle {
    margin: 0;
    font-size: 20px;
    text-decoration: none;
    padding: 13px 10px;
    border: 0;
    color: #777;
    cursor: pointer;
}
.navbar-inverse .navbar-toggle:hover {
    border: 0;
    border-radius: 0;
    background-color: #fff !important;
    text-decoration: none;
    color: #888;
}
</style>
