<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li>Laporan</li>
              <li class="active">Laporan Jurnal Umum</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Jurnal Umum</div>

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
                    <thead>
                        <th>Tanggal</th>
                        <th>No Jurnal</th>
                        <th>No Trans</th>
                        <th>Akun</th>
                        <th>Deksripsi</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                    </thead>
                    <tbody v-if="jurnalUmums.length">
                      <tr v-for="transaksi,index in jurnalUmums">
                        <td>{{ transaksi.created_at}}</td>
                        <td>{{ transaksi.no_jurnal}}</td>
                        <td>{{ transaksi.no_trans}}</td>
                        <td>{{ transaksi.nama_akun}}</td>
                        <td>{{ transaksi.deskripsi}}</td>
                        <td>{{ transaksi.debit}}</td>
                        <td>{{ transaksi.kredit}}</td>
                      </tr>
                    </tbody>
                    </table>
                    <vue-pagination 
                      :data="jurnalUmumsData" 
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
        jurnalUmums: [],
        jurnalUmumsData: {},
        laporan : { 
            dariTanggal: '',
            sampaiTanggal: '',
            },
        url: window.location.origin + (window.location.pathname).replace("home","akuntansi/jurnal-umum"),
        loading: true
      }
    },
    mounted()  {
     var app = this;
     app.loading = false;
    },
    methods: {
      getResults(page){
        
        var app = this;
        app.loading = true;
        if(typeof page == 'undefined'){
          page = 1;
        }
        var url = app.url + '?page=' + page + '&dariTanggal=' + app.laporan.dariTanggal + '&sampaiTanggal=' + app.laporan.sampaiTanggal;
        axios.get(url)
        .then(function(resp){
          app.jurnalUmums = resp.data.data;
          app.jurnalUmumsData = resp.data;
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
