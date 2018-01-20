<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li>Laporan</li>
              <li class="active">Laporan Neraca</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Neraca</div>

                <div class="panel-body">
                     <form v-on:submit.prevent="getResults" class="form-inline">
                      <div class="form-group">
                        <input type="date" class="form-control" v-model="laporan.sampaiTanggal" placeholder="Sampai Tanggal">
                      </div>
                      <button type="submit" class="btn btn-default">Tampil</button>
                    </form> 
                    <br/>
                    <div class="table-responsive">
                    
                    <table class="table table-bordered" >
                    <thead>
                        <th>Aktiva</th>
                        <th>Saldo</th>
                        <th>Pasiva</th>
                        <th>Saldo</th>
                    </thead>
                    <tbody >
                        <tr>
                           <td>Kas</td>
                           <td>{{ neraca.kas}}</td>
                           <td>Hutang</td>
                           <td>{{ neraca.hutang}}</td>
                        </tr>
                        <tr>
                           <td>Piutang</td>
                           <td>{{ neraca.piutang}}</td>
                           <td>Modal</td>
                           <td>{{ neraca.modal}}</td>
                        </tr>
                        <tr>
                           <td>Persediaan</td>
                           <td>{{ neraca.persediaan}}</td>
                           <td>Laba Rugi Berjalan</td>
                           <td>{{ neraca.laba_rugi}}</td>
                        </tr>
                        <tr>
                           <td><b>Saldo Keseluruhan</b></td>
                           <td>{{ neraca.nilai_aktiva}}</td>
                           <td><b>Saldo Keseluruhan</b></td>
                           <td>{{ neraca.nilai_pasiva}}</td>
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
        neraca: [],
        laporan : { 
            sampaiTanggal: this.currentDate(),
            },
        url: window.location.origin + (window.location.pathname).replace("home","akuntansi/neraca"),
        loading: true
      }
    },
    mounted()  {
     var app = this;
     app.loading = false;
     app.getResults();
    },
    methods: {
      getResults(page){
        
        var app = this;
        app.loading = true;
        var url = app.url + '?sampaiTanggal=' + app.laporan.sampaiTanggal;
        axios.get(url)
        .then(function(resp){
          app.neraca= resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
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
