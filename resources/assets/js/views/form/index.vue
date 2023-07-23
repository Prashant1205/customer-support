<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Forms List</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group search-form col-md-4 pull-left">
                            <label for="">Select Date range</label>
                            <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted' :color='color' :buttonColor='buttonColor' range noShortcuts/>
                            <button type="button" class="search-btn" v-on:click="dataSearch"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                        <div class="export-btn col-md-6 pull-right text-right">
                            <button v-if="exportShow" type="button" class="btn btn-info mt-45" v-on:click="dataExport">Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row form-link-set" id="myDIV" style="text-align: center;">
                            <div class="col-lg-3">
                                <button type="button" v-bind:class="{ active: one }" class="btn btn-default mb-2" v-on:click="getAgents">Agent Request</button>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" v-bind:class="{ active: two }" class="btn btn-default mb-2" v-on:click="getPaymentlist">Payment Pending Issues</button>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" v-bind:class="{ active: three }" class="btn btn-default mb-2" v-on:click="getBankchangelist">Bank Account change</button>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" v-bind:class="{ active: four }" class="btn btn-default mb-2" v-on:click="getMerchantRevisitlist">Merchant Revisit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
        <!-- one -->
        <div class="row" v-show="one">
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Landmark</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="agents.data" v-for="agent in agents.data">
                                    <td>{{agent.name}}</td>
                                    <td>{{agent.phone}}</td>
                                    <td class="strip-text">{{agent.address}}</td>
                                    <td class="strip-text">{{agent.landmark}}</td>
                                    <td>{{agent.state}}</td>
                                    <td>{{agent.city}}</td>
                                    <td class="date-text">{{agent.created_at | moment}}</td>
                                    <td>
                                        <button v-if="agent.is_issue_resolved==0"
                                                class="btn btn-danger btn-sm"
                                                @click.prevent="toggleAgentStatus(agent)" data-toggle="tooltip"
                                                title="Mark as Incomplete"><i class="fa fa-times"></i> Issues
                                            Pending
                                        </button>
                                        <h6 v-else class="text-blue">Issue Resolved</h6>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="7">No data found</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="agents" :limit=3
                                                v-on:pagination-change-page="getAgents"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control"
                                                v-model="filterTaskForm.pageLength" @change="getAgents">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="20">20 per page</option>
                                            <option value="50">50 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>

        <!-- two -->
        <div class="row" v-show="two">
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Phone</th>
                                    <th>Txn History</th>
                                    <th>Home Screenshot</th>
                                    <th>Passbook Photos</th>
                                    <th>Date Of Transaction</th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="paymentpendings.data[0]" v-for="paymentpending in paymentpendings.data">
                                    <td>{{paymentpending.phone}}</td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(paymentpending.txn_history)">TXN History
                                    </td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(paymentpending.home_screenshot)">Home screen
                                    </td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(paymentpending.passbook)">passbook
                                    </td>
                                    <td class="date-text">{{paymentpending.date_of_transaction | moment}}</td>
                                    <td width="200">
                                        <span v-if="paymentpending.remark.length >= 60  && toggled == false">{{ paymentpending.remark.substring(0,60)}}</span>
                                        <a style="color:#4145DF;"  v-on:click="toggled =!toggled" v-show="paymentpending.remark.length >= 60  && toggled == false">...Read more</a>

                                        <span v-if="toggled == true ||paymentpending.remark.length < 60">{{ paymentpending.remark}}</span>
                                        <a style="color:#4145DF;" v-show="toggled == true && paymentpending.remark.length > 60" v-on:click="toggled =!toggled">...Show Less</a>
                                    </td>
                                    <!--<td>{{paymentpending.remark}}</td>-->
                                    <td class="date-text">{{paymentpending.created_at}}</td>
                                    <td>
                                        <button v-if="paymentpending.is_issue_resolved==0"
                                                class="btn btn-danger btn-sm"
                                                @click.prevent="togglePaymentStatus(paymentpending)" data-toggle="tooltip"
                                                title="Mark as Incomplete"><i class="fa fa-times"></i> Issues
                                            Pending
                                        </button>
                                        <h6 v-else class="text-blue">Issue Resolved</h6>
                                    </td>
                                    <td><button class="btn btn-success btn-sm" v-on:click="downloadPaymentZip(paymentpending.id)"><i class="fa fa-download"></i> Zip</button></td>

                                </tr>
                                <tr v-else>
                                    <td colspan="7">No data found</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="paymentpendings" :limit=3
                                                v-on:pagination-change-page="getPaymentlist"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control"
                                                v-model="filterTaskForm.pageLength" @change="getPaymentlist">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="20">20 per page</option>
                                            <option value="50">50 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
        <!-- three -->
        <div class="row" v-show="three">
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Registered No</th>
                                    <th>Email</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Old Account Cancelled cheque</th>
                                    <th>Old Account Type of Id</th>
                                    <th>Old Account IdProof</th>
                                    <th>New Account cancelled cheque</th>
                                    <th>New Account Type of Id</th>
                                    <th>New Account Idproof</th>
                                    <th>Existing Account screenshot</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="bankchangelist in bankchangelists.data">
                                    <td>{{bankchangelist.name}}</td>
                                    <td>{{bankchangelist.phone}}</td>
                                    <td class="date-text">{{bankchangelist.email}}</td>
                                    <td>{{bankchangelist.state}}</td>
                                    <td>{{bankchangelist.city}}</td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(bankchangelist.old_acc_cheque)">Old Acc Cancel Cheque
                                    </td>
                                    <td v-html='getidtype(bankchangelist.old_acc_typeofid)'></td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(bankchangelist.old_acc_idproof)">Old Acc Id Proof
                                    </td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(bankchangelist.cancel_cheque)"> New Acc cancel Cheque
                                    </td>
                                    <td v-html='getidtype(bankchangelist.typeofid)'></td>

                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(bankchangelist.idproof)">Id proof
                                    </td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromS(bankchangelist.existing_acc_screenshot)">Existing Acc
                                        screenshot
                                    </td>
                                     <td width="200">
                                            <span v-if="bankchangelist.reason.length >= 60  && toggled == false">{{ bankchangelist.reason.substring(0,60)}}</span>
                                            <a style="color:#4145DF;"  v-on:click="toggled =!toggled" v-show="bankchangelist.reason.length >= 60  && toggled == false">...Read more</a>

                                            <span v-if="toggled == true ||bankchangelist.reason.length < 60">{{ bankchangelist.reason}}</span>
                                            <a style="color:#4145DF;" v-show="toggled == true && bankchangelist.reason.length > 60" v-on:click="toggled =!toggled">...Show Less</a>
                                        </td>
                                    <td class="date-text">{{bankchangelist.created_at}}</td>
                                    <td>
                                        <button v-if="bankchangelist.is_issue_resolved==0"
                                                class="btn btn-danger btn-sm"
                                                @click.prevent="toggleBankStatus(bankchangelist)" data-toggle="tooltip"
                                                title="Mark as Incomplete"><i class="fa fa-times"></i> Issues
                                            Pending
                                        </button>
                                        <h6 v-else class="text-blue">Issue Resolved</h6>
                                    </td>
                                    <td><button class="btn btn-success btn-sm" v-on:click="downloadBankChangeZip(bankchangelist.id)"><i class="fa fa-download"></i> Zip</button></td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="bankchangelists" :limit=3
                                                v-on:pagination-change-page="getBankchangelist"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control"
                                                v-model="filterTaskForm.pageLength" @change="getBankchangelist">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="20">20 per page</option>
                                            <option value="50">50 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
        <!-- four -->
        <div class="row" v-show="four">
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Agent Phone</th>
                                    <th>Merchant Phone</th>
                                    <th>Merchant Problem</th>
                                    <th>Loan / cashback Explained</th>
                                    <th>App Update &amp; Feature Explained</th>
                                    <th>Merchant Satisfied</th>
                                    <th>Ready to accept Payment</th>
                                    <th>Merchant City</th>
                                    <th>Scan QR(App)</th>
                                    <th>Scan QR(sticker)</th>
                                    <th>Date</th>
                                    <!--<th>Action</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="revisit in revisits.data">
                                    <td>{{revisit.agent_phone}}</td>
                                    <td>{{revisit.merchant_phone}}</td>
                                    <td v-html='getMerchantproblem(revisit.merchant_problem)'></td>
                                    <td>{{revisit.loan_cashback}}</td>
                                    <td>{{revisit.app_feature}}</td>
                                    <td>{{revisit.merchant_satisfied}}</td>
                                    <td>{{revisit.accept_payment}}</td>
                                    <td>{{revisit.merchant_city}}</td>
                                    <td class="strip-text">{{revisit.scan_app}}</td>
                                    <td class="strip-text">{{revisit.scan_qr}}</td>
                                    <td class="date-text">{{revisit.created_at}}</td>
                                    <!--<td>-->
                                        <!--<button v-if="revisit.is_issue_resolved==0"-->
                                                <!--class="btn btn-danger btn-sm"-->
                                                <!--@click.prevent="toggleRevisitStatus(revisit)" data-toggle="tooltip"-->
                                                <!--title="Mark as Incomplete"><i class="fa fa-times"></i> Issues-->
                                            <!--Pending-->
                                        <!--</button>-->
                                        <!--<h6 v-else class="text-blue">Issue Resolved</h6>-->
                                    <!--</td>-->
                                </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="revisits" :limit=3
                                                v-on:pagination-change-page="getMerchantRevisitlist"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control"
                                                v-model="filterTaskForm.pageLength" @change="getMerchantRevisitlist">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="20">20 per page</option>
                                            <option value="50">50 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <img src="/images/loader.gif" id="loader">
                            <img src="" id="showimage">
                        </center>
                    </div>

                </div>

            </div>
        </div>

    </div>


