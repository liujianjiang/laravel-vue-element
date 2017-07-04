<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true">
                <el-form-item>
                    <el-button type="primary" @click="handleAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <vue-table api-url="/api/role" :fields="fields" :item-actions="itemActions" @table-action="tableActions" :data="data">
        </vue-table>

    </section>
</template>

<script>

    export default {

        data() {
            return {
                data: [],
                fields:[
                    {
                        'name': 'name',
                        'label': '标识',
                        'width': '200'
                    },
                    {
                        'name': 'display_name',
                        'label': '角色名',
                        'width': '250'
                    },
                    {
                        'name': 'description',
                        'label': '描述',
                        'width': '250'
                    },
                    {
                        'name': 'created_at',
                        'label': '创建时间',
                        'width': '190'
                    },
                    {
                        name : '_actions',
                        label: '操作',
                        width: '280',
                    }
                ],
                itemActions: [
                    { name: '权限', type: 'success', class: '', action: 'permission'},
                    { name: '编辑', type: 'success', class: '', action: 'edit'},
                    { name: '删除', type: 'danger', class: '', action: 'delete'}
                ],
            }
        },
        methods: {
            tableActions(action, data){
                console.log(action);
                if(action == 'edit'){
                    this.$router.push({path: '/role/edit/' + data.id});
                }else if(action == 'delete'){
                    let _this = this
                    axios.delete('api/role/' + data.id).then(function (response){
                        _this.$confirm('确认删除？', '提示', { type: 'warning'}).then((response) => {
                            _this.$message({message: '刪除成功', type: 'success'})
                            _this.$emit('reload')
                        },(response) => {
                            if ((typeof response.data.error !== 'string') && response.data.error) {
                                this.$message({message: response.data.error.message, type: 'error'})
                            } else {
                                this.$message({message: response.status + ' : Resource ' + response.statusText, type: 'error'})
                            }
                        })
                    }).catch(function (response) {
                        console.log(response.response.data)
                    })

                }else if( action == 'permission'){

                    this.$router.push({path: '/role/permission/' + data.id});
                }
            },
            handleAdd(){
                this.$router.push({path: '/role/create'})
            },
        },
        mounted() {

        }
    }

</script>

<style lang="scss">

</style>