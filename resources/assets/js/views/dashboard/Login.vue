<template>
    <el-form :model="form" :rules="formRules" ref="form" label-position="left" label-width="0px" class=" login-container">
        <h3 class="title">系统登录</h3>
        <el-form-item prop="email">
            <el-input type="text" v-model="form.email" auto-complete="on" placeholder="账号"></el-input>
        </el-form-item>
        <el-form-item prop="password">
            <el-input type="password" v-model="form.password" auto-complete="on" placeholder="密码"></el-input>
        </el-form-item>
        <el-checkbox v-model="checked" class="remember">记住密码</el-checkbox>
        <el-form-item>
            <el-button type="primary" style="width:100%;" @keyup.enter="loginSubmit" @click.native.prevent="loginSubmit" :loading="logining">登录</el-button>
        </el-form-item>
    </el-form>
</template>

<script type="text/ecmascript-6">

    export default {
        data() {
            return {
                logining: false,
                form: {
                    email: '',
                    password: ''
                },
                formRules: {
                    email: [
                        {required: true, type: "email", message: '请填写用户名', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '请填写密码', trigger: 'blur'},
                        {min: 6, max: 64, message: '密码长度在 6 到 64 个字符', trigger: 'blur'}
                    ]
                },
                checked: false
            };
        },
        methods: {
            loginSubmit() {
                var _this = this;
                var _duration = 2 * 1000;
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        this.logining = true;
                        let loginParams = { email: this.form.email, password: this.form.password,remember: this.checked };
                        axios.post('/api/auth/login',loginParams).then(function(response){

                            sessionStorage.setItem('user', JSON.stringify(response.data.user));

                            _this.$message({message: response.data.msg, type:'success', duration: _duration});

                            setTimeout(function () {_this.$router.push({path: '/dashboard'})}, _duration)

                        }).catch(function (error) {

                            _this.$message.error(error.response.data.msg);

                            _this.logining = false;
                        });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        },

    }

</script>

<style lang="scss" scoped>
    .login-container {
        /*box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);*/
        -webkit-border-radius: 5px;
        border-radius: 5px;
        -moz-border-radius: 5px;
        background-clip: padding-box;
        margin: 180px auto;
        width: 350px;
        padding: 35px 35px 15px 35px;
        background: #fff;
        border: 1px solid #eaeaea;
        box-shadow: 0 0 25px #cac6c6;
    .title {
        margin: 0px auto 40px auto;
        text-align: center;
        color: #505458;
    }
    .remember {
        margin: 0px 0px 35px 0px;
    }
    }
</style>