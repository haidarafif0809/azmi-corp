<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Transaksi Gas</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Transaksi Gas</div>

                <div class="panel-body">
                    <router-link
                      :to="{name: 'CreateTransaksiGas'}"
                      class="btn btn-md btn-primary">
                        Tambah Transaksi Gas
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
                        <th>Jenis</th>
                        <th>No Rute</th>
                        <th>Plat No</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Uang Jalan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="transaksiGas.length">
                      <tr v-for="transaksi,index in transaksiGas">
                        <td>{{ transaksi.created_at}}</td>
                        <td>{{ transaksi.jenis_order}}</td>
                        <td>{{ transaksi.no_rute}}</td>
                        <td>{{ transaksi.mobil}}</td>
                        <td>{{ transaksi.driver}}</td>
                        <td>{{ transaksi.status_barang}}</td>
                        <td>{{ transaksi.asal_barang}}</td>
                        <td>{{ transaksi.tujuan_barang}}</td>
                        <td>{{ transaksi.uang_jalan}}</td>
                        <td >
                        <router-link
                          :to="{name:'EditTransaksiGas' ,params:{id: transaksi.id}}"
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
                    <tbody v-else>
                    <tr >
                      <td colspan="9"><center>Tidak Ada Data</center></td>
                    </tr>
                    </tbody>
                    </table>
                    <vue-pagination
                      :data="transaksiGasData"
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
        transaksiGas: [],
        transaksiGasData: {},
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-gas"),
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
          app.transaksiGas = resp.data.data;
          app.transaksiGasData = resp.data;
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
          app.transaksiGas = resp.data.data;
          app.transaksiGasData = resp.data;
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
