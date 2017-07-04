<template>
    <section>

        <vue-table api-url="/api/comment" :fields="fields" :item-actions="itemActions" @table-action="tableActions" :data="data">
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
                        'name': 'user.data.name',
                        'label': '用户名',
                        'width': '150'
                    },
                    {
                        'name': 'commentable_type',
                        'label': '评论类型',
                        'width': '150'
                    },
                    {
                        'name': 'content_raw',
                        'label': '评论标题',
                        'width': '500'
                    },
                    {
                        'name': 'created_at',
                        'label': '评论时间',
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
                    this.$router.push({path: '/comment/edit/' + data.id});
                }else if(action == 'delete'){
                    let _this = this
                    axios.delete('api/comment/' + data.id).then(function (response){
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