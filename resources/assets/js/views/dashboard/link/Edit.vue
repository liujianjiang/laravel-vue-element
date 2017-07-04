<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">
        <el-form-item label="名称" prop="name">
            <el-input v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="链接" prop="link">
            <el-input v-model="myForm.link" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="图片" prop="image">
            <el-upload
                    class="avatar-uploader"
                    action="api/file/upload"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                <img v-if="myForm.image" :src="myForm.image" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
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
                myFormRules: {
                    name: [
                        {required: true, message: '请输入标题', trigger: 'blur'}
                    ],
                   path: [
                        {required: true, message: '请输入路径', trigger: 'blue'}
                    ]
                },
                myForm: {

                },
            }
        },
        created() {
            if (this.$route.params.id != undefined) {
                this.getById(this.$route.params.id);
            }
        },
        methods: {
            handleAvatarSuccess(res, file) {
                this.myForm.image = URL.createObjectURL(file.raw);
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
            getById: function (id) {
                this.listLoading = true;
                axios.get('api/link/'+ id +'/edit').then((response) => {
                    this.myForm = response.data.data
                })
            },
            onSubmit: function(myForm) {
                    let _this = this;
                    _this.$refs[myForm].validate((valid) => {
                        if(!valid){
                            console.log('form valid error.');
                            return false
                        }
                        console.log(this.myForm);
                        axios.put('api/link/' + _this.myForm.id, _this.myForm).then(function(response) {
                                _this.$message('修改成功');
                                _this.$router.push({path: '/link'});
                        }).catch (function (error) {
                                console.log(error)
                        })
                    })
            },
        },
        mounted() {

        },
    }
</script>

<style lang="scss">
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>