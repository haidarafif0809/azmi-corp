<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Kelola Pelanggan</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Kelola Pelanggan</div>

                <div class="panel-body">

                    <router-link
                      :to="{name: 'CreatePelanggan'}"
                      class="btn btn-md btn-primary">
                        Tambah Pelanggan
                    </router-link>
                    <div class="table-responsive">

                    <div align="right">
                   Pencarian
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Kontak Pelanggan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="pelanggans.length">
                      <tr v-for="pelanggan,index in pelanggans">
                        <td>{{ pelanggan.kode}}</td>
                        <td>{{ pelanggan.nama}}</td>
                        <td>{{ pelanggan.kontak}}</td>
                        <td>
                          <a target="_blank" v-bind:href="`https://www.google.co.id/maps/place/${pelanggan.koordinat}`" >Map</a>
                          <router-link
                            :to="{name:'EditPelanggan' ,params:{id: pelanggan.id}}"
                            class="btn btn-xs btn-default"
                         >
                            Edit
                         </router-link>
                          <button
                            class="btn btn-xs btn-danger"
                            v-on:click="konfirmasiHapus(pelanggan.id,index,pelanggan.nama)"
                          >
                            Hapus
                          </button>
                        </td>
                      </tr>
                    </tbody>
                    </table>
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
        pelanggans: [],
        pelanggansData: {},
        url: window.location.origin + (window.location.pathname).replace("home","pelanggan"),
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
          app.pelanggans = resp.data.data;
          app.pelanggansData = resp.data;
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
          app.pelanggans = resp.data.data;
          app.pelanggansData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;

        })
      },
      deleteEntry(id,index,namaPelanggan){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus Pelanggan " + namaPelanggan);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiHapus(id,index,namaPelanggan){

        this.$swal({
          title: "Yakin Ingin Menghapus Pelanggan " + namaPelanggan + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,namaPelanggan);
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
