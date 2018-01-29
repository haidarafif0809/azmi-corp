<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Jurnal Manual</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Jurnal Manual</div>

                <div class="panel-body">

                       <router-link 
                          class="btn btn-primary"
                          :to="{name: 'CreateJurnalManual'}" 
                       > 
                          Tambah Jurnal Manual
                        </router-link>
                    <br/>
                    <div class="table-responsive">
                    
                    <div align="right">
                    <input type="text" placeholder="Pencarian ..." v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <br/>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Tanggal</th>
                        <th>No Transaksi</th>
                        <th>Akun Debit</th>
                        <th>Akun Kredit</th>
                        <th>Deksripsi</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="jurnalManuals.length">
                      <tr v-for="jurnalManual,index in jurnalManuals">
                        <td>{{ jurnalManual.created_at}}</td>
                        <td>{{ jurnalManual.no_trans}}</td>
                        <td>{{ jurnalManual.nama_akun_debitt}}</td>
                        <td>{{ jurnalManual.nama_akun_kredit}}</td>
                        <td>{{ jurnalManual.deskripsi}}</td>
                        <td>{{ jurnalManual.jumlah}}</td>
                        <td >
                        <router-link 
                          :to="{name:'EditJurnalManual' ,params:{id: jurnalManual.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button 
                          class="btn btn-xs btn-danger" 
                          v-on:click="konfirmasiHapus(jurnalManual.id,index,jurnalManual.no_trans)"
                        >
                          Hapus
                        </button>
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr><td colspan="7"><center>Tidak Ada Data</center></td></tr>
                    </tbody>
                    </table>
                    <vue-pagination 
                      :data="jurnalManualsData" 
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
        jurnalManuals: [],
        jurnalManualsData: {},
        url: window.location.origin + (window.location.pathname).replace("home","jurnal-manual"),
        pencarian: '',
        loading: true
      }
    },
    mounted()  {
     var app = this;
    app.getResults();
    },
    watch: {
       pencarian: function(newSearch){
         this.loading = true;
         this.getHasilPencarian();
       }  
    },
    methods: {
      getResults(page){
        var app = this;
        if(typeof page == 'undefined'){
          page = 1;
        }
        axios.get(app.url + '/view?page=' + page)
        .then(function(resp){
          app.jurnalManuals = resp.data.data;
          app.jurnalManualsData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      getHasilPencarian(page){
          
        var app = this;
        if(typeof page == 'undefined'){
          page = 1;
        }
        axios.get(app.url + '/search?q='+app.pencarian+'&page=' + page)
        .then(function(resp){
          app.jurnalManuals = resp.data.data;
          app.jurnalManualsData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      deleteEntry(id,index,noTransaksi){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus Transaksi :  " + noTransaksi);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiHapus(id,index,noTransaksi){
      
        this.$swal({
          title: " Ingin Menghapus Transaksi :  " + noTransaksi + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,noTransaksi);
          }
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
