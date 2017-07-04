<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" class="form-horizontal col-md-9 col-md-offset-1">
        <el-form-item label="所属权限组" prop="fid">
            <el-select v-model="myForm.fid" placeholder="请选择">
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
        <el-form-item label="是否是菜单" prop="description">
            <el-select v-model="myForm.is_menu" placeholder="请选择">
                <el-option label="是" value="是"></el-option>
                <el-option label="否" value="否"></el-option>
            </el-select>
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

            if (this.$route.params.id != undefined) {
                this.getById(this.$route.params.id);
            }


        },
        methods: {

            getById: function (id) {
                this.listLoading = true;
                axios.get('api/permission/'+ id +'/edit').then((response) => {
                    this.myForm = response.data.data
                    console.log(this.myForm)
            })
            },
            getTopPermissions: function () {
                let _this = this;
                axios.get('/api/permission/toppermissions').then(function (response) {
                    console.log(response);
                    _this.options = response.data.data
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
                axios.put('api/permission/' + _this.myForm.id, _this.myForm).then(function(response) {
                    _this.$message('修改成功');
                    _this.$router.push({path: '/admin/permission'});
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

