<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <!--<el-form-item>
                    <el-input v-model="filters.name" placeholder="姓名"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getCategories">查询</el-button>
                </el-form-item>-->
                <el-form-item>
                    <el-button type="primary" @click="handleAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <!--列表-->
        <el-table :data="datas" highlight-current-row v-loading="listLoading" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="name" label="名称" width="350" sortable>
            </el-table-column>
            <el-table-column prop="path" label="路径" width="350" sortable>
            </el-table-column>
            <el-table-column prop="updated_at" label="日期" width="254" sortable>
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
            <el-pagination layout="prev, pager, next" @current-change="handleCurrentChange" :page-size="10" :total="total" style="float:right;">
            </el-pagination>
        </el-col>


        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="80px" :rules="addFormRules" ref="addForm">
                <el-form-item label="名称" prop="name">
                    <el-input v-model="addForm.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="路径" prop="path">
                    <el-input v-model="addForm.path" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="描述" prop="description">
                    <el-input type="textarea" v-model="addForm.description"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
            </div>
        </el-dialog>


        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="名称" prop="name">
                    <el-input v-model="editForm.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="路径" prop="path">
                    <el-input v-model="editForm.path" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input type="textarea" v-model="editForm.description"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>

    </section>
</template>

<script>
    import util from '../../../common/js/util';
    //import NProgress from 'nprogress'
    import { getCategoriesListPage, CategoryStore, CategoryDestroy, updateCategory } from '../../../api/api';

    export default {
        data() {
            return {
                filters: {
                    name: ''
                },
                datas: [],
                total: 0,
                page: 1,
                listLoading: false,
                sels: [],//列表选中列

                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    name: [
                        { required: true, message: '请输入名称', trigger: 'blur' }
                    ],
                    path: [
                        { required: true, message: '请输入路径', trigger: 'blur' }
                    ]
                },
                //编辑界面数据
                editForm: {
                    id: 0,
                    name: '',
                    path: -1,
                    description: '',
                },

                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    name: [
                        { required: true, message: '请输入名称', trigger: 'blur' }
                    ],
                    path: [
                        { required: true, message: '请输入路径', trigger: 'blur' }
                    ]
                },
                //新增界面数据
                addForm: {
                    name: '',
                    path: '',
                    description: ''
                }

            }
        },
        methods: {

            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
                this.addForm = {
                    name: '',
                    path: '',
                    description: '',
                };
            },

            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;

                this.editForm = Object.assign({}, row);
            },

            /*获取列表*/
            getCategories() {
                let para = {
                    page: this.page,
                    name: this.filters.name
                };
                this.listLoading = true;
                //NProgress.start();
                getCategoriesListPage(para).then((res) => {
                    this.total = res.total;
                    this.datas = res.data.data;
                    this.listLoading = false;
                //NProgress.done();
                 });
            },

            /*翻页*/
            handleCurrentChange(val) {
                this.page = val;
                this.getCategories();
            },

            /*新增提交*/
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                        //NProgress.start();
                        let para = Object.assign({}, this.addForm);
                        //console.log(para);return false;
                        CategoryStore(para).then((res) => {

                            this.addLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.$refs['addForm'].resetFields();
                        this.addFormVisible = false;
                        this.getCategories();
                    });
                    });
                    }
                });
            },

            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                        //NProgress.start();
                        let para = Object.assign({}, this.editForm);

                        updateCategory(para).then((res) => {
                            this.editLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.$refs['editForm'].resetFields();
                        this.editFormVisible = false;
                        this.getCategories();
                    });
                    });
                    }
                });
            },

            //删除
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                //NProgress.start();
                let para = { id: row.id };
                CategoryDestroy(para).then((res) => {
                    this.listLoading = false;
                    //NProgress.done();
                    this.$message({
                        message: '删除成功',
                        type: 'success'
                    });
                    this.getCategories();
            });
            }).catch(() => {

                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

            //批量删除
            batchRemove: function () {
                var ids = this.sels.map(item => item.id).toString();
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                //NProgress.start();
                console.log(ids);
                let para = { id: ids };
                CategoryDestroy(para).then((res) => {
                    this.listLoading = false;
                //NProgress.done();
                this.$message({
                    message: '删除成功',
                    type: 'success'
                });
                this.getCategories();
            });
            }).catch(() => {

                });
            },

        },
        mounted() {
            this.getCategories();
        }
    }

</script>

<style lang="scss">

</style>