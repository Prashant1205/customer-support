<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Escalation</h3>
                <!--<ol class="breadcrumb">-->
                <!--<li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>-->
                <!--<li class="breadcrumb-item active">Escalation</li>-->
                <!--</ol>-->
            </div>
        </div>
        <div class="row">
            <div class="incompleted-task col-lg-6 col-md-6" @click="toggleListUiView(0)">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Incomplete Issues</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="fa fa-tasks text-info"></i> {{incomplete_count}}</h2>
                            <span class="text-muted">Incomplete</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="completed-task col-lg-6 col-md-6" @click="toggleListUiView(1)">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Completed Issues</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="fa fa-tasks text-info"></i> {{complete_count}}</h2>
                            <span class="text-muted">Completed</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group search-form col-md-4 pull-left">
                                    <label for="">Select Date range</label>
                                    <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted'
                                                          :color='color'
                                                          :buttonColor='buttonColor' range noShortcuts/>
                                    <button type="button" class="search-btn" v-on:click="dataSearch"><i
                                            class="fa fa-search"
                                            aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="export-btn col-md-6 pull-right text-right">
                                    <button v-if="exportShow" type="button" class="btn btn-info mt-45"
                                            v-on:click="dataExport">Export
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-show="completedUiShow">
                            <h4 class="card-title">Complete Issues</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Created</th>
                                        <th>UPI</th>
                                        <th>Remarks</th>
                                        <th>Issues from</th>
                                        <th>Issues to</th>
                                        <th width="100">Updated</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="task in tasksCompleted.data">
                                        <td class="wordbreak">{{task.name}}</td>
                                        <td>{{task.phone}}</td>
                                        <td class="date-text">{{task.created_at}}</td>
                                        <td>{{task.utr_upi}}</td>
                                        <td class="strip-text">
                                            <span v-if="task.description_form.length >= 60  && toggled == false">{{ task.description_form.substring(0,60)}}</span>
                                            <a style="color:#4145DF;" v-on:click="toggled =!toggled"
                                               v-show="task.description_form.length >= 60  && toggled == false">...Read
                                                more</a>

                                            <span v-if="toggled == true || task.description_form.length < 60">{{ task.description_form}}</span>
                                            <a style="color:#4145DF;"
                                               v-show="toggled == true && task.description_form.length > 60"
                                               v-on:click="toggled =!toggled">...Show Less</a>

                                            <!--{{task.description_form}}--></td>
                                        <td>{{ task.issue_date_from | moment }}</td>
                                        <td>{{ task.issue_date_to | moment }}</td>
                                        <td>{{ task.updated_at | moment }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-8">
                                        <pagination :data="tasksCompleted" :limit=3
                                                    v-on:pagination-change-page="getCompletedTasks"></pagination>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="float-right">
                                            <select name="pageLength" class="form-control"
                                                    v-model="filterCompletedTaskForm.pageLength"
                                                    @change="getCompletedTasks">
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
                        <div v-show="inCompletedUiShow">
                            <h4 class="card-title">Incomplete Issues</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Created</th>
                                        <th>UPI</th>
                                        <th>Remarks</th>
                                        <th>Issues from</th>
                                        <th>Issues to</th>
                                        <th width="120">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="task in tasks.data">
                                        <td class="wordbreak">{{task.name}}</td>
                                        <td>{{task.phone}}</td>
                                        <td>{{task.created_at}}</td>
                                        <td>{{task.utr_upi}}</td>
                                        <td class="strip-text">
                                            <span v-if="task.description_form.length >= 60  && toggled == false">{{ task.description_form.substring(0,60)}}</span>
                                            <a style="color:#4145DF;" v-on:click="toggled =!toggled"
                                               v-show="task.description_form.length >= 60  && toggled == false">...Read
                                                more</a>

                                            <span v-if="toggled == true || task.description_form.length < 60">{{ task.description_form}}</span>
                                            <a style="color:#4145DF;"
                                               v-show="toggled == true && task.description_form.length > 60"
                                               v-on:click="toggled =!toggled">...Show Less</a>
                                            <!--{{task.description_form}}--></td>
                                        <td>{{ task.issue_date_from | moment }}</td>
                                        <td>{{ task.issue_date_to | moment }}</td>
                                        <td>
                                            <button v-if="task.is_callback_issue_resolved==0"
                                                    class="btn btn-danger btn-sm"
                                                    @click.prevent="toggleTaskStatus(task)" data-toggle="tooltip"
                                                    title="Mark as Incomplete"><i class="fa fa-times"></i> Issues
                                                Pending
                                            </button>
                                            <button v-else class="btn btn-success btn-sm"
                                                    @click.prevent="toggleTaskStatus(task)" data-toggle="tooltip"
                                                    title="Mark as Complete"><i class="fa fa-check"></i> Issue Resolved
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-8">
                                        <pagination :data="tasks" :limit=3
                                                    v-on:pagination-change-page="getTasks"></pagination>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="float-right">
                                            <select name="pageLength" class="form-control"
                                                    v-model="filterTaskForm.pageLength" @change="getTasks">
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
    </div>
</template>
<script>
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
    import ClickConfirm from 'click-confirm'

    export default {
        components: {pagination, ClickConfirm, VueCtkDateTimePicker},
        data() {
            return {
                complete_count: '',
                incomplete_count: '',
                tasks: {},
                tasksCompleted: {},
                filterTaskForm: {
                    issue_status: '0',
                    sortBy: 'created_at',
                    order: 'desc',
                    pageLength: 5
                },
                filterCompletedTaskForm: {
                    issue_status: 1,
                    sortBy: 'created_at',
                    order: 'desc',
                    pageLength: 5
                },
                dateRnge: {
                    start: '',
                    end: ''
                },
                format: 'YYYY-MM-DD',
                formatted: 'YYYY-MM-DD',
                color: '#27337B',
                buttonColor: '#27337B',
                btnCode: 0,
                completedUiShow: false,
                inCompletedUiShow: true,
                exportShow: false,
                toggled: false,
            }
        },

        created() {
            this.getTasks();
        },

        mounted() {
            this.countEscalation();
            this.getCompletedTasks();
        },
        methods: {
            toggleTaskStatus(task) {
                axios.post('/api/auth/status', {id: task.id}).then((response) => {
                    this.getTasks();
                    this.countEscalation();
                    this.getCompletedTasks();
                });
            },
            getTasks(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/callbackdata?page=' + page + url)
                    .then(response => this.tasks = response.data)
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            getCompletedTasks(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterCompletedTaskForm);
                axios.get('/api/auth/callbackdata?page=' + page + url)
                    .then(response => this.tasksCompleted = response.data)
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            countEscalation() {
                axios.get('api/auth/countescalation').then(response => {
                    this.complete_count = response.data.complete_count;
                    this.incomplete_count = response.data.incomplete_count;
                });
            },
            toggleListUiView(val) {
                if (this.btnCode !== val) {
                    this.dateRnge = "";
                    this.btnCode = val;
                    this.completedUiShow = !this.completedUiShow;
                    this.inCompletedUiShow = !this.inCompletedUiShow;
                    this.exportShow = false;

                }
            },
            dataSearch(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                let url = helper.getFilterURL(this.filterTaskForm);
                if (this.completedUiShow == true) {
                    axios.get('/api/auth/escalationsearch?tabvalue=completed&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            if(response.data.data.length != 0){
                                this.exportShow = true; 
                            }else{
                                this.exportShow = false;
                            }
                            this.tasksCompleted = response.data
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                }

                if (this.inCompletedUiShow == true) {
                    axios.get('/api/auth/escalationsearch?tabvalue=incompleted&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            if(response.data.data.length != 0){
                                this.exportShow = true; 
                            }else{
                                this.exportShow = false;
                            }
                            this.tasks = response.data
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                }


            },

            dataExport(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                let url = helper.getFilterURL(this.filterTaskForm);
                if (this.completedUiShow == true) {

                    axios.get('/api/auth/escalationexport?tabvalue=completed&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            window.open(response.data)
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                }
                if (this.inCompletedUiShow == true) {

                    axios.get('/api/auth/escalationexport?tabvalue=incompleted&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            window.open(response.data)
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                }
            },

        },
        filters: {
            moment(date) {
                return helper.formatDate(date);
            }
        }
    }
</script>
