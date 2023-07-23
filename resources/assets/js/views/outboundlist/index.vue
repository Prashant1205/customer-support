<template>
   

	<div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Outbound List</h3>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group search-form col-md-4 pull-left">
                            <label for="">Select Date range</label>
                            <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted' :color='color'
                                                  :buttonColor='buttonColor' range noShortcuts/>
                            <button type="button" class="search-btn" v-on:click="dataSearch"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                        <div class="export-btn col-md-6 pull-right text-right">
                            <button v-if="exportShow" type="button" class="btn btn-info mt-45" v-on:click="dataExport">Export</button>
                        </div>

                    </div>
                </div>
                <hr/>
                <div class="row">
                    <!--<div class="form-group col-md-6">
                        <label for="">Start Date</label>
                        <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted' :color='color'
                                              :buttonColor='buttonColor' range noShortcuts/>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <button style="border-radius: 0px;background-color: #343482;color: #fff;width: 250px;"
                                type="button" class="btn btn-default" v-on:click="dataSearch">Search
                        </button>
                    </div>-->
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Phone</th>
                                    <th>Contactable</th>
                                    <th>Problem</th>
                                    <th>Satisfied</th>
                                    <th>Accept payment</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="task in tasks.data">
                                    <td>{{task.phone}}</td>
                                    <td>{{yesNo[task.contactable]}}</td>
                                    <td class="wordbreak">{{problems[task.problem_id]}}</td>
                                    <td>{{yesNo[task.satisfied]}}</td>
                                    <td>{{yesNo[task.ready]}}</td>
                                    <td class="date-text">{{task.created_at}}</td>
                                    <td class="strip-text" width="200">
                                        <span v-if="task.remarks.length >= 60  && toggled == false">{{ task.remarks.substring(0,60)}}</span>
                                        <a style="color:#4145DF;" v-on:click="toggled =!toggled"
                                           v-show="task.remarks.length >= 60  && toggled == false">...Read more</a>

                                        <span v-if="toggled == true || task.remarks.length < 60">{{ task.remarks}}</span>
                                        <a style="color:#4145DF;" v-show="toggled == true && task.remarks.length > 60"
                                           v-on:click="toggled =!toggled">...Show Less</a>
                                    </td>
                                    <!--<td>{{task.remarks}}</td>-->
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
                                            <option value="10">10 per page</option>
                                            <option value="20">20 per page</option>
                                            <option value="30">30 per page</option>
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
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
    import ClickConfirm from 'click-confirm'

    export default {
        components : {pagination,ClickConfirm,  VueCtkDateTimePicker},
        data() {
            return {
                tasks: {},
                filterTaskForm: {
                    pageLength: 10
                },
                dateRnge: {
                    start: '',
                    end: ''
                },
                format: 'YYYY-MM-DD',
                formatted: 'YYYY-MM-DD',
                color: '#27337B',
                buttonColor: '#27337B',  
                toggled: false,
                problems: {},
                yesNo:{},
                exportShow: false,
            }
        },

        created() {
            this.getTasks();
            
        },

        mounted(){
            this.problems = ["", "Next Day Settlement", "Amount not credited yet", "QR lost/damaged","PhonePe/Paytm team removed QR", "Transaction message late/not coming", "Not able to scan QR", "Low business", "No Problem, happy to use", "Other"];
            this.yesNo = ["NO","YES"];
        },
        methods: { 
            getTasks(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/alloutbounddata?page=' + page + url)
                    .then(response => {
                        this.tasks = response.data})
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },

            dataSearch(page){
                // if (dateRnge != ""){
                    
               // }
                
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                axios.get('/api/auth/alloutboundsearch?&fromdate=' + fromdate + '&enddate=' + enddate)
                .then(response => {
                    if(response.data.data.length != 0){
                        this.exportShow = true; 
                    }else{
                        this.exportShow = false;
                    }
                    this.tasks = response.data;
                    })
                .catch(response => {
                    toastr['error'](response.message);
                });
                
            },

            dataExport(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/dataexportOutbound?&fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                        window.open(response.data)
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    });
               
            }

        }
    }
</script>
