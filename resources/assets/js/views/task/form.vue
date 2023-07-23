<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Customer Name</label>
                        <input class="form-control" type="text" value="" v-model="taskForm.name" @keyup="validateName">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Customer Phone</label>
                        <input class="form-control" type="text" value="" v-model="taskForm.phone" pattern="[0-9]{10}" @keyup="validatePhone">
                    </div>
                    <div class="form-group col-md-4 text-right">
                        <button type="button" class="btn btn-info waves-effect waves-light m-t-30" v-on:click="searchQuery"><span>Verify</span></button>
                    </div>
                </div>
                <div class="row fetch-detail" v-show="hideShow">
                    <div class="form-group col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item active">Merchant Details</li>
                            <li class="list-group-item"><span>Name: </span>{{taskForm.merchantname}}</li>
                            <li class="list-group-item"><span>Business Name: </span>{{taskForm.businessname}}</li>
                            <li class="list-group-item"><span>City: </span>{{taskForm.merchantcity}},
                                <span>State: </span>{{taskForm.merchantstate}}
                            </li>
                        </ul>
                    </div>

                    <div class="form-group col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item active">Account detail</li>
                            <li class="list-group-item"><span>UPI id: </span>{{taskForm.upiid}}</li>
                            <li class="list-group-item"><span>Settlement type: </span>{{taskForm.settlement}}</li>
                            <li class="list-group-item"><span>Change Date: </span>{{taskForm.daily_date}}</li>
                        </ul>
                    </div>

                    <div class="form-group col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item active">Agent Detail</li>
                            <li class="list-group-item"><span>Name: </span>{{taskForm.agent_name}}</li>
                            <li class="list-group-item"><span>City: </span>{{taskForm.agent_city}}</li>
                            <li class="list-group-item"><span>Referral Code: </span>{{taskForm.referralcode}}</li>

                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Category</label>
                        <select name="category" class="form-control" v-model="taskForm.category_id"
                                @change="getSubcategories">
                            <option value="" disabled>Select</option>
                            <option v-for="category in categories" v-bind:key="category.status_id"
                                    v-bind:value="category.status_id"> {{ category.status_name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="">Sub Category</label>
                        <select name="sub_category" class="form-control" v-model="taskForm.sub_category_id"
                                @change="getSubcategoriesComment">
                            <option value="" disabled>Select</option>
                            <option v-for="subcategory in subcategories" v-bind:key="subcategory.id"
                                    v-bind:value="subcategory.id"> {{ subcategory.sub_status_name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 description-div" v-show="subCatDesc">
                        <label class="description-text" v-model="desc">{{description}}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Select date range</label>
                        <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted' :color='color' :buttonColor='buttonColor' range noShortcuts/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">UTR UPIID</label>
                        <input class="form-control" type="text" value="" v-model="taskForm.utr_upi" @keyup="validateUtr">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Time out</label>
                        <select name="timeout" class="form-control" v-model="taskForm.is_time_out">
                            <option value="" disabled>Select</option>
                            <option value="1">TimeOut/NA</option>
                            <option value="2">TimeOut/RRC</option>
                            <option value="3">TimeOut/TCC</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group  col-md-6">
                        <label for="">Google Form</label>
                        <select name="google_form" class="form-control" v-model="taskForm.google_form_id">
                            <option value="" disabled>Select</option>
                            <option v-for="gf in googleform" v-bind:key="gf.id" v-bind:value="gf.id"> {{ gf.name}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 text-right">
                            <button type="button" class="btn btn-info waves-effect waves-light m-t-30" v-on:click="sendSMS"><span>Send SMS</span></button>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" v-model="taskForm.payement_team" value="0">Mark payment Team
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" v-model="taskForm.backend_team" value="0">Mark Backend Team
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Description</label>
                        <textarea class="form-control" type="text" value="" v-model="taskForm.description_form"
                                  rows="6" @keyup="validateData"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" v-model="taskForm.mark_callback" value="0">Mark
                                Callback
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </div>
                </div>
              <div class="row">
                  <div class="form-group col-md-4">
                  <button type="button" @click="proceed" class="btn btn-info waves-effect waves-light m-t-10">
                      <!--<span v-if="id">Update</span>-->
                      <!--<span v-else>Save</span>-->
                      <span>Save</span>
                  </button>
                  </div>
              </div>
            </div>
            <div class="col-md-3" v-show="hideShow">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">HISTORY  <span class="badge badge-primary">{{history.length}}</span></span>
                </h4>

                <div class="pre-scrollable" style="max-height: 85vh">
                    <ul class="list-group mb-3">
                        <li class="list-group-item" v-if="indx <= history.length" v-for="indx in historyToShow">
                            <div>
                                <small class="text-muted"><b>{{indx}}</b>/<b>{{history.length}}</b></small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Name:</b> {{history[indx-1].customer_name}}</small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Phone:</b> {{history[indx-1].customer_phone}}</small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Category:</b> {{history[indx-1].status_name}}, {{history[indx-1].sub_status_name}}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Remarks:</b> {{history[indx-1].remarks}}</small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Comment:</b> {{history[indx-1].description_form}}</small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Created Time:</b> {{history[indx-1].created_at}}</small>
                            </div>
                            <div>
                                <small class="text-muted"><b>Agent name:</b> {{history[indx-1].name}}</small>
                            </div>
                        </li>


                    </ul>
                    <div class="text-center p-10">
                        <button type="button" class="btn btn-success btn-sm" @click="historyToShow += 2">Show More</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>


<script>
    import datepicker from 'vuejs-datepicker'
    import DatePicker from 'vue2-datepicker'
    import RangeSlider from 'vue-range-slider'
    import 'vue-range-slider/dist/vue-range-slider.css'
    import helper from '../../services/helper'
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
    import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css'

    export default {
        data() {
            return {
                taskForm: new Form({
                    'name': '',
                    'phone': '',
                    'category_id': '',
                    'sub_category_id': '',
                    'issue_date_from': '',
                    'issue_date_to': '',
                    'utr_upi': '',
                    'send_sms': '',
                    'google_form_id': '',
                    'payement_team': '',
                    'backend_team': '',
                    'description_form': '',
                    'mark_callback': '',
                    'settlement': '',
                    'daily_date': '',
                    'description': '',
                    'businessname': '',
                    'merchantcity': '',
                    'merchantname': '',
                    'merchantstate': '',
                    'referralcode': '',
                    'upiid': '',
                    'agent_name': '',
                    'agent_city': '',
                    'is_time_out':'',
                }),
                'categories': {},
                'subcategories': {},
                'description': '',
                'googleform': {},
                'history': {},
                'desc':'',
                hideShow: false,
                disabled: true,
                dateRnge: {
                    start: '',
                    end: ''
                },
                format: 'YYYY-MM-DD',
                formatted: 'YYYY-MM-DD',
                color: '#27337B',
                buttonColor: '#27337B',
                subCatDesc: false,
                historyToShow: 3,
            };

        },
        components: {DatePicker,datepicker, RangeSlider, VueCtkDateTimePicker},
        props: ['id'],
        mounted() {
            this.loadCategory();
            this.googleForm();
        },
        methods: {
            sliderChange(value){
                this.taskForm.progress = value;
            },
            proceed(){
                if (this.dateRnge.end != null) {
                    this.taskForm.issue_date_from = moment(this.dateRnge.start).format('YYYY-MM-DD');
                    this.taskForm.issue_date_to = moment(this.dateRnge.end).format('YYYY-MM-DD');
                }else{
                    this.taskForm.issue_date_from = moment(this.dateRnge.start).format('YYYY-MM-DD');
                    this.taskForm.issue_date_to = this.taskForm.issue_date_from;
                }

                if(this.id)
                    this.updateTask();
                else
                    this.storeTask();
            },
            storeTask(){
                this.taskForm.post('/api/query')
                .then(response => {
                    toastr['success'](response.message);
                    this.$emit('completed',response.task)
                    this.hideShow = false;
                    this.subCatDesc = false;
                    this.dateRnge = '';
                    this.disabled = true;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            searchQuery(){
                this.getCustomerHistory();
                axios.get('/api/query_search',{
                    params: {
                        phone: this.taskForm.phone,
                        name: this.taskForm.name,
                    }
                }).then(response => {
                    this.taskForm.merchantname = response.data.merchantname;
                    this.taskForm.businessname = response.data.businessname;
                    this.taskForm.merchantcity = response.data.merchantcity;
                    this.taskForm.merchantstate = response.data.merchantstate;
                    this.taskForm.referralcode = response.data.referralcode;
                    this.taskForm.upiid = response.data.upiid;
                    this.taskForm.agent_name = response.data.agent_name;
                    this.taskForm.agent_city = response.data.agent_city;
                    this.taskForm.settlement = response.data.settlement;
                    this.taskForm.daily_date = response.data.daily_date;
                    this.hideShow = true;
                }).catch(response => {
                        toastr['error']("Oops!!! No Record found");
                        this.hideShow = false;
                    });
            },
            sendSMS(){
                let phone  =this.taskForm.phone;
                let name  =this.taskForm.name;
                let google_form_id  =this.taskForm.google_form_id;
                if(name == ""){
                    toastr['error']("Please enter valid name.");
                    return true;
                }
                if(phone.length != 10 ){
                    toastr['error']("Please enter valid phone.");
                    return true;
                }
                if(google_form_id == 0){
                    toastr['error']("Please select google form.");
                    return true;
                }
                axios.get('/api/sendsms',{
                    params: {
                        phone: phone,
                        name: name,
                        google_form_id: google_form_id,
                    }
                }).then(response => {
                    toastr['success']("SMS send successfully.");
                })
                    .catch(response => {
                        toastr['error']("No History found.");
                    });
            },
            getCustomerHistory(){
                axios.get('/api/getcustomerhistory',{
                    params: {
                        phone: this.taskForm.phone,
                    }
                }).then(response => {
                    this.history = response.data;
                })
                    .catch(response => {
                        toastr['error']("No History found.");
                    });
            },
            getTasks(){
                return true;
                axios.get('/api/query/'+this.id)
                .then(response => {
                    this.taskForm.title = response.data.title;
                    this.taskForm.description = response.data.description;
                    this.taskForm.start_date = response.data.start_date;
                    this.taskForm.due_date = response.data.due_date;
                    this.taskForm.progress = response.data.progress;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            updateTask(){
                this.taskForm.patch('/api/query/'+this.id)
                .then(response => {
                    if(response.type == 'error')
                        toastr['error'](response.message);
                    else {
                        this.$router.push('/query');
                    }
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            loadCategory(){
                axios.get('api/categorylist').then(response => {
                    this.categories = response.data;

                }).catch(response => {
                    toastr['error'](response.message);
                })
            },
            getSubcategories(){
                if(!this.taskForm.category_id)return false;
                axios.get('api/subcategorylist',{
                    params: {
                        category_id: this.taskForm.category_id,
                    }
                }).then(response => {
                    this.subcategories = response.data;
                }).catch(response => {
                    toastr['error'](response.message);
                })
            },
            getSubcategoriesComment(){
                if(!this.taskForm.category_id)return false;
                axios.get('api/subcategorydesc',{
                    params: {
                        sub_category_id: this.taskForm.sub_category_id,
                    }
                }).then(response => {
                    this.subCatDesc = true;
                    this.description = response.data.description;
                }).catch(response => {
                    toastr['error'](response.message);
                })
            },
            googleForm(){
                axios.get('api/googleform').
                then(response => {
                    this.googleform = response.data;
                }).catch(response => {
                    toastr['error'](response.message);
                })
            },
            validateData(event){
                if (!/^[0-9a-zA-Z ]*$/.test(event.key)) {
                    var len = this.taskForm.description_form.length;
                    this.taskForm.description_form = this.taskForm.description_form.substr(0, len - 1);
                }
            },
            validateUtr(event){
                if (!/^[0-9a-zA-Z ]*$/.test(event.key)) {
                    var len = this.taskForm.utr_upi.length;
                    this.taskForm.utr_upi = this.taskForm.utr_upi.substr(0, len - 1);
                }
            },
            validateName(event){
                if (!/^[a-zA-Z ]*$/.test(event.key)) {
                    var len = this.taskForm.name.length;
                    this.taskForm.name = this.taskForm.name.substr(0, len - 1);
                }
            },
            validatePhone(event){
                if(event.keyCode==13){
                    this.searchQuery();
                    event.preventDefault();
                }
                var len = this.taskForm.phone.length;
                if (!/^[0-9]*$/.test(event.key) && !/^[0-9]*$/.test(this.taskForm.phone)) {
                    this.taskForm.phone = this.taskForm.phone.substr(0, len - 1);
                }
                if(len>10){
                    this.taskForm.phone = this.taskForm.phone.substr(0, 10);
                }
            },
            updateSelector(){
                this.disabled = !this.disabled;
                $('#gogl_form  option[value=""]').prop("selected", true);
            }
        }
    }
</script>