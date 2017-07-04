import Dashboard from './views/Dashboard.vue'
import Login from './views/dashboard/Login.vue'

let routes = [
    {
        path: '/login',
        component: Login,
        hidden  :true,
    },
    {
        path: '/',
        component: Dashboard,
        name: '',
        iconCls: 'el-icon-menu',
        leaf: true,//只有一个节点
        children: [
            {
                path: '/dashboard',
                component: require('./views/dashboard/Dashboard.vue'),
                name: '控制台'
            }
        ]
    },
    {
        path: '/article',
        component: Dashboard,
        name: '文章',
        iconCls: 'el-icon-edit',
        children: [
            {
                path: '/article',
                component: require('./views/dashboard/article/Article.vue'),
                name: '文章管理'
            },
            {
                path: '/article/create',
                component: require('./views/dashboard/article/Create.vue'),
                name: '添加文章',
                hidden: true
            },
            {
                path: '/article/edit/:id',
                component: require('./views/dashboard/article/Edit.vue'),
                name: '修改文章',
                hidden: true
            },
            {
                path: '/category',
                component: require('./views/dashboard/category/Category.vue'),
                name: '分类管理'
            },
            {
                path: '/category/create',
                component: require('./views/dashboard/category/Create.vue'),
                name:'分类添加',
                hidden: true
            },
            {
                path: '/category/edit/:id',
                component: require('./views/dashboard/category/Edit.vue'),
                name: '分类修改',
                hidden: true
            },
            {
                path: '/tag',
                component: require('./views/dashboard/tag/tag.vue'),
                name: '标签管理'
            },
            {
                path: '/tag/create',
                component: require('./views/dashboard/tag/Create.vue'),
                hidden: true
            },
            {
                path: '/tag/edit/:id',
                component: require('./views/dashboard/tag/Edit.vue'),
                hidden: true
            },
            {
                path: '/article/recycle',
                component: require('./views/dashboard/article/Recycle.vue'),
                name: '回收站'
            }
        ]
    },
    {
        path: '/discussion',
        component: Dashboard,
        name: '问答管理',
        iconCls: 'el-icon-message',
        leaf: false,//只有一个节点
        children: [
            {
                path: '/discussion',
                component: require('./views/dashboard/discussion/Discussion.vue'),
                name: '问题管理'

            },
            {
                path: '/discussion/edit/:id',
                component: require('./views/dashboard/discussion/Edit.vue'),
                hidden: true
            },
            {
                path: '/comment',
                component: require('./views/dashboard/comment/Comment.vue'),
                name: '评论管理'
            },
            {
                path: '/comment/edit/:id',
                component: require('./views/dashboard/comment/Edit.vue'),
                hidden: true
            },

        ]
    },
    {
        path: '/category',
        component: Dashboard,
        name: '扩展',
        iconCls: 'el-icon-plus',
        leaf: false,//只有一个节点
        children: [
            {
                path: '/navigation',
                component: require('./views/dashboard/navigation/Navigation.vue'),
                name: '导航管理'
            },
            {
                path: '/navigation/create',
                component: require('./views/dashboard/navigation/Create.vue'),
                hidden: true
            },
            {
                path: '/navigation/edit/:id',
                component: require('./views/dashboard/navigation/Edit.vue'),
                hidden: true
            },
            {
                path: '/link/create',
                component: require('./views/dashboard/link/Create.vue'),
                hidden: true
            },
            {
                path: '/link',
                component: require('./views/dashboard/link/Link.vue'),
                name: '友情管理'
            },
            {
                path: '/link/edit/:id',
                component: require('./views/dashboard/Link/Edit.vue'),
                hidden: true
            },
            {

                path: '/file',
                iconCls: 'el-icon-upload2',
                component: require('./views/dashboard/file/File.vue'),
                name: '文件管理'
            },
        ]
    },
    {
        path: '/admin',
        component: Dashboard,
        name: '用户管理',
        iconCls: 'el-icon-setting',
        leaf: false,//只有一个节点
        children: [
            {
                path: '/admin',
                component: require('./views/dashboard/admin/Admin.vue'),
                name: '管理员'
            },
            {
                path: '/admin/create',
                component: require('./views/dashboard/admin/AdminCreate.vue'),
                name: '添加管理员',
                hidden: true
            },
            {
                path: '/admin/edit/:id',
                component: require('./views/dashboard/admin/AdminEdit.vue'),
                name: '修改管理员',
                hidden: true
            },
            {
                path: '/admin/role',
                component: require('./views/dashboard/admin/Role.vue'),
                name: '角色管理'
            },
            {
                path: '/role/create',
                component: require('./views/dashboard/admin/RoleCreate.vue'),
                name: '添加分组',
                hidden: true
            },
            {
                path: '/role/edit/:id',
                component: require('./views/dashboard/admin/RoleEdit.vue'),
                name: '修改分组',
                hidden: true
            },
            {
                path: '/role/permission/:id',
                component: require('./views/dashboard/admin/RolePermission.vue'),
                name: '修改权限',
                hidden: true
            },
            {
                path: '/admin/permission',
                component: require('./views/dashboard/admin/Permission.vue'),
                name: '权限管理'
            },
            {
                path: '/permission/create',
                component: require('./views/dashboard/admin/PermissionCreate.vue'),
                name: '新增权限',
                hidden: true
            },
            {
                path: '/permission/edit/:id',
                component: require('./views/dashboard/admin/PermissionEdit.vue'),
                name: '修改权限',
                hidden: true
            },
            {
                path: '/user',
                component: require('./views/dashboard/user/User.vue'),
                name: '会员管理'
            },
        ]
    },
    {
        path: '/system',
        component: Dashboard,
        name: '系統配置',
        iconCls: 'el-icon-setting',
        leaf: false,//只有一个节点
        children: [
            {
                path: '/system',
                component: require('./views/dashboard/system/System.vue'),
                name: '系統配置'

            },
        ]
    },
];

export default routes;