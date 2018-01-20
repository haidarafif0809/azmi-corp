<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li>Laporan</li>
              <li class="active">Laporan Laba Rugi</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Laba Rugi</div>

                <div class="panel-body">
                     <form v-on:submit.prevent="getResults" class="form-inline">
                      <div class="form-group">
                        <input type="date" class="form-control"  v-model="laporan.dariTanggal" placeholder="Dari Tanggal">
                      </div>
                      <div class="form-group">
                        <input type="date" class="form-control" v-model="laporan.sampaiTanggal" placeholder="Sampai Tanggal">
                      </div>
                      <button type="submit" class="btn btn-default">Tampil</button>
                    </form> 
                    <br/>
                    <div class="table-responsive">
                    
                    <table class="table table-bordered" >
                    <tbody>
                      <tr >
                        <td>Pendapatan</td>
                        <td>{{ labaRugi.penjualan}}</td>
                      </tr>
                      <tr>
                        <td>Biaya</td>
                        <td>{{ labaRugi.biaya}}</td>
                      </tr>
                      <tr>
                        <td>Harga Pokok Penjualan</td>
                        <td>{{ labaRugi.hpp}}</td>
                      </tr>
                      <tr>
                        <td>Laba / Rugi</td>
                        <td>{{ labaRugi.laba_rugi}}</td>
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
        labaRugi: [],
        laporan : { 
            dariTanggal: '',
            sampaiTanggal: this.currentDate(),
            },
        url: window.location.origin + (window.location.pathname).replace("home","akuntansi/laba-rugi"),
        loading: true
      }
    },
    mounted()  {
     var app = this;
     app.loading = false;
     app.getResults();
    },
    methods: {
      currentDate(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 

        today =  yyyy + '-' + mm + '-' + dd;
        return today;
      },
      getResults(page){
        
        var app = this;
        app.loading = true;
        var url = app.url + '?dariTanggal=' + app.laporan.dariTanggal + '&sampaiTanggal=' + app.laporan.sampaiTanggal;
        axios.get(url)
        .then(function(resp){
          app.labaRugi = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      alert(title,pesan){
        this.$swal({
          title: title,
          text: pesan,
          icon: "success"
        });
      }
    }
  }

</script>
