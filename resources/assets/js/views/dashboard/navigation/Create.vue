<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">

        <el-form-item label="菜单名称" prop="name">
            <el-input size="small" v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="菜单路径" prop="url">
            <el-input size="small" v-model="myForm.url" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="排序" prop="sort">
            <el-input size="small" v-model="myForm.sort"></el-input>
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
                        {required: true, message: '菜单名称', trigger: 'blur'}
                    ],
                    url: [
                        {required: true, message: '链接地址', trigger: 'blur'}
                    ],
                },
                myForm: {
                    name: '',
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
                    axios.post('/api/navigation', para).then(function (response) {
                        _this.$message('添加成功');
                        _this.$router.push({path: '/navigation'});
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