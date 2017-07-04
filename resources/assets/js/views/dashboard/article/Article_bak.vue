<template>
    <section>
        <!--工具条-->
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
                      <el-button type="primary" @click="handleArticleSearch">查询</el-button>
                  </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="articleAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <!--列表-->
        <el-table :data="articles" highlight-current-row v-loading="listLoading" @selection-change="selsChange"
                  style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="title" label="标题" width="500" sortable>
            </el-table-column>
            <el-table-column prop="category.data.name" label="分类" width="200" sortable>
            </el-table-column>
            <el-table-column prop="published_at" label="发布时间" width="255" sortable>
            </el-table-column>
            <el-table-column label="操作" width="180">
                <template scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
            <el-pagination layout="prev, pager, next" @current-change="handleCurrentChange" :page-size="10"
                           :total="total" style="float:right;">
            </el-pagination>
        </el-col>
    </section>
</template>

<script>
    import util from '../../../common/js/util'
    //import NProgress from 'nprogress'
    import {getArticle, ArticleDestroy, getAllCategories, ArticleSearch} from '../../../api/api';
    import {default as SimpleMDE} from 'simplemde/dist/simplemde.min.js'

    export default {
        data() {
            return {
                filters: {
                    title: '',
                    category: '',
                },
                articles: [],
                total: 0,
                page: 1,
                listLoading: false,
                sels: [],//列表选中列
                options: [],

                addForm: {
                    title: '',
                    category: '',
                    content: '',
                }
            }
        },
        create() {

        },
        methods: {
            //跳转编辑页面
            handleEdit: function (index, row) {
                this.$router.push({path: '/article/edit/' + row.id});
            },
            //翻页
            handleCurrentChange(val) {
                this.page = val;
                this.getArticles();
            },
            //点击添加按钮跳转
            articleAdd(){
                this.$router.push({path: '/article/create'});
            },
            //获取文章列表
            getArticles() {
                let para = {
                    page: this.page,
                    title: this.filters.title,
                    category: this.filters.category
                };
                this.listLoading = true;
                //NProgress.start();
                getArticle(para).then((res) => {
                    this.total = res.data.total;
                    this.articles = res.data.data;
                    this.listLoading = false;
                    //NProgress.done();
                });
            },
            //文章搜索
            handleArticleSearch : function () {
                let para = {
                    page: this.page,
                    title: this.filters.title,
                    category: this.filters.category
                };
                if(para.title == '' && para.category == ''){
                    this.$message('请输入搜索条件');
                    return false;
                }
                this.listLoading = true;
                ArticleSearch(para).then((res) => {
                    this.total = res.data.total;
                    this.articles = res.data.data;
                    this.listLoading = false;
                })
            },
            //删除文章
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = {id: row.id};
                    ArticleDestroy(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getArticles();
                    })
                }).catch(() => {

                });
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
                    ArticleDestroy(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getArticles();
                    });
                }).catch(() => {

                });
            },
            //选择按钮
            selsChange: function (sels) {
                this.sels = sels;
            },
            //获取分类
            getCategories: function () {
                getAllCategories().then((res) => {
                    this.options = res.data
                    console.log(res);
                })
            },
        },
        mounted() {
            this.getArticles();
            this.getCategories();
        },
    }

</script>

<style lang="scss">

</style>