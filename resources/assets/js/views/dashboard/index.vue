<template>
    
<div>
    <div class="row">
        <div class="col-md-12">
                        <div class="form-group search-form col-md-4 pull-left">
                            <label for="">Select Date range</label>
                            <VueCtkDateTimePicker v-model="dateRnge" :format='format' :formatted='formatted' :color='color' :buttonColor='buttonColor' range noShortcuts/>
                            <button type="button" class="search-btn" :disabledDates="disabledDates" v-on:click="getAgentCount"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                        
                    </div>
     </div>

	<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-lg-6 col-12">
			<div class="card">
		
        <h3>Compaints</h3>
        <GChart type="ColumnChart" :data="chartData" :options="chartOptions"/>
    
			</div>
		</div>


		<div class="col-md-6 col-lg-6 col-12">
			<div class="card">
			 <h3>Query</h3>
        <GChart type="ColumnChart" :data="queryData" :options="chartOptions"/>
			</div>
		</div>

		<div class="col-md-6 col-lg-6 col-12">
			<div class="card">
			 <h3>Escalation Data</h3>
        <GChart type="ColumnChart" :data="escalationData" :options="chartOptions"/>
			</div>
		</div>

		<div class="col-md-6 col-lg-6 col-12">
			<div class="card">
			 <h3>Outbond</h3>
        <GChart type="ColumnChart" :data="outbondData" :options="chartOptions"/>
			</div>
		</div>

		<div class="col-md-4 col-12">
			<div class="card">
			 <h3>Account Change</h3>
        <GChart type="ColumnChart" :data="accountchangeData" :options="chartOptions"/>
			</div>
		</div>

		<div class="col-md-4 col-12">
			<div class="card">
			 <h3>Need Agent</h3>
        <GChart type="ColumnChart" :data="needagentData" :options="chartOptions"/>
			</div>
		</div>
        <div class="col-md-4 col-12">
			<div class="card">
			 <h3>Payment Pending Issue</h3>
        <GChart type="ColumnChart" :data="paymentpendingData" :options="chartOptions"/>
			</div>
		</div>
	</div>
</div>

</div>




</template>

<script>
    import { GChart } from "vue-google-charts";
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker'
    import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css'
    export default {
        name: "App",
        components: {
            GChart,
            VueCtkDateTimePicker
        },
        data() {
            return {
              needagentData:[],
              paymentpendingData:[],
              accountchangeData:[],
              outbondData:[],
              escalationData:[],
              chartData:[],
              queryData:[],
              dateRnge: {
                    start: new Date(new Date() - (7 * 24 * 60 * 60 * 1000)),
                    end: new Date()
                },
              format: 'YYYY-MM-DD',
              formatted: 'YYYY-MM-DD',
              color: '#27337B',
              buttonColor: '#27337B',
               
                chartOptions: {
                    chart: {
                        width: 50,
                        height: 50,
                        legend: { position: 'top', maxLines: 3 },
                        bar: { groupWidth: '35%' },
        
                    },  
              isStacked: true            
                },
                //   queryData: [
                //     ['Date', 'QR Code Status', 'Wants To Know About the App Features', 'Need a Agent', 'Wallet Issue','Not Showing Business name in customers Mobile', 'Wants To change the Bank details', 'Cashback',{ role: 'annotation' } ],
                //    ['4 march', 10, 10, 20, 1, 0, 1,5,''],
                //    ['6 march', 16, 22, 23, 30, 16, 9, 10,''],
                //    ['7 march', 28, 19, 29, 30, 12, 13,19, ''],
                //     ['8 march', 28, 19, 29, 30, 12, 13,12, ''],
                //      ['9 march', 28, 19, 29, 30, 12, 13,15, ''],
                //       ['10 march', 28, 19, 29, 30, 12, 13,14, ''],
                //        ['11 march', 28, 19, 29, 30, 12, 13,16, '']
                       

                // ],

               

                //  outbondData: [
                //     ['Date', 'Contactable', 'non-contactable', { role: 'annotation' } ],
                //    ['4 march', 10, 24, ''],
                //    ['6 march', 16, 22, ''],
                //    ['7 march', 28, 19, ''],
                //     ['8 march', 28, 19, ''],
                //      ['9 march', 28, 19,''],
                //       ['10 march', 28, 19, ''],
                //        ['11 march', 28, 19,'']
                       

                // ],

             

            }; //

        },
        created(){
            this.getAgentCount();
        },
        methods:{
                  getAgentCount(){
                      var fromdate = moment(this.dateRnge.start).format('YYYY-MM-DD');
                      var enddate = moment(this.dateRnge.end).format('YYYY-MM-DD');
                  
                  axios.get('/api/chart/count-agent?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                       this.needagentData = response.data
                    })
                    axios.get('/api/chart/cout-payment?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                        this.paymentpendingData = response.data
                    })
                    axios.get('/api/chart/count-bank?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                        this.accountchangeData = response.data
                    })
                    axios.get('/api/chart/count-outbound?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                      
                        this.outbondData = response.data
                    })
                     axios.get('/api/chart/count-escalation?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                        this.escalationData = response.data
                    })
                     axios.get('/api/chart/count-complaint?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                      
                        this.chartData = response.data
                    })
                    axios.get('/api/chart/count-query?fromdate=' + fromdate + '&enddate=' + enddate)
                    .then(response => {
                        this.queryData = response.data
                    })
                    .catch(response => {
                        toastr['error'](response.message);
                    })
            }

            

            },

       
    };
</script>
