<script>
    export default {
        data() {
            return {
                selected: null,
                options: [],
                tags: null,
                allTag: [],
            }
        },
        created() {
            axios.get('/api/categories')
                .then((response) => {
                    this.options = response.data
                })
            axios.get('/api/tags')
                .then((response) => {
                    this.allTag = response.data
                })
        },
    }
</script>