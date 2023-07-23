<template>
	<aside class="left-sidebar">
        <div class="scroll-sidebar">
            <!--<div class="user-profile">
                <div class="profile-img"> <img :src="getAvatar" alt="user" width="30" /> </div>
                <div class="profile-text"> <a href="#" class="dropdown-toggle link u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{getAuthUserFullName()}}<span class="caret"></span></a>
                    <div class="dropdown-menu">
                        <router-link to="/profile" class="dropdown-item"><i class="fa fa-user"></i> Profile</router-link>
                        &lt;!&ndash;<div class="dropdown-divider"></div> <router-link to="/configuration" class="dropdown-item"><i class="fa fa-cogs"></i> Configuration</router-link>&ndash;&gt;
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item" @click.prevent="logout"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </div>
            </div>-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="hide-sidebar">
                    <li v-if="isadmin">
                        <router-link to="/user" exact><i class="fa fa-user"></i> <span class="hide-menu">User Management</span></router-link>
                    </li>
                    <li v-if="isadmin">
                        <router-link to="/dashboard" exact><i class="fa fa-line-chart   "></i> <span class="hide-menu">Dashboard</span></router-link>
                    </li>
                    <li>
                        <router-link to="/task" exact><i class="fa fa-tasks"></i> <span class="hide-menu">Customer Query</span></router-link>
                    </li>
                    <li>
                        <router-link to="/inboundlist" exact><i class="fa ">IL</i> <span class="hide-menu">Inbound List</span></router-link>
                    </li>
                    <li>
                        <router-link to="/escalation" exact><i class="fa">E</i> <span class="hide-menu">Escalation</span></router-link>
                    </li>
                    <li>
                        <router-link to="/outbound" exact><i class="fa ">O</i> <span class="hide-menu">Outbound</span></router-link>
                    </li>
                    <li>
                        <router-link to="/outboundlist" exact><i class="fa ">OL</i> <span class="hide-menu">Outbound List</span></router-link>
                    </li>
                    <li v-if="isadmin">
                        <router-link to="/forms-list" exact><i class="fa ">FL</i> <span class="hide-menu">Forms List</span></router-link>
                    </li>
                    <li>
                        <router-link to="/fos" exact><i class="fa">FOS</i> <span class="hide-menu">FOS</span></router-link>
                    </li>
                    <li v-if="isadmin">
                    <!--<li>-->
                        <!--<router-link to="/user" exact><i class="fa fa-users"></i> <span class="hide-menu">User</span></router-link>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<router-link to="/anything" exact><i class="fa fa-exclamation-triangle"></i> <span class="hide-menu">Error Page</span></router-link>-->
                    <!--</li>-->
                    <li>
                        <a href="#" @click.prevent="logout"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="sidebar-footer">
            <!--<router-link to="/configuration" class="link" data-toggle="tooltip" title="Configuration"><i class="fa fa-cogs"></i></router-link>-->
            <router-link to="/profile" class="link" data-toggle="tooltip" title="Profile"><i class="fa fa-user"></i></router-link>
            <a href="#" class="link" data-toggle="tooltip" title="Logout" @click.prevent="logout"><i class="fa fa-power-off"></i></a>
        </div>
    </aside>
</template>

<script>

    import helper from '../services/helper'

    export default {
        data() {
            return {
                isadmin:false
            }
        },
        mounted() {
            this.isadminUser();
        },
        methods : {
            logout(){
                helper.logout().then(() => {
                    this.$store.dispatch('resetAuthUserDetail');
                    this.$router.replace('/login')
                })
            },
            getAuthUserFullName(){
                return this.$store.getters.getAuthUserFullName;
            },
            getAuthUser(name){
                return this.$store.getters.getAuthUser(name);
            },
            isadminUser(){
                axios.get('/api/isadminuser')
                    .then(response =>
                        this.isadmin = response.data.status);
                return true;
            },
        },
        computed: {
            getAvatar(){
                return '/images/users/avatar.png';
            }
        }
    }
</script>
