<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Posisi Kas</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Posisi Kas</div>

                <div class="panel-body">
                    <br/>
                    <div class="table-responsive">
                    
                    <table class="table table-bordered" >
                    <thead>
                        <th>Nama Kas</th>
                        <th>Posisi Kas</th>
                    </thead>
                    <tbody v-if="posisiKas.length">
                      <tr v-for="transaksi,index in posisiKas">
                        <td>{{ transaksi.nama}}</td>
                        <td>{{ transaksi.jumlah}}</td>
                      </tr>
                    </tbody>
                    </table>
                    <vue-simple-spinner v-if="loading" message="Loading..."></vue-simple-spinner>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>


<script>
  export default {
    data: function() {
      return {
        posisiKas: [],
        posisiKasData: {},
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-kas/posisi-kas"),
        loading: true
      }
    },
    mounted()  {
     var app = this;
    app.getResults();
    },
    methods: {
      getResults(){
        var app = this;
        axios.get(app.url )
        .then(function(resp){
          app.posisiKas = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      }
    }
  }

</script>
