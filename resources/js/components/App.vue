<template>
    <div class="hold-transition sidebar-mini layout-fixed">

            <nav class="main-header navbar navbar-expand navbar-white navbar-light">

                <!-- SEARCH FORM -->
                <!--<form class="form-inline ml-3">-->
                    <!--<div class="input-group input-group-sm">-->
                        <!--<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
                        <!--<div class="input-group-append">-->
                            <!--<button class="btn btn-navbar" type="submit">-->
                                <!--<i class="fas fa-search"></i>-->
                            <!--</button>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</form>-->

                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <span>{{ user.name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a @click="logout()" href="#" class="dropdown-item dropdown-footer">Logout</a>
                        </div>
                    </li>
                </ul>

            </nav>

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <router-link to="/" class="brand-link">
                    <span class="brand-text font-weight-light">MiniCRM</span>
                </router-link>

                <!-- Sidebar -->
                <div class="sidebar">

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <router-link to="/companies" class="nav-link">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>Companies</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/employees" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Employees</p>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <router-view :is_admin="user.is_admin" />
            </div>
            <!-- /.content-wrapper -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "app",

        props: [
            'user'
        ],

        created() {
            window.axios.interceptors.request.use(
                (config) => {
                    if(config.method === 'get') {
                        config.url = config.url + '?api_token=' + this.user.api_token;
                    } else {
                        config.data = {
                            ...config.data,
                            api_token: this.user.api_token
                        };
                    }
                    return config;
                }
            )
        },

        methods: {
            logout: function () {
                axios.post('/logout', {})
                    .finally(err => {
                        window.location = '/login';
                    });
            }
        }
    }
</script>

<style scoped>

</style>