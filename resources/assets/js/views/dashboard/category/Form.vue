<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">
        <el-form-item label="名称" prop="name">
            <el-input v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="路径" prop="path">
            <el-input v-model="myForm.path" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="描述" prop="description">
            <el-input type="textarea" v-model="myForm.description"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" size="large" @click.native="onSubmit('myForm')">保存</el-button>
        </el-form-item>
    </el-form>
</template>
<script type="text/ecmascript-6">
    import { error_warning } from '../../../config/helper'
    export default {
        props: {
            myForm: {
                type: Object,
                default() {
                    return {}
                }
            }
        },
        data(){
            return {
                myFormRules: {
                },
            }
        },
        methods: {
            onSubmit: function(myForm) {
                let _this = this
                let url = 'api/category' + (this.myForm.id ? '/' + this.myForm.id : '')
                let method = this.myForm.id ? 'patch' : 'post'

                this.$refs[myForm].validate((valid) => {

                    if(!valid){
                        console.log('form valid error.');
                        return false
                    }

                    let para = Object.assign({}, _this.myForm);

                    axios({method: method, url: url, data: para}).then(function (response) {

                        _this.$notify({title: '成功', type: 'success', message: response.data.message})
                        _this.$router.push({path: '/category'});

                    }).catch(function (error) {
                        error_warning(error.response.data);
                    });

                })
            },

        },

    }
</script>
