<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-button type="primary" @click="tagAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <!--列表-->
        <el-table :data="tags" highlight-current-row v-loading="listLoading" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="tag" label="标签" width="200" sortable>
            </el-table-column>
            <el-table-column prop="title" label="标题" width="200" sortable>
            </el-table-column>
            <el-table-column prop="meta_description" label="描述" width="300" sortable>
            </el-table-column>
            <el-table-column prop="created_at" label="发布时间" width="253" sortable>
            </el-table-column>
            <el-table-column label="操作" width="180">
                <template scope="scope">
                     <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                     <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="80px" :rules="addFormRules" ref="addForm">
                <el-form-item label="标签" prop="tag">
                    <el-input v-model="addForm.tag" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="标题" prop="title">
                    <el-input v-model="addForm.title" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="描述" prop="meta_description">
                    <el-input type="textarea" v-model="addForm.meta_description"></el-input>
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
                <el-form-item label="标签" prop="tag">
                    <el-input v-model="editForm.tag" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="标题" prop="title">
                    <el-input v-model="editForm.title" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="描述" prop="meta_description">
                    <el-input type="textarea" v-model="editForm.meta_description"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
             <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
             <el-pagination layout="prev, pager, next" @current-change="handleCurrentChange" :page-size="20" :total="total" style="float:right;">
            </el-pagination>
        </el-col>



    </section>
</template>

<script>
    import util from '../../../common/js/util'
    //import NProgress from 'nprogress'
    import { getTags, TagStore, TagUpdate, TagDelete } from '../../../api/api';

    export default {
        data() {
            return {
                filters: {
                    name: ''
                },
                tags: [],
                total: 0,
                page: 1,
                listLoading: false,
                sels: [],//列表选中列


                //新增窗口显示
                addLoading: false,
                addFormVisible: false,
                addFormRules:{
                    tag: [
                        { required: true, message: '请输入标签', trigger: 'blur'}
                    ],
                    title: [
                        { required: true, message: '请输入标题', trigger: 'blur'}
                    ]
                },
                addForm: {
                    tag : '',
                    title: '',
                    meta_description: '',
                },

                //编辑窗口显示
                editLoading: false,
                editFormVisible: false,
                editFormRules:{
                    tag: [
                        { required: true, message: '请输入标签', trigger: 'blur'}
                    ],
                    title: [
                        { required: true, message: '请输入标题', trigger: 'blur'}
                    ]
                },
                editForm: {
                    id: 0,
                    tag : '',
                    title: '',
                    meta_description: '',
                }
            }
        },
        mounted() {
            this.getTags();
        },
        methods: {
            tagAdd: function() {
                this.addFormVisible = true;
            },
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
            },
            //add
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.addForm);
                            //console.log(para);return false;
                            TagStore(para).then((res) => {

                                this.addLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['addForm'].resetFields();
                                this.addFormVisible = false;
                                this.getTags();
                            });
                        });
                    }
                });
            },
            //edit
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.editForm);
                            console.log(para);
                            TagUpdate(para).then((res) => {



                                this.editLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getTags();
                            });
                        });
                    }
                });
            },
            //获取用户列表
            getTags() {
                let para = {
                    page: this.page,
                    name: this.filters.name
                };
                this.listLoading = true;
                //NProgress.start();
                getTags(para).then((res) => {
                    this.total = res.data.total;
                    this.tags = res.data.data;
                    this.listLoading = false;
                    //NProgress.done();
                });
            },
            //del
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { id: row.id };
                    TagDelete(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getTags();
                    });
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
                    console.log(ids);
                    let para = { id: ids };
                    TagDelete(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getTags();
                    });
                }).catch(() => {

                });
            },
            //选中
            selsChange: function (sels) {
                this.sels = sels;
            },
            /*翻页*/
            handleCurrentChange: function () {
                this.page = val;
                this.getTags();
            },

        },

    }

</script>

<style lang="scss">

</style>