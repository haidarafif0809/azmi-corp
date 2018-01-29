<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li>Laporan</li>
              <li class="active">Laporan Buku Besar</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Buku Besar</div>

                <div class="panel-body">
                     <form v-on:submit.prevent="getResults" class="form-inline">
                      <div class="form-group">
                        <input type="date" class="form-control"  v-model="laporan.dariTanggal" placeholder="Dari Tanggal">
                      </div>
                      <div class="form-group">
                        <input type="date" class="form-control" v-model="laporan.sampaiTanggal" placeholder="Sampai Tanggal">
                      </div>
                      <div class="form-group">
                        <select
                          v-model="laporan.akun"
                          class="form-control" 
                          required="" >
                            <option value="">Pilih Akun</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </select>
                      
                      </div>
                      <button type="submit" class="btn btn-default">Tampil</button>
                    </form> 
                    <br/>
                    <div class="table-responsive">
                    
                    <table class="table table-bordered" >
                    <thead>
                        <th>Tanggal</th>
                        <th>No Transaksi</th>
                        <th>Deksripsi</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                    </thead>
                    <tbody v-if="jurnals.length">
                      <tr v-for="transaksi,index in jurnals">
                        <td>{{ transaksi.created_at}}</td>
                        <td>{{ transaksi.no_trans}}</td>
                        <td>{{ transaksi.deskripsi}}</td>
                        <td>{{ transaksi.debit}}</td>
                        <td>{{ transaksi.kredit}}</td>
                      </tr>
                    </tbody>
                    <p v-if="jurnals.length">Total Saldo : {{total_nilai}} </p>
                    <tbody v-else>
                      <tr><td colspan="5"><center>Tidak Ada Data</center></td></tr>
                    </tbody>
                    </table>
                    <vue-pagination 
                      :data="jurnalsData" 
                      v-on:pagination-change-page="getResults"
                      :limit="4"
                    >
                    </vue-pagination>
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
        jurnals: [],
        jurnalsData: {},
        total_nilai: 0,
        laporan : { 
            akun: '',
            dariTanggal: '',
            sampaiTanggal: '',
            },
        akuns: [],
        url: window.location.origin + (window.location.pathname).replace("home","akuntansi/buku-besar"),
        loading: true
      }
    },
    mounted()  {
     var app = this;
    app.getAkuns();
    },
    methods: {
      getAkuns(page){
       var app = this;
        axios.get(app.url.replace('akuntansi/buku-besar','akun') + '/all?all=1')
        .then(function(resp){
          app.akuns= resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      getResults(page){
        
        var app = this;
        app.loading = true;
        if(typeof page == 'undefined'){
          page = 1;
        }
        var url = app.url + '?page=' + page + '&akun=' + app.laporan.akun 
                + '&dariTanggal=' + app.laporan.dariTanggal + '&sampaiTanggal=' + app.laporan.sampaiTanggal;
        axios.get(url)
        .then(function(resp){
          app.jurnals = resp.data.data;
          app.jurnalsData = resp.data;
          app.total_nilai = resp.data.total_nilai
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
