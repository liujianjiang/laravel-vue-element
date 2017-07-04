<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">
            <el-form-item label="标签" prop="tag">
                <el-input v-model="myForm.tag" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="标题" prop="title">
                <el-input v-model="myForm.title" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="描述" prop="meta_description">
                <el-input type="textarea" v-model="myForm.meta_description"></el-input>
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
                    tag: [
                        {required: true, message: '请输入标签', trigger: 'blur'}
                    ],
                    title: [
                        {required: true, message: '请输入路径', trigger: 'blur'}
                    ],
                },
                myForm: {
                    tag: '',
                    path: '',
                    description: ''
                },
            }
        },
        created() {

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
                    axios.post('/api/tag', para).then(function (response) {
                        _this.$message('添加成功');
                        _this.$router.push({path: '/tag'});
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