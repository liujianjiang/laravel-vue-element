<template>
    <section>

        <vue-table api-url="/api/discussion" :fields="fields" :item-actions="itemActions" @table-action="tableActions" :data="data">
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
                        'name': 'title',
                        'label': '问题',
                        'width': '600'
                    },
                    {
                        'name': 'user.data.name',
                        'label': '创建用户',
                        'width': '200'
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
                    this.$router.push({path: '/discussion/edit/' + data.id});
                }else if(action == 'delete'){
                    let _this = this
                    axios.delete('api/discussion/' + data.id).then(function (response){
                        _this.$confirm('确认删除？', '提示', { type: 'warning'}).then((response) => {
                            _this.$message({message: '刪除成功', type: 'success'})
                            _this.$emit('reload')
                        },(response) => {
                           console.log(response)
                        })
                    }).catch(function (response) {
                        console.log(response.response.data)
                    })

                }
            },
        },
        mounted() {

        }
    }

</script>

<style lang="scss">

</style>