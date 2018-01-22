<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexTransaksiGas'}">Transaksi Gas</router-link></li>
              <li class="active">Edit Transaksi Gas </li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit Transaksi Gas </div>

                <div class="panel-body">
                    <vue-simple-spinner v-if="loading" message="Loading..."></vue-simple-spinner>
                  <div class="row">
                   <div class="col-md-5">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal " >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Mobil</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.mobil" 
                          class="form-control" 
                          required="" >
                            <option value="">Pilih Mobil</option>
                            <option v-for="mobil in mobils" :value="mobil.plat">{{ mobil.plat}}</option>
                          </vue-selectize>
                        <span v-if="errors.mobil" class="label label-danger"> {{ errors.mobil[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Driver</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.driver" 
                          class="form-control" 
                          required="" >
                            <option value="">Pilih Driver</option>
                            <option v-for="driver in drivers" :value="driver.nama">{{ driver.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.driver" class="label label-danger"> {{ errors.driver[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Status</label>
                        <div class="col-md-10">
                        <div class="radio">
                          <label>
                             <input 
                               type="radio" 
                               v-model="transaksiGas.status_barang" 
                               value="masuk">
                             Masuk
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input 
                              type="radio" 
                              v-model="transaksiGas.status_barang" 
                              value="keluar">
                               Keluar
                           </label>
                        </div>
                        <span v-if="errors.status_barang" class="label label-danger">
                        {{ errors.status_barang[0]}}
                        </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Asal</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.asal_barang" 
                          class="form-control" 
                          required="" >
                            <option value="">Pilih Asal</option>
                            <option v-for="gudang in gudangs" :value="gudang.nama">{{ gudang.nama}}</option>
                            <option v-for="supplier in suppliers" :value="supplier.nama">{{ supplier.nama}}</option>
                            <option v-for="pelanggan in pelanggans" :value="pelanggan.nama">{{ pelanggan.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.asal_barang" class="label label-danger"> {{ errors.asal_barang[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Tujuan</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.tujuan_barang" 
                          class="form-control" 
                          required="" >
                            <option value="">Pilih Tujuan</option>
                            <option v-for="gudang in gudangs" :value="gudang.nama">{{ gudang.nama}}</option>
                            <option v-for="supplier in suppliers" :value="supplier.nama">{{ supplier.nama}}</option>
                            <option v-for="pelanggan in pelanggans" :value="pelanggan.nama">{{ pelanggan.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.tujuan_barang" class="label label-danger"> {{ errors.tujuan_barang[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Uang Jalan</label>
                        <div class="col-md-10">
                          <input type="text" class="form-control"  placeholder="Uang Jalan" v-model="transaksiGas.uang_jalan" autofocus=""/>
                        <span v-if="errors.uang_jalan" class="label label-danger"> {{ errors.uang_jalan[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                          <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                      </div>
                    </form>
                    </div>
                    <div class="col-md-7">
                    <table class="table table-bordered ">
                       <thead>
                         <th>Produk</th>
                         <th>Kosong (P)</th>
                         <th>Kosong (R))</th>
                         <th>Kosong (K)</th>
                         <th>Isi</th>
                       </thead>
                       <tbody>
                         <tr v-for="produk in transaksiGas.produks">
                           <td>
                             {{ produk.nama_produk}}
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.kosong_p" placeholder="P" type="text" width="3px" />
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.kosong_r" placeholder="R" type="text" width="3px"/>
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.kosong_k" placeholder="K" type="text" width="3px"/>
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.isi" placeholder="ISI" type="text" width="3px"/>
                           </td>
                         </tr>
                       </tbody>

                    </table>
                   </div>
                   <!-- col-md-7 -->
                  </div>
                  <!-- end row -->
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
        transaksiGas: {
          mobil: '',
          driver: '',
          status_barang: '',
          asal_barang: '',
          uang_jalan: '',
          tujuan_barang: '',
          produks: [],

        },
        mobils: [],
        drivers: [],
        gudangs: [],
        suppliers: [],
        pelanggans: [],
        transaksiGasId: null,
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-gas"),
        errors: [],
        message: '',
        loading: true
      }
    },
    mounted()  {
     var app = this;
     app.getEditingData();
     app.getMobils();
     app.getProduks();
     app.getDrivers();
     app.getGudangs();
     app.getSuppliers();
     app.getPelanggans();
    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Transaksi Gas ",
          text: pesan,
          icon: "success"
        });
      },
      getProduks(){ 
        var app = this;
        app.loading = true;
        axios.get(app.url + '/' + app.transaksiGasId + '/edit-gas')
        .then(function(resp){
          app.transaksiGas.produks = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      },
      getMobils(){ 
        var app = this;
        app.loading = true;
        axios.get(app.url.replace("transaksi-gas","mobil") + '/all')
        .then(function(resp){
          app.mobils = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      },
      getDrivers(){ 
        var app = this;
        app.loading = true;
        axios.get(app.url.replace("transaksi-gas","driver") + '/all')
        .then(function(resp){
          app.drivers= resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      },
      getPelanggans(){ 
        var app = this;
        app.loading = true;
        axios.get(app.url.replace("transaksi-gas","pelanggan") + '/all')
        .then(function(resp){
          app.pelanggans= resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      },
      getSuppliers(){ 
        var app = this;
        app.loading = true;
        axios.get(app.url.replace("transaksi-gas","supplier") + '/all')
        .then(function(resp){
          app.suppliers= resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      },
      getGudangs(){ 
        var app = this;
        app.loading = true;
        axios.get(app.url.replace("transaksi-gas","gudang") + '/all')
        .then(function(resp){
          app.gudangs = resp.data;
          app.loading = false;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      },
      getEditingData(){
         var app = this;
         this.transaksiGasId = this.$route.params.id;
         axios.get(app.url+'/'+this.transaksiGasId+ '/edit')
         .then((resp) => {
           this.transaksiGas =  resp.data;
           app.loading = false;
         })
         .catch((resp) => {
            alert("Something Goes Wrong");    
         });
      },
      saveForm(){
        var newGasMasuk = this.transaksiGas;
        axios.patch(this.url + '/' + this.transaksiGasId + '/gas-masuk', newGasMasuk)
        .then((resp) => {
          this.alert('Berhasil Mengubah Transaksi Gas');
          this.$router.replace('/transaksi-gas/');
        })
        .catch((resp) =>{
          console.log(resp);
        });
      }
    }
  }

</script>
