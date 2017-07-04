<template>

        <div class="row" style="padding: 30px 20px;">
            <ul id="myTab" class="nav nav-tabs" >
                <li class="active">
                    <a href="#system" data-toggle="tab">
                        系统
                    </a>
                </li>
                <li><a href="#PHP" data-toggle="tab">PHP</a></li>
                <li><a href="#MYSQL" data-toggle="tab">MYSQL</a></li>

            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="system">
                    <table class="table">
                        <thead >
                        <tr>
                            <th class="pk-table-width-150">系统</th>
                            <th>值</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>网站服务器</td>
                            <td>{{ system.server }}</td>
                        </tr>
                        <tr>
                            <td>域名</td>
                            <td>{{ system.http_host }}</td>
                        </tr>
                        <tr>
                            <td>IP</td>
                            <td>{{ system.remote_host }}</td>
                        </tr>
                        <tr>
                            <td>User Agent</td>
                            <td>{{ system.user_agent }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="PHP">
                    <table class="table">
                        <thead >
                        <tr>
                            <th class="pk-table-width-150">设置</th>
                            <th>值</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>版本</td>
                            <td>{{ system.php }}</td>
                        </tr>
                        <tr>
                            <td>Handler</td>
                            <td>{{ system.sapi_name }}</td>
                        </tr>
                        <tr>
                            <td>扩展</td>
                            <td>{{ system.extensions }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="MYSQL">
                    <table class="table">
                        <thead >
                        <tr>
                            <th class="pk-table-width-150">设置</th>
                            <th>值</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>驱动</td>
                            <td>{{ system.db_connection }}</td>
                        </tr>
                        <tr>
                            <td>数据库</td>
                            <td>{{ system.db_database }}</td>
                        </tr>
                        <tr>
                            <td>版本</td>
                            <td>{{ system.db_version }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            </div>


        </div>


</template>
<script>
    export default {
        data(){
            return {
                system : {}
            }
        },
        created() {
            let _this = this;
            axios.get('/api/system').then(function(response){
                _this.system = response.data
                console.log(_this.system)
            })
        },

    }

</script>
<style lang="scss" scoped>
    .sidebar ul li a{
        font-size: 12px;
        display: block;
        text-decoration: none;
        padding: 8px 14px;
        cursor: pointer;
        color: #666;
    }

</style>