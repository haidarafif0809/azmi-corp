<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Transaksi Kas</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Transaksi Kas</div>

                <div class="panel-body">

                    <ul class="nav nav-tabs">
                      <li role="presentation" class="active"><a href="#">Daftar Transaksi</a></li>
                      <li role="presentation">
                       <router-link 
                          :to="{name: 'IndexPosisiKas'}" 
                       > 
                          Posisi Kas
                        </router-link>
                       </li>
                      <li role="presentation">                 
                       <router-link 
                          :to="{name: 'CreateTransaksiKasMasuk'}" 
                       > 
                          Tambah Kas Masuk
                        </router-link>
                       </li>
                      <li role="presentation">
                       <router-link 
                          :to="{name: 'CreateTransaksiKasKeluar'}" 
                       > 
                          Tambah Kas Keluar
                        </router-link>
                       </li>

                    </ul>
                    <div class="table-responsive">
                    
                    <div align="right">
                   Pencarian 
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Tanggal</th>
                        <th>No Transaksi</th>
                        <th>Dari Akun</th>
                        <th>Ke Akun</th>
                        <th>Deksripsi</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="transaksiKas.length">
                      <tr v-for="transaksi,index in transaksiKas">
                        <td>{{ transaksi.created_at}}</td>
                        <td>{{ transaksi.no_trans}}</td>
                        <td>{{ transaksi.nama_akun_keluar}}</td>
                        <td>{{ transaksi.nama_akun_masuk}}</td>
                        <td>{{ transaksi.deskripsi}}</td>
                        <td>{{ transaksi.masuk}}</td>
                        <td>{{ transaksi.keluar}}</td>
                        <td >
                        <router-link 
                          v-if="transaksi.masuk > 0"
                          :to="{name:'EditTransaksiKasMasuk' ,params:{id: transaksi.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <router-link 
                          v-if="transaksi.keluar > 0"
                          :to="{name:'EditTransaksiKasKeluar' ,params:{id: transaksi.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button 
                          class="btn btn-xs btn-danger" 
                          v-on:click="konfirmasiHapus(transaksi.id,index,transaksi.id)"
                        >
                          Hapus
                        </button>
                        </td>
                      </tr>
                    </tbody>
                    </table>
                    <vue-pagination 
                      :data="transaksiKasData" 
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
        transaksiKas: [],
        transaksiKasData: {},
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-kas"),
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
          app.transaksiKas = resp.data.data;
          app.transaksiKasData = resp.data;
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
          app.transaksiKas = resp.data.data;
          app.transaksiKasData = resp.data;
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
