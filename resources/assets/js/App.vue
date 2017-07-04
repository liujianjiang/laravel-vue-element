<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>
<script type="text/ecmascript-6">

  export default{
    name: 'app',
    data(){
      return {
        user: JSON.parse(sessionStorage.getItem('token'))
      }

    },
    methods: {

      authLogin: function () {
        let _this = this;

        let user = JSON.parse(sessionStorage.getItem('user'));

        axios.post('/api/auth/check').then(function (response) {
          //console.log(response.data.auth);
          if (response.data.auth == 'Unauthenticated') {

            _this.$notify.error({title: '错误', message: '非法操作'});

            _this.$router.push({path: '/login'});

          }

        }).catch(function (error) {
          console.log(error);
        });

      }
    },
    created: function () {
      if(this.$route.path != '/login'){
        this.authLogin();
      }

    }

  }
</script>
<style lang="scss">

  body {
    margin: 0px;
    padding: 0px;
    font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
    font-size: 14px;
    -webkit-font-smoothing: antialiased;
  }

  #app {
    position: absolute;
    top: 0px;
    bottom: 0px;
    width: 100%;
  }

  .el-submenu [class^=fa] {
    vertical-align: baseline;
    margin-right: 10px;
  }

  .el-menu-item [class^=fa] {
    vertical-align: baseline;
    margin-right: 10px;
  }

  .toolbar {
    background: #f2f2f2;
    padding: 10px;
    margin: 10px 0px;
  .el-form-item {
    margin-bottom: 10px;
  }
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: all .2s ease;
  }

  .fade-enter,
  .fade-leave-active {
    opacity: 0;
  }
</style>