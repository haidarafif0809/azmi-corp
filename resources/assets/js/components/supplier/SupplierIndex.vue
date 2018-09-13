<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'IndexDashboard'}">Home</router-link></li>
              <li class="active">Kelola Supplier</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Kelola Supplier</div>

                <div class="panel-body">

                    <router-link 
                      :to="{name: 'CreateSupplier'}" 
                      class="btn btn-md btn-primary"> 
                        Tambah Supplier
                    </router-link>
                    <div class="table-responsive">
                    
                    <div align="right">
                   Pencarian 
                    <input type="text" v-bind:style="{width: '20%' }" v-model="pencarian" class="form-control" />
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Kontak Supplier</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody v-if="suppliers.length">
                      <tr v-for="supplier,index in suppliers">
                        <td>{{ supplier.kode}}</td>
                        <td>{{ supplier.nama}}</td>
                        <td>{{ supplier.kontak}}</td>
                        <td>
                        <router-link 
                          :to="{name:'EditSupplier' ,params:{id: supplier.id}}" 
                          class="btn btn-xs btn-default"
                       >
                          Edit
                       </router-link>
                        <button 
                          class="btn btn-xs btn-danger" 
                          v-on:click="konfirmasiHapus(supplier.id,index,supplier.nama)"
                        >
                          Hapus
                        </button>
                        </td>
                      </tr>
                    </tbody>
                    </table>
                    <vue-pagination
                      :data="suppliersData"
                      v-on:pagination-change-page="getResults"
                      :limit="4"
                    >
                    </vue-pagination>
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
        suppliers: [],
        suppliersData: {},
        url: window.location.origin + (window.location.pathname).replace("home","supplier"),
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
          app.suppliers = resp.data.data;
          app.suppliersData = resp.data;
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
          app.suppliers = resp.data.data;
          app.suppliersData = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;
         
        })
      },
      deleteEntry(id,index,namaSupplier){
          axios.delete(this.url + '/' + id)
          .then((resp) => {
            this.getResults();
            this.alert("Berhasil Menghapus","Berhasil Menghapus Supplier " + namaSupplier);
          })
          .catch((resp) =>{
            alert("Something Goes Wrong")
            console.log(resp);
          })
      },
      konfirmasiHapus(id,index,namaSupplier){
      
        this.$swal({
          title: "Yakin Ingin Menghapus Supplier " + namaSupplier + "?",
          text: "Data yang di hapus tidak akan bisa di kembalikan lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.deleteEntry(id,index,namaSupplier);
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
