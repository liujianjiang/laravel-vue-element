<template>
   <div>
       <category-form :myForm="myForm"></category-form>
   </div>
</template>

<script type="text/ecmascript-6">
    import CategoryForm from './Form'

    export default {
        components: { CategoryForm },
        data() {
            return {
                myForm: undefined
            }
        },
        created() {
            this.loadData()
        },
        methods: {
            loadData() {
                axios.get('api/category/' + this.$route.params.id + '/edit')
                        .then((response) => {
                    this.myForm = response.data.data
                })
            },
        }
    }
</script>


<style lang="scss">


</style>