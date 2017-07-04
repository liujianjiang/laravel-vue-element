<template>
    <div class="row">



        <!-- table list -->
        <vue-table api-url="/api/article/recycle" :fields="fields" :item-actions="itemActions" @table-action="tableActions" :data="data">
        </vue-table>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                data : [],
                options : [],
                fields: [
                    {
                        name : 'title',
                        label: '标题',
                        width: '600',
                    },
                    {
                        name : 'category.data.name',
                        label: '分类',
                        width: '150',
                    },
                    {
                        name : 'published_at',
                        label: '发布时间',
                        width: '250',
                    },
                    {
                        name : '_actions',
                        label: '操作',
                        width: '200',
                    }
                ],
                itemActions: [
                    { name: '恢复', type: 'success', class: '', action: 'recover'},
                    { name: '删除', type: 'danger', class: '', action: 'delete'}
                ],
                filters: {
                    title: '',
                    category: '',
                },
            }
        },

        methods: {

            tableActions(action, data){
                let _this = this
                if(action == 'recover'){
                    axios.get('/api/article/recover/' + data.id).then(function (response) {
                        _this.$notify({title: '成功', message: '恢复成功', type: 'success'});
                        _this.$emit('reload')
                    }).catch(function (response) {
                        console.log(response)
                    })
                }else if(action == 'delete'){
                    axios.get('api/article/forcedelete/' + data.id).then((response) =>{
                        this.$confirm('确认删除？', '提示', { type: 'warning'}).then((response) => {
                            _this.$notify({title: '成功', message: '强制删除成功', type: 'success'});
                            _this.$emit('reload')
                        },(response) => {
                                console.log(response)
                        })
                    })
                }
            },
        },
        created(){
        }
    }

</script>

<style lang="scss">

</style>