</template>

<script>
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import ClickConfirm from 'click-confirm'

    export default {
        components: {pagination, ClickConfirm, VueCtkDateTimePicker},
        data() {
            return {
                agents: {},
                paymentpendings: {},
                bankchangelists: {},
                revisits: {},
                merchantproblem: {},
                typeid:{},
                filterTaskForm: {
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
                one: true,
                two: false,
                three: false,
                four: false,
                exportShow: false,
                toggled: false,
                
            }
        },
        mounted() {
            this.getAgents();
            //this.callactive();
        },
        created() {
        },

        methods: {
            getAgents(page) {
                this.exportShow = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.one = true;
                this.two = false;
                this.three = false;
                this.four = false;
                this.dateRnge = '';

               

                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/visit-agent-list?page=' + page + url)
                    .then(response => this.agents = response.data)
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            getPaymentlist(page) {
                this.exportShow = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.one = false;
                this.two = true;
                this.three = false;
                this.four = false;
                this.dateRnge = '';

               

                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/payment-pending-list?page=' + page + url)
                    .then(response => this.paymentpendings = response.data)
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            getBankchangelist(page) {
                this.exportShow = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.one = false;
                this.two = false;
                this.three = true;
                this.four = false;
                this.dateRnge = '';

              


                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/bank-account-change-list?page=' + page + url)
                    .then(response => this.bankchangelists = response.data)
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            getMerchantRevisitlist(page) {
                this.exportShow = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.one = false;
                this.two = false;
                this.three = false;
                this.four = true;
                this.dateRnge = '';


                let url = helper.getFilterURL(this.filterTaskForm);
                axios.get('/api/auth/merchant-revisit-list?page=' + page + url)
                    .then(response => this.revisits = response.data)
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            getMerchantproblem(problem_ids) {
                var merchantproblem = {
                    '1': 'Next Day Settlement',
                    '2': 'Amount not credited yet',
                    '3': 'QR lost/damaged',
                    '4': 'PhonePe/Paytm team removed QR',
                    '5': 'Transaction message late/not coming',
                    '6': 'Not able to scan QR',
                    '7': 'Low business',
                    '8': 'Customer support',
                    '9': 'Owner not available',
                    '10': 'Cashback Problem(Cashback not credited)',
                    '11': 'Need Cashback',
                    '12': 'Personal Issue',
                    '13': 'No Problem, happy to use',
                    '14': 'Other'
                };
                var content = '';
                var val = 0;
                var res = problem_ids.split(",");
                $.each(res, function (key, value) {
                    content += merchantproblem[value] + "<br>";
                });
                return content;
            },

            dataSearch(page) {
                
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                let url = helper.getFilterURL(this.filterTaskForm);
                if (this.one == true) {

                    axios.get('/api/auth/data-search?tabvalue=agent&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response =>{
                            if(response.data.data.length != 0){
                                this.exportShow = true;
                            }else{
                                this.exportShow = false;
                            }
                            this.agents = response.data
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                } else if (this.two == true) {

                    axios.get('/api/auth/data-search?tabvalue=payment&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            if(response.data.data.length != 0){
                                this.exportShow = true;
                            }else{
                                this.exportShow = false;
                            }
                            this.paymentpendings = response.data
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                } else if (this.three == true) {
                    axios.get('/api/auth/data-search?tabvalue=bank&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            if(response.data.data.length != 0){
                                this.exportShow = true;
                            }else{
                                this.exportShow = false;
                            }
                            this.bankchangelists = response.data
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                } else if (this.four == true) {
                    axios.get('/api/auth/data-search?tabvalue=merchant&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            if(response.data.data.length != 0){
                                this.exportShow = true;
                            }else{
                                this.expoertShow = false;
                            }
                            this.revisits = response.data
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
                if (this.one == true) {

                    axios.get('/api/auth/data-export?tabvalue=agent&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            window.open(response.data)
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                } else if (this.two == true) {

                    axios.get('/api/auth/data-export?tabvalue=payment&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            window.open(response.data)
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                } else if (this.three == true) {
                    axios.get('/api/auth/data-export?tabvalue=bank&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            window.open(response.data)
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                } else if (this.four == true) {
                    axios.get('/api/auth/data-export?tabvalue=merchant&fromdate=' + fromdate + '&enddate=' + enddate)
                        .then(response => {
                            window.open(response.data)
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
                }
            },
            getImageFromS(filepath) {
                $('#loader').css('display', 'block');
                $('#showimage').css('display', 'none');
                $('#showimage').attr('src', '');
                axios.get('/getimg?file=' + filepath)
                    .then(response => {
                        $('#loader').hide();
                        $('#showimage').show();
                        $('#showimage').attr('src', response.data.file);
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            getidtype(idtype) {
                if(!idtype)return 'NA';
                var typeid = {
                    '1': 'Aadhar card',
                    '2': 'Pan Card',
                    '3': 'Voter ID',
                    '4': 'Driving License'
                };
                var content = typeid[idtype];
                return content;
            },

            downloadPaymentZip(id){
                axios.get('/api/auth/data-export-zip?tabvalue=paymentpending&id=' + id)
                        .then(response => {
                            window.open(response.data);
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
            },

            downloadBankChangeZip(id){
                axios.get('/api/auth/data-export-zip?tabvalue=bankaccount&id=' + id)
                        .then(response => {
                            window.open(response.data);
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
            },

            toggleAgentStatus(agent){
                axios.post('/api/auth/status-update?tabvalue=agent&id=' + agent.id)
                .then((response) => {
                    this.getAgents();  
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },

            togglePaymentStatus(paymentpending){
                axios.post('/api/auth/status-update?tabvalue=payment&id=' + paymentpending.id)
                .then((response) => {
                    this.getPaymentlist();
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },

            toggleBankStatus(bankchangelist){
                axios.post('/api/auth/status-update?tabvalue=bank&id=' + bankchangelist.id)
                .then((response) => { 
                    this.getBankchangelist();
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },

            toggleRevisitStatus(revisit){
                axios.post('/api/auth/status-update?tabvalue=merchant&id=' + revisit.id)
                .then((response) => {
                    this.getMerchantRevisitlist();
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
          
        },
        filters: {
            moment(date) {
                return helper.formatDate(date);
            }
        }
    }
</script>
