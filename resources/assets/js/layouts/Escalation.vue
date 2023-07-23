<template>
    <table class="table">
  <thead>
    <tr>
      
      <th scope="col">Name</th>
      <th scope="col">phone</th>
      <th scope="col">upi</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for ="alldat in alldata.data">
      <td>{{alldat.name}}</td>
      <td>{{alldat.phone}}</td>
      <td>{{alldat.utr_upi}}</td>
    </tr>
    <pagination :data="alldata" @pagination-change-page="getResults"></pagination>
  </tbody>
</table>

</template>


<script>

    export default {
        data(){
            return {
                alldata : [],
               
            }
        },
        created(){
            this.getData();
        },

        methods: {
          getResults(page = 1) {
			axios.get('api/auth/callbackdata?page=' + page)
        .then(response => this.alldata = response.data.alldata)
        .catch(error =>console.log(error));
		},
            getData(){
                axios.get('api/auth/callbackdata')
                .then((response) => this.alldata = response.data.alldata)
                .catch((error) => console.log(error));
                

            }
        }
    }
</script>
