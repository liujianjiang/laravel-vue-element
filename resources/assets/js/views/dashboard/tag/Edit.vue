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
            getById: function (id) {
                this.listLoading = true;
                axios.get('api/tag/'+ id +'/edit').then((response) => {
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
                        axios.put('api/tag/' + _this.myForm.id, this.myForm).then(function(response) {
                            _this.$message('修改成功');
                            _this.$router.push({path: '/tag'});
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