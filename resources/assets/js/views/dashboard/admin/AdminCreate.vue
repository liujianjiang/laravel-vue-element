<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" class="form-horizontal col-md-9 col-md-offset-1">
        <el-form-item label="所属组" prop="roles">
            <el-checkbox-group v-model="myForm.roles" :key="item.id" v-for="item in options">
                <el-checkbox :label="item.id">{{item.display_name}}</el-checkbox>
            </el-checkbox-group>
        </el-form-item>
        <el-form-item label="名称" prop="name">
            <el-input v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="邮箱" prop="email">
            <el-input v-model="myForm.email" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="password">
            <el-input type="password" v-model="myForm.password" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="图片" prop="image">
            <el-upload
                    class="avatar-uploader"
                    action="api/file/upload"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                <img v-if="myForm.avatar" :src="myForm.avatar" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
        </el-form-item>
        <el-form-item label="超级管理员">
            <el-radio class="radio" v-model="myForm.is_super" label="1">是</el-radio>
            <el-radio class="radio" v-model="myForm.is_super" label="0">否</el-radio>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" size="large" @click.native="onSubmit('myForm')">保存</el-button>
        </el-form-item>
    </el-form>
</template>

<script>

    export default {
        data(){
            return {
                options: [],
                myFormRules: {
                    name: [
                        {required: true, message: '请输入标题', trigger: 'blur'}
                    ],
                    email: [
                        {required: true, message: '请输入邮箱', trigger: 'blur'}
                    ],
                },
                myForm: {
                    name: '',
                    email: '',
                    password: '',
                    is_super: '0',
                    roles: [],
                    avatar: '',
                },
            }
        },
        created() {
            this.getRole();
        },
        methods: {
            onSubmit: function(myForm) {
                let _this = this
                this.$refs[myForm].validate((valid) => {
                    if(!valid){
                        console.log('form valid error.');
                        return false
                    }

                    let para = Object.assign({}, _this.myForm);
                    axios.post('/api/admin', para).then(function (response) {
                        _this.$message('添加成功');
                        _this.$router.push({path: '/admin'});
                    }).catch(function (error) {

                        console.log(error.response.data)
                    });

                })
            },
            handleAvatarSuccess(res, file) {
                this.myForm.avatar = URL.createObjectURL(file.raw);
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            getRole: function () {
                let _this = this;
                axios.get('/api/role').then(function (response) {
                    _this.options = response.data.data
                })
            }

        },
        mounted() {



        },
    }
</script>

<style lang="scss">
    .el-upload input{
        display: none;
    }

</style>