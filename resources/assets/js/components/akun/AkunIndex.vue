<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Kelola Akun</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Kelola Akun</div>

                <div class="panel-body">

                    <router-link 
                      :to="{name: 'CreateAkun'}" 
                      class="btn btn-md btn-primary"> 
                        Tambah Akun
                    </router-link>
                    <div class="table-responsive">
                    
                    <div align="right">
                   Pencarian 
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th>Jenis Akun</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="akuns.length">
                      <tr v-for="akun,index in akuns">
                        <td>{{ akun.kode}}</td>
                        <td>{{ akun.nama}}</td>
                        <td>{{ akun.jenis}}</td>
                        <td>
                        <router-link 
                          :to="{name:'EditAkun' ,params:{id: akun.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button 
                          class="btn btn-xs btn-danger" 
                          v-on:click="konfirmasiHapus(akun.id,index,akun.nama)"
                        >
                          Hapus
                        </button>
                        </td>
                      </tr>
                    </tbody>
                    </table>
                    <vue-pagination 
                      :data="akunsData" 
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
        akuns: [],
        akunsData: {},
        url: window.location.origin + (window.location.pathname).replace("home","akun"),
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
          app.akuns = resp.data.data;
          app.akunsData = resp.data;
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
          app.akuns = resp.data.data;
          app.akunsData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      deleteEntry(id,index,namaAkun){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus Akun " + namaAkun);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiHapus(id,index,namaAkun){
      
        this.$swal({
          title: "Yakin Ingin Menghapus Akun " + namaAkun + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,namaAkun);
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
