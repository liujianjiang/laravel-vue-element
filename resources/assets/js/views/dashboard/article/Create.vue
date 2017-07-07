<template>
    <article-form :myForm="myForm"></article-form>
</template>


<script type="text/ecmascript-6">
    import ArticleForm from './Form'

    export default {
        components: { ArticleForm },
        data() {
            return {
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
                }
            }
        },
     /*   mixins: [FormMixin],
        data(){
            return {
                myFormRules: {
                    /!* title: [
                     {required: true, message: '请输入标题', trigger: 'blur'}
                     ],
                     subtitle: [
                     {required: true, message: '请输入短标题', trigger: 'blue'}
                     ],
                     category_id: [
                     { type: 'number', required: true, message: '请选择', trigger: 'change'}
                     ]*!/
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
        },*/
    }
</script>

<style lang="scss">


</style>