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
                    <div class="col-sm-6">
                    <table class="table table-bordered" >
                    <thead>
                        <th>Aktiva</th>
                        <th>Saldo</th>
                    </thead>
                    <tbody >
                        <tr>
                           <td><b>Kas / Bank</b></td>
                           <td><b>{{ neraca.kas}}</b></td>
                        </tr>
                        <tr v-for="kas in neraca.akun_kas">
                           <td>{{kas.akun}}</td>
                           <td>{{kas.saldo}}</td>
                        </tr>
                        <tr>
                           <td><b>Piutang</b></td>
                           <td><b>{{ neraca.piutang}}</b></td>
                        </tr>
                        <tr v-for="piutang in neraca.akun_piutang">
                           <td>{{piutang.akun}}</td>
                           <td>{{piutang.saldo}}</td>
                        </tr>
                        <tr>
                           <td><b>Persediaan</b></td>
                           <td><b>{{ neraca.persediaan}}</b></td>
                        </tr>
                        <tr v-for="persediaan in neraca.akun_wkwk">
                           <td>{{persediaan.akun}}</td>
                           <td>{{persediaan.saldo}}</td>
                        </tr>
                        <tr>
                           <td><b>Aktiva Tetap (Aset)</b></td> 
                           <td><b>{{ neraca.aktiva_tetap}}</b></td>
                        </tr>
                        <tr v-for="aktiva_tetap in neraca.akun_aktiva_tetap">
                           <td>{{aktiva_tetap.akun}}</td>
                           <td>{{aktiva_tetap.saldo}}</td>
                        </tr>
                        <tr>
                           <td><b>Saldo Keseluruhan</b></td>
                           <td>{{ neraca.nilai_aktiva}}</td>
                        </tr>
                    </tbody>
                    </table>
                    
                    </div> <!-- end col sm 6 -->
                    <div class="col-md-6">
                    <table class="table table-bordered" >
                    <thead>
                        <th>Pasiva</th>
                        <th>Saldo</th>
                    </thead>
                    <tbody >
                        <tr>
                           <td><b>Hutang</b></td>
                           <td>{{ neraca.hutang}}</td>
                        </tr>
                        <tr v-for="hutang in neraca.akun_hutang">
                           <td>{{hutang.akun}}</td>
                           <td>{{hutang.saldo}}</td>
                        </tr>
                        <tr>
                           <td><b>Modal</b></td>
                           <td>{{ neraca.modal}}</td>
                        </tr>
                        <tr v-for="modal in neraca.akun_modal">
                           <td>{{modal.akun}}</td>
                           <td>{{modal.saldo}}</td>
                        </tr>
                        <tr>
                           <td><b>Laba Rugi Berjalan</b></td>
                           <td>{{ neraca.laba_rugi}}</td>
                        </tr>
                        <tr>
                           <td><b>Saldo Keseluruhan</b></td>
                           <td>{{ neraca.nilai_pasiva}}</td>
                        </tr>
                    </tbody>
                    </table>
                    
                    </div>
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
