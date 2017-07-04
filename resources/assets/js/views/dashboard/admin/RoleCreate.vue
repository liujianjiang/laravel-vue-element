<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" class="form-horizontal col-md-9 col-md-offset-1">
        <el-form-item label="角色标识" prop="name">
            <el-input v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="角色名称" prop="display_name">
            <el-input v-model="myForm.display_name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="说明" prop="description">
            <el-input v-model="myForm.description" auto-complete="off"></el-input>
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

                },
                myForm: {
                    name: '',
                    display_name: '',
                    description: '',
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
                    axios.post('/api/role', para).then(function (response) {
                        _this.$message('添加成功');
                        _this.$router.push({path: '/admin/role'});
                    }).catch(function (error) {
                        _this.$notify.error({
                            message: error.response.data.message
                        });
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