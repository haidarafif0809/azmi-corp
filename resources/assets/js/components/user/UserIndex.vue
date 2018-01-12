<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Kelola User</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Kelola User</div>

                <div class="panel-body">

                    <router-link 
                      :to="{name: 'CreateUser'}" 
                      class="btn btn-md btn-primary"> 
                        Tambah User
                    </router-link>
                    <div class="table-responsive">
                    
                    <div align="right">
                   Pencarian 
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Status Konfirmasi</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="users.length">
                      <tr v-for="user,index in users">
                        <td>{{ user.email}}</td>
                        <td>{{ user.name}}</td>
                        <td v-if="user.konfirmasi_admin == 1">
                          Terkonfirmasi
                        </td>
                        <td v-else>
                          Belum Terkonfirmasi
                        </td>
                        <td>
                        <button 
                          class="btn btn-xs btn-primary" 
                          v-if="user.konfirmasi_admin == 0"
                          v-on:click="konfirmasiAdmin(user.id,index,user.name)"
                        >
                          Konfirmasi
                        </button>
                        <router-link 
                          :to="{name:'EditUser' ,params:{id: user.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button 
                          class="btn btn-xs btn-danger" 
                          v-on:click="konfirmasiHapus(user.id,index,user.name)"
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
        users: [],
        usersData: {},
        url: window.location.origin + (window.location.pathname).replace("home","user"),
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
          app.users = resp.data.data;
          app.usersData = resp.data;
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
          app.users = resp.data.data;
          app.usersData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      deleteEntry(id,index,namaUser){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus User " + namaUser);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      prosesKonfirmasiAdmin(id,index,namaUser){
          
          axios.get(this.url + '/' + id + '/konfirmasi')
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Mengkonfirmasi","Berhasil Mengkonfirmasi User " + namaUser);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiAdmin(id,index,namaUser){
      
        this.$swal({
          title: " Mengkonfirmasi User " + namaUser.toUpperCase() + "?",
          text: "User yang sudah di konfirmasi tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willConfirm) => {
          if (willConfirm) {
            this.prosesKonfirmasiAdmin(id,index,namaUser);
          }
        })  
      },
      konfirmasiHapus(id,index,namaUser){
      
        this.$swal({
          title: "Yakin Ingin Menghapus User " + namaUser + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,namaUser);
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
