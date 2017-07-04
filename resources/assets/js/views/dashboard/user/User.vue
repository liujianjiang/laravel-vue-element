<template>
    <section>


        <vue-table api-url="/api/user" :fields="fields" :item-actions="itemActions" @table-action="tableActions" :data="data">
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
                        'label': '名称',
                        'width': '200'
                    },
                    {
                        'name': 'email',
                        'label': '邮箱',
                        'width': '300'
                    },
                    {
                        'name': 'created_at',
                        'label': '创建时间',
                        'width': '190'
                    },
                    {
                        name : '_actions',
                        label: '操作',
                        width: '180',
                    }
                ],
                itemActions: [
                    { name: '编辑', type: 'success', class: '', action: 'edit'},
                    { name: '删除', type: 'danger', class: '', action: 'delete'}
                ],
            }
        },
        methods: {
            tableActions(action, data){
                if(action == 'edit'){
                    this.$router.push({path: '/user/edit/' + data.id});
                }else if(action == 'delete'){
                    let _this = this
                    axios.delete('api/user/' + data.id).then(function (response){
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

                }
            },
            handleAdd(){
                this.$router.push({path: '/admin/create'})
            },
        },
        mounted() {

        }
    }

</script>

<style lang="scss">

</style>