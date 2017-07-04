<template>

    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" class="form-horizontal col-md-9 col-md-offset-1">

            <el-tree
                    :data="data2"
                    show-checkbox
                    default-expand-all
                    node-key="id"
                    ref="tree"
                    highlight-current
                    :props="defaultProps">
            </el-tree>
        <el-form-item>

            <el-button type="primary" size="large" @click.native="onSubmit('myForm')">保存</el-button>
        </el-form-item>
    </el-form>

</template>

<script>
    export default {
        created(){

        },
        data() {
            return {
                data2: [],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                myFormRules: {

                },
                myForm:{

                }
            }
        },
         methods: {
            getAllPermissions() {
                let _this = this
                axios.get('/api/role/permissions').then(function(response){

                        _this.data2 = response.data
                    console.log(response.data)
                })
            },

             setCheckedNodes() {
                 this.$refs.tree.setCheckedNodes([{
                     id: 5,
                     label: '二级 2-1'
                 }, {
                     id: 9,
                     label: '三级 1-1-1'
                 }]);
             },
             setCheckedKeys() {
                     let _this = this
                     axios.get('/api/role/permissions/' + this.$route.params.id).then(function(response){
                        console.log(response);
                        let tree = [];
                        let permissions = response.data.permissions
                        if(permissions.length > 0){
                        for (let index in permissions){
                         tree.push(permissions[index].id)
                        }
                        }
                        _this.$refs.tree.setCheckedKeys(tree);
                     })

             },
             onSubmit: function(myForm) {
                 let _this = this;
                 let tree = this.$refs.tree.getCheckedKeys();

                 _this.$refs[myForm].validate((valid) => {
                     if(!valid){
                         console.log('form valid error.');
                         return false
                     }
                     console.log(this.myForm);
                     axios.put('api/role/permission/' + this.$route.params.id,tree).then(function(response) {
                         _this.$message('修改成功');
                         _this.$router.push({path: '/admin/role'});
                     }).catch (function (error) {
                         console.log(error)
                     })
                 })
             },
        },
        mounted() {
            this.getAllPermissions();
            this.setCheckedKeys();
        }
    };
</script>

