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
                    name: [
                        {required: true, message: '请输入标题', trigger: 'blur'}
                    ],
                    email: [
                        {required: true, message: '请输入邮箱', trigger: 'blue'}
                    ]
                },
                myForm: {
                    name: '',
                    display_name: '',
                    description: '',
                },
            }
        },
        created() {
            if (this.$route.params.id != undefined) {
                this.getById(this.$route.params.id);
            }
            let _this = this;
            axios.get('/api/role').then(function (response) {
                _this.options = response.data.data

            })
        },
        methods: {

            getById: function (id) {
                this.listLoading = true;
                axios.get('api/role/'+ id +'/edit').then((response) => {
                    this.myForm = response.data.data
                    console.log(this.myForm)
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
                axios.put('api/role/' + _this.myForm.id, _this.myForm).then(function(response) {
                    _this.$message('修改成功');
                    _this.$router.push({path: '/admin/role'});
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

