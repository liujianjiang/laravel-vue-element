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
                    link: [
                        {required: true, message: '请输入链接', trigger: 'blur'}
                    ],
                },
                myForm: {

                },
            }
        },
        created() {

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
            onSubmit: function(myForm) {
                let _this = this
                this.$refs[myForm].validate((valid) => {
                    if(!valid){
                        console.log('form valid error.');
                        return false
                    }

                    let para = Object.assign({}, _this.myForm);
                    axios.post('/api/link', para).then(function (response) {
                        _this.$message('添加成功');
                        _this.$router.push({path: '/link'});
                    }).catch(function (error) {
                        console.log(error.response.data)
                    });

                })
            },


        },
        mounted() {



        },
    }
</script>

<style lang="scss">


</style>