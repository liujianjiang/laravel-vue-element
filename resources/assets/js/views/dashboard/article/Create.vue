<template>
    <el-form ref="myForm" :model="myForm" :rules="myFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">
        <el-form-item label="分类" prop="options">
            <el-select v-model="myForm.category_id" placeholder="请选择分类">
                <el-option v-for="item in options.data" :key="item.id" :label="item.name" :value="item.id"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="标题" prop="title">
            <el-input v-model="myForm.title" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="短标题" prop="subtitle">
            <el-input v-model="myForm.subtitle" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="标签" prop="allTag">
            <el-select v-model="myForm.tag_id" multiple placeholder="请选择">
                <el-option
                        v-for="field in allTag"
                        :key="field.id"
                        :label="field.tag"
                        :value="field.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="描述">
            <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="myForm.meta_description">
            </el-input>
        </el-form-item>
        <el-form-item label="内容">
            <textarea id="editor"></textarea>
        </el-form-item>
        <el-form-item label="时间">
            <div class="block">
                <span class="demonstration"></span>
                <el-date-picker
                        v-model="myForm.published_at"
                        type="datetime"
                        placeholder="选择日期时间">
                </el-date-picker>
            </div>
        </el-form-item>
        <el-form-item label="">
            <el-row>
                <el-col :span="8"><div class="grid-content bg-purple-light">是否存草稿？<el-switch
                        v-model="myForm.is_draft"
                        on-color="#13ce66"
                        off-color="#ff4949">
                </el-switch></div></el-col>
                <el-col :span="8"><div class="grid-content bg-purple-light">是否是原创？<el-switch
                        v-model="myForm.is_original"
                        on-color="#13ce66"
                        off-color="#ff4949">
                </el-switch></div></el-col>
            </el-row>
            </el-switch>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" size="large" @click.native="onSubmit('myForm')">保存</el-button>
        </el-form-item>
    </el-form>
</template>


<script type="text/ecmascript-6">
    import FormMixin from './FormMixin.vue'
    import util from '../../../common/js/util';
    import {default as SimpleMDE} from 'simplemde/dist/simplemde.min.js';
    import { error_warning } from '../../../config/helper'
    export default {
        mixins: [FormMixin],
        data(){
            return {
                myFormRules: {
                    /* title: [
                     {required: true, message: '请输入标题', trigger: 'blur'}
                     ],
                     subtitle: [
                     {required: true, message: '请输入短标题', trigger: 'blue'}
                     ],
                     category_id: [
                     { type: 'number', required: true, message: '请选择', trigger: 'change'}
                     ]*/
                },
                myForm: {
                    category_id: '',
                    tag_id: [],
                    title: '',
                    subtitle: '',
                    content: '',
                    meta_description: '',
                    published_at: new Date(),
                    is_draft: false,
                    is_original: false,
                },

            }
        },
        created() {

        },
        methods: {

            onSubmit: function(myForm) {

                let _this = this;

                _this.$refs.myForm.validate((valid) => {
                    if(!valid){
                        console.log('form valid error.');
                        return false
                    }

                    let para = Object.assign({}, _this.myForm);
                    para.content = _this.myForm.content.value();
                    para.published_at = (!para.published_at || para.published_at == '') ? '' : util.formatDate.format(new Date(para.published_at), 'yyyy-MM-dd');

                    axios.post('/api/article', para).then(function(response){
                        _this.$notify({title: '成功', type: 'success', message: response.data.message})
                        _this.$router.push({path: '/article'});
                    }).catch(function(error){
                        error_warning(error.response.data);
                    })

                })
            },
        },
        mounted() {
            this.myForm.content = new SimpleMDE({
                element: document.getElementById("editor"),
                placeholder: 'Please input the article content.',
                autoDownloadFontAwesome: true
            })
        },
    }
</script>

<style lang="scss">


</style>