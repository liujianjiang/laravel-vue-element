<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">

        <el-form-item label="评论内容" prop="content_raw">
            <el-input type="textarea" v-model="myForm.content_raw"></el-input>
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
                    content_raw: [
                        {required: true, message: '请输入内容', trigger: 'blur'}
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
                axios.get('api/comment/'+ id +'/edit').then((response) => {
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
                        axios.put('api/comment/' + _this.myForm.id, this.myForm).then(function(response) {
                            _this.$message('修改成功');
                            _this.$router.push({path: '/comment'});
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