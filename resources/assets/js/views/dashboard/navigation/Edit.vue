<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">
        <el-form-item label="菜单名称" prop="name">
            <el-input v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="菜单路径" prop="url">
            <el-input v-model="myForm.url" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="排序" prop="description">
            <el-input v-model="myForm.sort"></el-input>
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

                },
            }
        },
        created() {
            if (this.$route.params.id != undefined) {
                this.getById(this.$route.params.id);
            }
        },
        methods: {
            getById: function (id) {
                this.listLoading = true;
                axios.get('api/navigation/'+ id +'/edit').then((response) => {
                    this.myForm = response.data.data
                })
            },
            onSubmit: function(myForm) {
                let _this = this
                this.$refs[myForm].validate((valid) => {
                    if(!valid){
                        console.log('form valid error.');
                        return false
                    }
                    axios.put('api/navigation/' + _this.myForm.id, this.myForm).then(function(response) {
                        _this.$message('修改成功');
                        _this.$router.push({path: '/navigation'});
                    }).catch (function (error) {
                        console.log(error.response.data)
                    })
                })
            },
        },
        mounted() {

        },
    }
</script>

<style lang="scss">


</style>