<template>
    <section>

        <!--列表-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-table :data="items" style="width: 100%" :default-sort = "{prop: 'date', order: 'descending'}" highlight-current-row v-loading="listLoading" @selection-change="selsChange">
                <el-table-column type="selection" width="55">
                </el-table-column>
                <template v-for="field in fields">
                    <template v-if="field.name != '_actions'">
                        <template v-if="field.name != 'role.data'">
                        <el-table-column
                                :prop="field.name"
                                :label="field.label"
                                sortable
                                :width="field.width">
                        </el-table-column>
                        </template>
                        <template v-else>
                            <el-table-column :prop="field.name" :label="field.label" :width="field.width" >
                                <template scope="scope">
                                    <template v-for="tag in scope.row.role.data">
                                        <el-tag type="success" close-transition>{{tag.display_name}}</el-tag>
                                    </template>

                                </template>
                            </el-table-column>
                        </template>
                    </template>
                    <template v-else>
                        <el-table-column :prop="field.name" :label="field.label" :width="field.width">
                            <template scope="scope" >
                                <template v-for="action in itemActions">
                                    <el-button :type="action.type" @click="callAction(action.action, scope.row)">{{action.name}}</el-button>
                                </template>
                            </template>
                        </el-table-column>
                    </template>
                </template>
            </el-table>
        </el-col>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
            <el-pagination
                    style="float:right;"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage"
                    :page-sizes="[10, 20, 30, 50]"
                    :page-size="pageSize"
                    layout="sizes, prev, pager, next"
                    :total="total">
            </el-pagination>
            <!--<el-pagination layout="prev, pager, next" @current-change="handleCurrentChange" :page-size="pageSize" :total="total" style="float:right;">
            --></el-pagination>
        </el-col>

    </section>
</template>

<script>
    import NProgress from 'nprogress'

    export default{
        props: {
            data: {
              type: Array,
              required: false
            },
            fields :{
              type : Array,
              required: true
            },
            apiUrl: {
                type: String,
                required: true
            },
            showPaginate: {
                type: Boolean,
                dafault() {
                    return false
                }
            },
            itemActions: {
                type: Array,
                default() {
                    return [
                        { name: '修改', type: 'danger', class: 'btn btn-info', action: 'edit' },
                        { name: '删除', type: '', class: 'btn btn-danger', action: 'delete' }
                    ]
                }
          },
        },
        created() {
            this.currentPage = this.$route.query.page
            this.loadData()
        },
        mounted() {
            this.$parent.$on('reload', () => {
                this.loadData()
            })
        },
        data() {
            return {
                items: [],
                listLoading: true,
                sels: [],//列表选中列
                total: 0,
                currentPage: 1,
                pagination: null,
                pageSize: 10,
                filters: [
                    {
                        title: '',
                        category: 0,
                        options : []
                    }
                ]
            }
        },
        methods : {
            //翻页
            handleCurrentChange(val) {
                this.currentPage = val;
                this.loadData(this.currentPage);
            },
            handleSizeChange(val) {
                console.log(val)
                this.pageSize = val;
                this.loadData(this.currentPage)
            },
            //选择按钮
            selsChange: function (sels) {
                this.sels = sels;
            },
            //获取列表数据
            loadData() {
                let _this = this;
                var url = _this.apiUrl;

                if (_this.currentPage) {
                    let page = ''
                    if (url.indexOf('?') != -1) {
                        page = '&page='
                    } else {
                        page = '?page='
                    }
                    url = url + page + _this.currentPage + '&pagesize=' + _this.pageSize
                    _this.$router.push(page + _this.currentPage)
                }
                NProgress.start();
                axios.get(url).then(response => {
                        _this.pagination = response.data.meta.pagination
                        _this.items = response.data.data
                        _this.total = response.data.meta.pagination.total
                        _this.currentPage = response.data.meta.pagination.current_page
                        _this.listLoading = false;
                        if (_this.showPaginate && _this.items.length != 0) {
                            _this.$nextTick(() => {
                                _this.$refs.pagination.$data.pagination = _this.pagination
                            })
                        }
                        /*this.$message('获取列表成功')*/
                    }).catch(function (response) {
                        _this.$notify.error({
                            message: response.response.data.message
                         });

                })
                NProgress.done();

            },
            //操作按钮
            callAction(action, data) {
                this.$emit('table-action', action, data)
            },
            //批量删除
            batchRemove: function () {
                var ids = this.sels.map(item => item.id).toString();
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = {id: ids};
                    console.log(para);
                    axios.delete(this.apiUrl+'/'+ ids).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.loadData();
                    });
                }).catch(() => {

                });
            },

        },
        mounted(){
            this.$parent.$on('reload', () => {
                this.loadData()
            })
        },
        watch: {
            data: function (newValue, oldValue) {
                this.items = newValue
            },
        },

    }
</script>

<style lang="scss" scoped>
    .none {
        color: #ECF0F1;
        padding-bottom: 20px;
    }
    .actions {
      width: 15%;
      padding: 12px 0px;
      text-align: center;
    }
    .actions a {
      border-radius: 50%;
      margin-left: 5px;
      margin-right: 5px;
    }
    .active {
      background-color: #3d4e60;
      border-right: none;
    }
    .pagination li {
      cursor: pointer;
    }

</style>
