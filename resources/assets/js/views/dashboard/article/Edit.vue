<template>
    <el-form ref="myForm" :model="myForm" :rules="addFormRules" label-width="100px" style="margin:20px;width:60%;min-width:600px;">
        <el-form-item label="分类" prop="options">
            <el-select v-model="selected" placeholder="请选择分类">
                <el-option v-for="item in options" :key="item.id" :label="item.name" :value="item.id"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="标题" prop="title">
            <el-input v-model="myForm.title" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="短标题" prop="subtitle">
            <el-input v-model="myForm.subtitle" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="标签" prop="allTag">
            <el-select v-model="tags" multiple placeholder="请选择">
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


<script>
    import util from '../../../common/js/util';
    import {default as SimpleMDE} from 'simplemde/dist/simplemde.min.js';
    import FormMixin from './FormMixin.vue'
    export default {
        mixins: [FormMixin],
        data(){
            return {
                addFormRules: {
                    title: [
                        {required: true, message: '请输入标题', trigger: 'blur'}
                    ],
                    subtitle: [
                        {required: true, message: '请输入短标题', trigger: 'blue'}
                    ],
                    category_id: [
                        { type: 'number', required: true, message: '请选择', trigger: 'change'}
                    ]
                },
                myForm: {
                    id : '',
                    category_id: 1,
                    tag_id: [],
                    title: '',
                    subtitle: '',
                    content: '',
                    meta_description: '',
                    published_at: '',
                    is_draft: false,
                    is_original: false,
                },

            }
        },
        created() {
            if (this.$route.params.id != undefined) {
                this.getArticleEdit(this.$route.params.id);
            }
        },
        methods: {
            /*渲染文章修改表单*/
            getArticleEdit: function (id) {
                let para = {id : id}
                this.listLoading = true;
                axios.get('api/article/'+ id +'/edit').then((res) => {
                    console.log(res)
                    let data    = res.data;
                    let myForm = this.myForm;
                    myForm.id = data.id;
                    this.selected = data.category_id
                    myForm.title = data.title;
                    myForm.subtitle = data.subtitle;
                    myForm.meta_description = data.meta_description;
                    myForm.published_at = data.published_at;
                    myForm.is_draft = data.is_draft;
                    myForm.is_original = data.is_original;

                    let tmpContent = JSON.parse(data.content)
                    this.myForm.content.value(tmpContent.raw);

                    let tags = [];
                    if ( data.tag_id.length > 0) {
                        for (let index in data.tag_id) {
                            tags.push(data.tag_id[index].tag);
                        }
                        this.tags = tags;
                    }

                    console.log(this.myForm);
                    this.logining = false;
                })
            },
            onSubmit: function(myForm) {

                if(this.myForm.id){
                    //edit
                    this.$refs[myForm].validate((valid) => {
                        if(!valid){
                            console.log('form valid error.');
                            return false
                        }
                        this.addLoading = true;
                        let para = Object.assign({}, this.myForm);
                        para.content = this.myForm.content.value();
                        para.published_at = (!para.published_at || para.published_at == '') ? '' : util.formatDate.format(new Date(para.published_at), 'yyyy-MM-dd');

                        axios.put('api/article/' + this.myForm.id, para).then((res) => {
                            if(res.status == 200){
                                this.datas = res.data.data;
                                this.listLoading = false;
                                this.$router.push({path: '/article'});
                            }else {
                                console.log('error');
                            }
                        })
                    })
                    console.log('edit')
                }else {
                    //add
                    this.$refs.myForm.validate((valid) => {
                        if(!valid){
                            console.log('form valid error.');
                            return false
                        }
                        this.addLoading = true;
                        let para = Object.assign({}, this.myForm);
                        para.content = this.myForm.content.value();
                        para.published_at = (!para.published_at || para.published_at == '') ? '' : util.formatDate.format(new Date(para.published_at), 'yyyy-MM-dd');
                        console.log(para)
                        axios.post('/api/article', para).then((res) => {
                            if(res.status == 200){
                                this.datas = res.data.data;
                                this.listLoading = false;
                                this.$router.push({path: '/article'});
                            }else {
                                console.log('error');
                            }


                        })
                    })
                }


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