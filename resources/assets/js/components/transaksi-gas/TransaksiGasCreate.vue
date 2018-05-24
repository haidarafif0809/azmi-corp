<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexTransaksiGas'}">Transaksi Gas</router-link></li>
              <li class="active">Tambah Gas Masuk</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Gas Masuk</div>
                <div class="panel-body">
                  <div class="row">
                   <div class="col-md-5">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal " >
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
                        <label for="name" class="col-md-2 control-label" >Jenis Order</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.jenis_order"
                          class="form-control"
                          required="" >
                            <option value="">Pilih Jenis Order</option>
                            <option value="retail">Retail</option>
                            <option value="online">Online</option>
                            <option value="partai">Partai</option>
                          </vue-selectize>
                        <span v-if="errors.mobil" class="label label-danger"> {{ errors.mobil[0]}}</span>
                        </div>
                      </div>
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
                      <div class="form-group" v-if="transaksiGas.status_barang == 'keluar'">
                        <label for="name" class="col-md-2 control-label" >Uang Jalan</label>
                        <div class="col-md-10">
                          <input type="text" class="form-control"  placeholder="Uang Jalan" v-model="transaksiGas.uang_jalan" />
                        <span v-if="errors.uang_jalan" class="label label-danger"> {{ errors.uang_jalan[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group" v-if="transaksiGas.status_barang == 'masuk'">
                        <label for="name" class="col-md-2 control-label" >Setoran</label>
                        <div class="col-md-10">
                          <input type="text" class="form-control"  placeholder="Setoran" v-model="transaksiGas.uang_jalan" />
                        <span v-if="errors.uang_jalan" class="label label-danger"> {{ errors.uang_jalan[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group" v-if="transaksiGas.status_barang !== ''">
                        <label for="name" class="col-md-2 control-label" >Akun Masuk</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.akun_masuk"
                          class="form-control"
                          required="" >
                            <option value="">Pilih Akun</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun_masuk" class="label label-danger"> {{ errors.akun_masuk[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group" v-if="transaksiGas.status_barang !== ''">
                        <label for="name" class="col-md-2 control-label" >Akun Keluar</label>
                        <div class="col-md-10">
                        <vue-selectize
                          v-model="transaksiGas.akun_keluar"
                          class="form-control"
                          required="" >
                            <option value="">Pilih Akun</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun_keluar" class="label label-danger"> {{ errors.akun_keluar[0]}}</span>
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
                         <th>Total</th>
                       </thead>
                       <tbody>
                         <tr v-for="produk in transaksiGas.produks" :style="{ backgroundColor: produk.warna}">
                           <td>
                             <b :style="{color: 'black'}">{{ produk.nama}}</b>
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.kosong_p" placeholder="P" type="text" width="3px" />
                             <input class="form-control" v-model="produk.harga_kosong_p" placeholder="$" type="text" width="3px" />
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.kosong_r" placeholder="R" type="text" width="3px"/>
                             <input class="form-control" v-model="produk.harga_kosong_r" placeholder="$" type="text" width="3px" />
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.kosong_k" placeholder="K" type="text" width="3px"/>
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.isi" placeholder="ISI" type="text" width="3px"/>
                             <input class="form-control" v-model="produk.harga_isi" placeholder="$" type="text" width="3px" />
                           </td>
                           <td>
                             <input class="form-control" v-model="produk.total" placeholder="Total" type="text" width="3px"/>
                           </td>
                         </tr>
                       </tbody>
                    </table>
                    <p v-if="transaksiGas.status_barang !== ''">Biaya Lain </p>
                     <form class="form-inline" v-if="transaksiGas.status_barang !== ''">
                      <div class="form-group" >
                        <vue-selectize
                          v-model="transaksiGas.akun_masuk_lain"
                          class="form-control"
                          required="" >
                            <option value="">Pilih Akun Debit</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun_masuk_lain" class="label label-danger"> {{ errors.akun_masuk_lain[0]}}</span>
                      </div>
                      <div class="form-group" >
                        <vue-selectize
                          v-model="transaksiGas.akun_keluar_lain"
                          class="form-control"
                          required="" >
                            <option value="">Pilih Akun Kredit</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun_keluar_lain" class="label label-danger"> {{ errors.akun_keluar_lain[0]}}</span>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Jumlah Biaya Lain" v-model="transaksiGas.jumlah_lain">
                      </div>
                    </form>
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
          jenis_order: '',
          asal_barang: '',
          uang_jalan: '',
          tujuan_barang: '',
          produks: [],
          akun_masuk: '',
          akun_keluar: '',
          akun_masuk_lain: '',
          akun_keluar_lain: '',
          jumlah_lain: '',
        },
        mobils: [],
        drivers: [],
        gudangs: [],
        akuns: [],
        suppliers: [],
        pelanggans: [],
        setoran: 0,
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-gas"),
        errors: [],
        message: ''
      }
    },
    watch: {
      'transaksiGas.produks': {
        handler(newValue)  {
          var app = this
          let setoran = 0
          newValue.map(val => {
            val.kosong_k = Number(val.kosong_p) + Number(val.kosong_r)
            val.total = val.kosong_k + Number(val.isi)
            setoran += Number(val.harga_isi) + Number(val.harga_kosong_p) + Number(val.harga_kosong_r)
            return val
          })
          this.setoran = setoran
          if (this.transaksiGas.status_barang == 'masuk') {
            this.transaksiGas.uang_jalan = this.setoran
          }

          this.transaksiGas.produks = newValue
        },
        deep: true
      },
      'transaksiGas.status_barang': {
        handler(newValue) {
          if (newValue == 'masuk') {
            this.transaksiGas.uang_jalan = this.setoran
          } else {
            this.transaksiGas.uang_jalan = 0
          }
        }
      }
    },
    mounted()  {
     var app = this;
     app.getMobils();
     app.getAkuns();
     app.getProduks();
     app.getDrivers();
     app.getGudangs();
     app.getSuppliers();
     app.getPelanggans();
    },
    methods: {
      getAkuns(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","akun") + '/all?all=1')
        .then(function(resp){
          app.akuns = resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      alert(pesan){
        this.$swal({
          title: "Berhasil Menambah Transaksi Gas",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newTransaksiGas = this.transaksiGas;
        axios.post(this.url + '/gas-masuk',newTransaksiGas)
        .then((resp) => {
          this.alert('Berhasil Menambah Gas Masuk Sejumlah ' + this.transaksiGas.jumlah );
          this.$router.replace('/transaksi-gas/');
        })
        .catch((resp) =>{
          if(resp.response.status == 500) alert('Something Goes Wrong');
          this.errors = resp.response.data.errors;
          console.log(resp);
        });
      },
      getProduks(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","produk") + '/all')
        .then(function(resp){
          app.transaksiGas.produks = resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      getMobils(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","mobil") + '/all')
        .then(function(resp){
          app.mobils = resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      getDrivers(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","driver") + '/all')
        .then(function(resp){
          app.drivers= resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      getPelanggans(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","pelanggan") + '/all')
        .then(function(resp){
          app.pelanggans= resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      getSuppliers(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","supplier") + '/all')
        .then(function(resp){
          app.suppliers= resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      getGudangs(){
        var app = this;
        axios.get(app.url.replace("transaksi-gas","gudang") + '/all')
        .then(function(resp){
          app.gudangs = resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      }
    }
  }

</script>
