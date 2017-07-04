<template>
    <div class="row">
        <!--  tool -->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.title" placeholder="标题"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="filters.category" clearable placeholder="请选择">
                        <el-option
                                v-for="item in options"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleSearch">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <!-- table list -->
        <vue-table api-url="/api/article" :fields="fields" :item-actions="itemActions" @table-action="tableActions" :data="data">
        </vue-table>
    </div>
</template>

<script type="text/ecmascript-6">
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
                    { name: '编辑', type: 'success', class: '', action: 'edit'},
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
                if(action == 'edit'){
                    this.$router.push({path: '/article/edit/' + data.id});
                }else if(action == 'delete'){
                    this.listLoading = true
                    axios.delete('api/article/' + data.id).then((response) =>{
                        this.$confirm('确认删除？', '提示', { type: 'warning'}).then((response) => {
                            this.listLoading = false
                            this.$message({message: '刪除成功', type: 'success'})
                            this.$emit('reload')
                        },(response) => {
                            if ((typeof response.data.error !== 'string') && response.data.error) {
                                this.$message({message: response.data.error.message, type: 'error'})
                            } else {
                                this.$message({message: response.status + ' : Resource ' + response.statusText, type: 'error'})
                            }
                        })
                    })

                }
            },
            //redicte add
            handleAdd(){
                this.$router.push({path: '/article/create'});
            },
            //handle search
            handleSearch(){

                let para = {
                    title: this.filters.title,
                    category: this.filters.category
                };

                if( typeof(para.title) == 'undefined' && typeof(para.category) == 'undefined'){
                    this.$message('请输入搜索条件');
                    return false;
                }

                this.listLoading = true;
                axios.post('/dashboard/article/search', { para:para }).then((res) => {
                    this.total = res.data.total;
                    this.data = res.data.data;
                    this.listLoading = false;
                })
            },
            //get category options
            getAllCategories(){
                axios.get('/api/categories').then((res) => {
                    this.options = res.data.data
                })
            }
        },
        created(){
            this.getAllCategories();
        }
    }

</script>

<style lang="scss">

</style>