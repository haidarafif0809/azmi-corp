<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Kelola Kartu Kredit</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Kelola Kartu Kredit</div>

                <div class="panel-body">

                    <router-link
                      :to="{name: 'CreateKartuKredit'}"
                      class="btn btn-md btn-primary">
                        Tambah Kartu Kredit
                    </router-link>
                    <div class="table-responsive">

                    <div align="right">
                   Pencarian
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Akun</th>
                        <th>Limit</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="kartuKredits.length">
                      <tr v-for="kartuKredit,index in kartuKredits">
                        <td>{{ kartuKredit.akun.nama}}</td>
                        <td>{{ kartuKredit.limit}}</td>
                        <td>
                        <router-link
                          :to="{name:'EditKartuKredit' ,params:{id: kartuKredit.id}}"
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button
                          class="btn btn-xs btn-danger"
                          v-on:click="konfirmasiHapus(kartuKredit.id,index,kartuKredit.nama)"
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
        kartuKredits: [],
        kartuKreditsData: {},
        url: window.location.origin + (window.location.pathname).replace("home","kartu-kredit"),
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
          app.kartuKredits = resp.data.data;
          app.kartuKreditsData = resp.data;
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
          app.kartuKredits = resp.data.data;
          app.kartuKreditsData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;

        })
      },
      deleteEntry(id,index,namaKartuKredit){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus KartuKredit " + namaKartuKredit);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiHapus(id,index,namaKartuKredit){

        this.$swal({
          title: "Yakin Ingin Menghapus KartuKredit " + namaKartuKredit + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,namaKartuKredit);
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
