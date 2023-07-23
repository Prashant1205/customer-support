<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">User</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <!-- add new user -->
                    <div class="card-body">
                        <h4 class="card-title">Add new user</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" v-model="addnew.name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" v-model="addnew.email" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" v-model="addnew.password" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Role</label>
                                    <select name="category" class="form-control" v-model="addnew.role" required>
                                        <option value="" disabled>Select</option>
                                        <option value="3">Executive</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-info waves-effect waves-light m-t-30"
                                            v-on:click="addNewuser"><span>Add new user</span></button>
                                </div>
                            </div>
                        </div>
                        <!-- add new user -->
                        <div class="page-titles p-3 border-bottom">
                            <h4 class="text-themecolor card-title">User List
                                <span class="card-subtitle"
                                      v-if="users.total">Total {{users.total}} result found!</span>
                                <span class="card-subtitle" v-else>No result found!</span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table" v-if="users.total">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th style="width:100px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in users.data">
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td v-html="getUserRole(user)"></td>
                                    <td v-html="getUserStatus(user)"></td>
                                    <td>{{user.created_at}}</td>
                                    <td>
                                        <click-confirm yes-class="btn btn-success" no-class="btn btn-danger">
                                            <button class="btn btn-info btn-sm" @click.prevent="deleteUser(user)"
                                                    data-toggle="tooltip" title="Change status"><i
                                                    class="fa fa-gear"></i></button>
                                        </click-confirm>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="users" :limit=3
                                                v-on:pagination-change-page="getUsers"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control"
                                                v-model="filterUserForm.pageLength" @change="getUsers"
                                                v-if="users.total">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import ClickConfirm from 'click-confirm'

    export default {
        components: {pagination, ClickConfirm},
        data() {
            return {
                users: {},
                addnew: new Form({
                    name: '',
                    email: '',
                    password: '',
                    role: '',

                }),
                filterUserForm: {
                    sortBy: 'name',
                    order: 'desc',
                    status: '',
                    title: '',
                    pageLength: 5
                }
            }
        },
        mounted() {
            this.isadminUser();
            this.getUsers();
        },
        methods: {
            getUsers(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterUserForm);
                axios.get('/api/user?page=' + page + url)
                    .then(response => this.users = response.data);
            },
            deleteUser(user) {
                axios.delete('/api/user/' + user.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getUsers();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            getUserStatus(user) {
                if (user.status == 1)
                    return '<span class="label label-success">Activated</span>';
                else if (user.status == 0)
                    return '<span class="label label-danger">Inactive</span>';
                else
                    return;
            },
            getUserRole(user) {
                if (user.role_type == 3)
                    return '<span>Executive</span>';
                else
                    return;
            },
            addNewuser() {
                this.addnew.post('/api/saveuser', {
                    //addnew: this.addnew
                })
                    .then(response => {
                        toastr['success'](response.message);
                        //this.$emit('completed',response.task);
                        this.getUsers();
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    });

            },

            isadminUser(){
                axios.get('/api/isadminuser')
                    .then(response =>{
                         if(response.data.status === false){
                            this.$router.push({path:'/'});
                         }
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
        },
        filters: {
            moment(date) {
                return helper.formatDate(date);
            },
            ucword(value) {
                return helper.ucword(value);
            }
        }
    }
</script>
