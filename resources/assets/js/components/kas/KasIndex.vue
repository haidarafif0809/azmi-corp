<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Kelola Kas</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Kelola Kas</div>

                <div class="panel-body">

                    <router-link 
                      :to="{name: 'CreateKas'}" 
                      class="btn btn-md btn-primary"> 
                        Tambah Kas
                    </router-link>
                    <div class="table-responsive">
                    
                    <div align="right">
                   Pencarian 
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Kode Kas</th>
                        <th>Nama Kas</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="gudangs.length">
                      <tr v-for="gudang,index in gudangs">
                        <td>{{ gudang.kode}}</td>
                        <td>{{ gudang.nama}}</td>
                        <td>
                        <router-link 
                          :to="{name:'EditKas' ,params:{id: gudang.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button 
                          class="btn btn-xs btn-danger" 
                          v-on:click="konfirmasiHapus(gudang.id,index,gudang.nama)"
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
        gudangs: [],
        gudangsData: {},
        url: window.location.origin + (window.location.pathname).replace("home","gudang"),
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
          app.gudangs = resp.data.data;
          app.gudangsData = resp.data;
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
          app.gudangs = resp.data.data;
          app.gudangsData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      deleteEntry(id,index,namaKas){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus Kas " + namaKas);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiHapus(id,index,namaKas){
      
        this.$swal({
          title: "Yakin Ingin Menghapus Kas " + namaKas + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,namaKas);
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
