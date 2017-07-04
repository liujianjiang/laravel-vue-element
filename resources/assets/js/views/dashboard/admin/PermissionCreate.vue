<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" class="form-horizontal col-md-9 col-md-offset-1">
        <el-form-item label="所属权限组" prop="fid">
            <el-select v-model="myForm.fid" placeholder="请选择">
                <el-option key="0" label="顶级分类" value="0"></el-option>
                <el-option
                        v-for="item in options"
                        :key="item.id"
                        :label="item.display_name"
                        :value="item.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="权限路由" prop="name">
            <el-input v-model="myForm.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="显示名称" prop="display_name">
            <el-input v-model="myForm.display_name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="说明" prop="description">
            <el-input v-model="myForm.description" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="是否是菜单">
            <el-radio class="radio" v-model="myForm.is_menu" label="1">是</el-radio>
            <el-radio class="radio" v-model="myForm.is_menu" label="0">否</el-radio>
        </el-form-item>
        <el-form-item label="排序" prop="sort">
            <el-input v-model="myForm.sort" auto-complete="off"></el-input>
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
                    fid: '',
                    name: '',
                    display_name: '',
                    description: '0',
                    is_menu: [],
                    sort: '',
                },
            }
        },
        created() {
            this.getTopPermissions();
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
                    axios.post('/api/permission', para).then(function (response) {
                        _this.$message('添加成功');
                        _this.$router.push({path: '/admin/permission'});
                    }).catch(function (error) {

                        console.log(error.response.data)
                    });

                })
            },

            getTopPermissions: function () {
                let _this = this;
                axios.get('/api/permission/toppermissions').then(function (response) {
                    console.log(response);
                    _this.options = response.data.data
                })
            }

        },
        mounted() {



        },
    }
</script>

<style lang="scss">
    .el-upload input{
        display: none;
    }

</style>