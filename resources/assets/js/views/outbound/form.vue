<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
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
                            <li class="list-group-item"><span>City: </span>{{taskForm.merchantcity}}, <span>State: </span>{{taskForm.merchantstate}}</li>
                        </ul>
                    </div>
                    <div class="form-group col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item active">Account detail</li>
                            <li class="list-group-item"><span>UPI id: </span>{{taskForm.upiid}}</li>
                            <li class="list-group-item"><span>Settlement type: </span>{{taskForm.settlement}}</li>
                            <li class="list-group-item"><span>Change Date: </span></li>
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
                    <div class="form-group col-md-6">
                        <label for="">Contactable</label>
                        <select name="category" class="form-control" v-model="taskForm.contactable" @change="onChange($event)">
                            <option value="" disabled>Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="row" v-show="marchntSatisfyUiShow">

                    <div class="form-group col-md-6">
                        <label for="">Merchant Problem</label>
                        <select name="category" class="form-control" v-model="taskForm.problem_id">
                            <option value="" disabled>Select</option>
                            <option value="1">Next Day Settlement</option>
                            <option value="2">Amount not credited yet</option>
                            <option value="3">QR lost/damaged</option>
                            <option value="4">PhonePe/Paytm team removed QR</option>
                            <option value="5">Transaction message late/not coming</option>
                            <option value="6">Not able to scan QR</option>
                            <option value="7">Low business</option>
                            <option value="8">No Problem, happy to use</option>
                            <option value="9">Other</option>

                        </select>
                    </div>
                </div>
                <div class="row"  v-show="marchntSatisfyUiShow">
                    <div class="form-group col-md-6">
                        <label for="">Merchant Satisfied with end of day settlement</label>
                        <select name="category" class="form-control" v-model="taskForm.satisfied">
                            <option value="" disabled>Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="row"  v-show="marchntSatisfyUiShow">
                    <div class="form-group col-md-6">
                        <label for="">Merchant ready to accept payments through bharatpe</label>
                        <select name="category" class="form-control" v-model="taskForm.ready">
                            <option value="" disabled>Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>



                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Remarks</label>
                        <textarea class="form-control" type="text" value="" v-model="taskForm.remarks" rows="4" @keyup="validateData"></textarea>
                    </div>
                </div>
            </div>
        </div>


        <button type="button" @click="proceed" class="btn btn-info waves-effect waves-light m-t-10"><span>Save</span></button>
        <router-link to="/task" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link>
    </form>
</template>


<script>
    import datepicker from 'vuejs-datepicker'
    import RangeSlider from 'vue-range-slider'
    import 'vue-range-slider/dist/vue-range-slider.css'
    import helper from '../../services/helper'

    export default {
        data() {
            return {
                taskForm: new Form({
                    'phone':'',
                    'problem_id':'',
                    'satisfied':'',
                    'ready':'',
                    'contactable':'',
                    'remarks':'',
                    'settlement':'',

                    'businessname':'',
                    'merchantcity':'',
                    'merchantname':'',
                    'merchantstate':'',
                    'referralcode':'',
                    'upiid':'',
                    'agent_name':'',
                    'agent_city':'',
                }),
                hideShow: false,
                marchntSatisfyUiShow: false,
            };

        },
        components : { datepicker,RangeSlider },
        props: ['id'],
        mounted() {
            // if(this.id)
            //     this.getTasks();
        },
        methods: {
            sliderChange(value){
                this.taskForm.progress = value;
            },
            proceed(){
                if(this.id)
                    this.updateTask();
                else
                    this.storeTask();
            },
            storeTask(){
                this.taskForm.post('/api/outbound')
                .then(response => {
                    toastr['success'](response.message);
                    this.$emit('completed',response.task);
                    this.hideShow = false;
                    this.marchntSatisfyUiShow = false;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            searchQuery(){
                axios.get('/api/query_search',{
                    params: {
                        phone: this.taskForm.phone,
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
                    this.hideShow = true;
                })
                    .catch(response => {
                        toastr['error'](response.message);
                    });
            },
            validateData(event){
                if (!/^[0-9a-zA-Z ]*$/.test(event.key)) {
                    var len = this.taskForm.remarks.length;
                    this.taskForm.remarks = this.taskForm.remarks.substr(0, len - 1);
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
            onChange(event) {
                if (event.target.value ==1) {
                    this.marchntSatisfyUiShow = !this.marchntSatisfyUiShow;
                }else{
                    this.marchntSatisfyUiShow = false;
                }

            },
        }
    }
</script>
<style>
    .slider{
        width: 100%;
    }
</style>
