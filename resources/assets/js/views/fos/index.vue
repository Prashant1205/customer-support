<template>


    <div class="fos-section">
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Fos List</h3>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form @submit.prevent="proceed">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group search-form col-md-2 pull-left">
                                <label for="">Select Date range</label>
                                <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted' :color='color' :buttonColor='buttonColor' range noShortcuts/>
                            </div>
                            <div class="form-group search-form col-md-3 pull-left">
                                <label for="">Enter Mobile</label>
                                <input class="form-control" type="text" value=""  v-model="fosSearchForm.phone" pattern="[0-9]{10}" @keyup="validatePhone">
                            </div>
                            <div class="form-group search-form col-md-2 pull-left">
                                <label for="">Select City</label>
                                <select name="city" class="form-control" v-model="fosSearchForm.city">
                                    <option value="">Select city</option>
                                  <option v-for="city in cityList.data">{{city.city_name}}</option>
                                </select>
                            </div>
                            <div class="form-group search-form col-md-2 pull-left">
                                <label for="">Select Status</label>
                                <select name="status" class="form-control" v-model="fosSearchForm.status">
                                    <option value="" >All</option>
                                    <option value="APPROVED">Approved</option>
                                    <option value="REJECTED">Rejected</option>
                                    <option value="PENDING_VERIFICATION">Pending</option>
                                </select>
                            </div>
                            <div class="form-group search-form col-md-3 pull-left">
                                <button type="button" class="btn btn-info waves-effect waves-light m-t-30" v-on:click="getFosSaerchList" ><span>Search</span></button>
                                <button v-if="exportShow"  type="button" class="btn btn-info mt-45" v-on:click="dataExport">Export</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Merchant Business Name</th>
                                    <th>Merchant Name</th>
                                    <th>Merchant Business Phone</th>
                                    <th>Referral Code</th>
                                    <th>Merchant City</th>
                                    <th>merchant Images</th>
                                    <th>Reason</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Download Image</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="task in fosList.data">
                                    <td class="date-text">{{task.created_at}}</td>
                                    <td class="wordbreak cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromFosVal(task.merchant_id)">{{task.business_name}}</td>
                                      <td class="wordbreak cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromFosVal(task.merchant_id)">{{task.merchant_name}}</td>
                                    <td class="wordbreak cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromFosVal(task.merchant_id)">{{task.business_phone}}</td>
                                    <td class="wordbreak cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromFosVal(task.merchant_id)">{{task.referral_code}}</td>
                                    <td class="wordbreak cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromFosVal(task.merchant_id)">{{task.merchantcity}}</td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                        v-on:click="getImageFromFosVal(task.merchant_id)">View Images</td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                         v-on:click="getImageFromFosVal(task.merchant_id)">{{task.reason}}</td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                         v-on:click="getImageFromFosVal(task.merchant_id)">{{task.comment}}</td>
                                    <td class="cursor-pointer" data-toggle="modal" data-target="#myModal"
                                         v-on:click="getImageFromFosVal(task.merchant_id)">{{task.status}}</td>
                                     <td>
                                        <button class="btn btn-success btn-sm" v-on:click="downloadImagesZip(task.merchant_id)">
                                        <i class="fa fa-download"></i> Zip</button>
                                    </td>
                                    
                                    <!-- <td></td> -->
                                </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="fosList" :limit=3
                                                v-on:pagination-change-page="getFosSaerchList"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control"
                                                v-model="filterFosSearchForm.pageLength" @change="getFosSaerchList">
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
        <div id="myModal" class="modal" role="dialog">
            <div class="modal-dialog modal-lg" style="width:80%;">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <p id="heado" class="modal-title tex"></p>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                          
                        <center>
                            <img src="/images/loader.gif" id="loader">
                            <h1 id="text1" class="tex"></h1>
                            <img src="" id="file_1" class="showimage">
                            <h1 id="text2" class="tex"></h1>
                            <img src="" id="file_2" class="showimage">
                            <h1 id="text3" class="tex"></h1>
                            <img src="" id="file_3" class="showimage">
                        </center>
                    </div>
                    <div v-if="merchantstatus =='PENDING_VERIFICATION'" class="modal-footer">
          <button type="button" class="btn btn-default bttn" @click.prevent="toggleTaskStatus(merchantid,'APPROVED')" data-dismiss="modal">Approved</button>
           <button type="button" class="btn btn-default bttn" data-toggle="modal" data-target="#myModal1" data-dismiss="modal">Rejected</button>
        </div>

                </div>

            </div>
        </div>
        <div id="myModal1" class="modal" role="dialog">
            <div class="modal-dialog modal-lg" style="width:80%;">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">Add Reason</p>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                             <label for="reason">Reason</label>
                         
                         <select class="form-control" v-model="rejectform.reason">
                        <option value="Pictures are blur">Pictures are blur</option>
                        <option value="Camera position is not correct to verify ">Camera position is not correct to verify </option>
                        <option value="Different Name On QR Sticker">Different Name On QR Sticker</option>
                        <option value="No Name on QR Sticker">No Name on QR Sticker</option>
                        <option value="Different Business Name">Different Business Name</option>
                        <option value="Fake Photos">Fake Photos</option>
                        <option value="Facade Not valid">Facade Not valid</option>
                        <option value="Cash Counter">Cash Counter</option>
                        <option value="Close Up QR">Close Up QR</option>
                        </select>
                         
                          </div>
                         <div class="form-group">
                             <label for="comment">Comment</label>
                           
                               <input class="form-control" type="text" v-model="rejectform.comment" >
                           
                         </div>
                        
                    </div>
                    <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-default" @click.prevent="toggleTaskrejectStatus(merchantid,'REJECTED','reason','comment')" data-dismiss="modal">Rejected</button>
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
        components : {pagination, ClickConfirm,  VueCtkDateTimePicker},
        data() {
            return {
                complete_count: '',
                incomplete_count: '',
                merchantdata:{},
                fosList: {},
                cityList: {},
                filterFosSearchForm: {
                    sortBy : 'created_at',
                    order: 'desc',
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
                fosSearchForm: new Form({
                    'date': '', 
                    'phone': '',
                    'action': '',
                    'status': '',
                    'city':''
                }),
                rejectform: new Form({
                    'reason': '',
                    'comment': '',
                }),
                merchantid:'',
                merchantstatus:'',
                exportShow:false,
            }
        },

        created() {
            // this.getFosList();

        },
        beforeMount(){
            this.getCityList();
        },

        mounted(){
        },
        methods: {
            getFosSaerchList(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterFosSearchForm);
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                var phone = this.fosSearchForm.phone;
                var status = this.fosSearchForm.status;
                var city = this.fosSearchForm.city;

                if(phone == '' && fromdate == 'Invalid date' && enddate == 'Invalid date'){
                    toastr['error']("Please enter date and mobile no.");
                    return true;
                } 

                axios.get('/api/auth/allfos?page=' + page + url,
                    {
                        params: {
                            phone: phone,
                            status: status,
                            fromdate :fromdate,
                            enddate : enddate,
                            city:city
                        }
                    })
                    .then(response => {
                        if(response.data.data.length != 0){
                            this.exportShow = true;
                        }else{
                            this.exportShow = false;
                        }
                       
                        this.fosList = response.data;
                    });
            },

            dataExport(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                var phone = this.fosSearchForm.phone;
                var status = this.fosSearchForm.status;
                var city = this.fosSearchForm.city;
                let url = helper.getFilterURL(this.filterFosSearchForm);
                axios.get('/api/auth/datafosList',
                {
                    params: {
                        phone: phone,
                        city: city,
                        fromdate :fromdate,
                        enddate : enddate,
                        status:status
                    }

                })
                    .then(response => {
                        window.open(response.data)
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    });

            },

            validatePhone(event){
                if(event.keyCode==13){
                    this.searchQuery();
                    event.preventDefault();
                }
                var len = this.fosSearchForm.phone.length;
                if (!/^[0-9]*$/.test(event.key) && !/^[0-9]*$/.test(this.fosSearchForm.phone)) {
                    this.fosSearchForm.phone = this.fosSearchForm.phone.substr(0, len - 1);
                }
                if(len>10){
                    this.fosSearchForm.phone = this.fosSearchForm.phone.substr(0, 10);
                }
            },

            getImageFromFosVal(filepath) {
                $('#loader').css('display', 'block');
                $('.showimage').css('display', 'none');
                $('.tex').css('display', 'none');
                $('.bttn').css('display', 'none');
                $('.showimage').attr('src', '');
                axios.get('/getfosimages?file=' + filepath)
                    .then(response => {
                        $('#loader').hide();
                        $('.showimage').show();
                        $('.tex').show();
                        $('.bttn').show();
                        console.log(response.data.merchantdata[0].businessname);
                        this.merchantid = response.data.merchantdata[0].id;
                        this.merchantstatus = response.data.merchantdata[0].status;
                        $('#heado').text("Merchant Details:"+ response.data.merchantdata[0].merchantname + ",   " +
                        response.data.merchantdata[0].mobile.substring(2) + ",   "+
                        response.data.merchantdata[0].merchantcity);
                        $('#text1').text(response.data.data[0]);
                        $('#text2').text(response.data.data[1]);
                        $('#text3').text(response.data.data[2]);
                        $('#file_1').attr('src', response.data.data.url0);
                        $('#file_2').attr('src', response.data.data.url1);
                        $('#file_3').attr('src', response.data.data.url2);
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            toggleTaskStatus(merchantid,status) {
                axios.post('/api/auth/fosstatus', {id: merchantid,status:status}).then((response) => {
                    this.getFosSaerchList(1);
                });
            },
            toggleTaskrejectStatus(merchantid,status,reason,comment) {
               var reason = this.rejectform.reason;
                var comment = this.rejectform.comment;
                axios.post('/api/auth/reject', {id: merchantid,status:status,reason:reason,comment:comment}).then((response) => {
                    this.getFosSaerchList(1);
                });
            },
            downloadImagesZip(id){
                axios.get('/api/auth/get-merchant-images?id=' + id)
                        .then(response => {
                            window.open(response.data);
                        })
                        .catch(response => {
                            toastr['error'](response.message);
                        });
            },
            getCityList(){
                axios.get('/api/auth/getCityList')
                    .then(response => {                       
                        this.cityList = response.data;
                    })
                    .catch(response => {
                        toastr['error'](response.error);
                    })
            },
        },
    }
</script>