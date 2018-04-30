<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Transaksi KartuKredit</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Transaksi KartuKredit</div>

                <div class="panel-body">
                    <ButtonTambah />
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
                        <th>Kartu Kredit</th>
                        <th>Akun</th>
                        <th>Deskripsi</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="transaksiKartuKredit.length">
                      <tr v-for="transaksi,index in transaksiKartuKredit">
                        <td>{{ transaksi.created_at}}</td>
                        <td>{{ transaksi.no_trans}}</td>
                        <td>{{ transaksi.kartu_kredit.nama}}</td>
                        <td>{{ transaksi.akun.nama}}</td>
                        <td>{{ transaksi.deskripsi }} </td>
                        <td>{{ transaksi.masuk}}</td>
                        <td>{{ transaksi.keluar}}</td>
                        <td >
                        <router-link
                          v-if="transaksi.masuk > 0"
                          :to="{name:'EditTransaksiKartuKreditMasuk' ,params:{id: transaksi.id}}"
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <router-link
                          v-if="transaksi.keluar > 0"
                          :to="{name:'EditTransaksiKartuKreditKeluar' ,params:{id: transaksi.id}}"
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
                      :data="transaksiKartuKreditData"
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
import ButtonTambah from './ButtonCreate'

  export default {
    data: function() {
      return {
        transaksiKartuKredit: [],
        transaksiKartuKreditData: {},
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-kartu-kredit"),
        pencarian: '',
        loading: true
      }
    },
    components: {
      ButtonTambah
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
          app.transaksiKartuKredit = resp.data.data;
          app.transaksiKartuKreditData = resp.data;
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
          app.transaksiKartuKredit = resp.data.data;
          app.transaksiKartuKreditData = resp.data;
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
