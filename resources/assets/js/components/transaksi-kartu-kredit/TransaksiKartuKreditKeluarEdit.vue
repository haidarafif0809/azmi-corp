<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexTransaksiKartuKredit'}">Transaksi Kartu Kredit</router-link></li>
              <li class="active">Edit Gunakan Kartu Kredit</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit Gunakan Kartu Kredit</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" > Kartu Kredit</label>
                        <div class="col-md-4">
                        <vue-selectize
                          v-model="transaksiKartuKredit.kartu_kredit"
                          class="form-control"
                          required="" >
                            <option value="">Pilih Kartu Kredit</option>
                            <option v-for="data in kartuKredits" :value="data.akun.id">{{ data.akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.kartu_kredit" class="label label-danger"> {{ errors.kartu_kredit[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Ke Akun</label>
                        <div class="col-md-4">
                        <vue-selectize v-model="transaksiKartuKredit.akun" class="form-control" required="" >
                            <option value="">Pilih Akun</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun" class="label label-danger"> {{ errors.akun[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Keterangan</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Keterangan" v-model="transaksiKartuKredit.deskripsi" />
                        <span v-if="errors.deskripsi" class="label label-danger"> {{ errors.deskripsi[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Jumlah</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Jumlah Keluar" v-model="transaksiKartuKredit.keluar" autofocus=""/>
                        <span v-if="errors.keluar" class="label label-danger"> {{ errors.keluar[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                          <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                      </div>
                    </form>
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
        transaksiKartuKredit: {
          akun: '',
          kartu_kredit: '',
          keluar: '',
          deskripsi: ''
        },
        akuns: [],
        kartuKredits: [],
        kartuKreditKeluarId : null,
        url: window.location.origin + (window.location.pathname).replace("home","transaksi-kartu-kredit"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     app.getEditingData();
     app.getAkuns();
    },
    methods: {
      getAkuns(){
        var app = this;
        axios.get(app.url.replace("transaksi-kartu-kredit","kartu-kredit"))
        .then(function(resp){
          app.kartuKredits = resp.data.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
        axios.get(app.url.replace("transaksi-kartu-kredit","akun") + '/all')
        .then(function(resp){
          app.akuns = resp.data;
        })
        .catch(function(resp){
          console.log(resp);
        })
      },
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Kartu Kredit Keluar",
          text: pesan,
          icon: "success"
        });
      },
      getEditingData(){
         var app = this;
         this.kartuKreditKeluarId = this.$route.params.id;
         axios.get(app.url+'/'+this.kartuKreditKeluarId+ '/edit')
         .then((resp) => {
           this.transaksiKartuKredit =  resp.data;
         })
         .catch((resp) => {
            alert("Something Goes Wrong");
         });
      },
      saveForm(){
        var newKartuKreditMasuk = this.transaksiKartuKredit;
        axios.patch(this.url + '/' + this.kartuKreditKeluarId + '/kartu-kredit-keluar', newKartuKreditMasuk)
        .then((resp) => {
          this.alert('Berhasil Mengubah KartuKredit Keluar Sejumlah ' + this.transaksiKartuKredit.keluar );
          this.$router.replace('/transaksi-kartu-kredit/');
        })
        .catch((resp) =>{
          if(resp.response.status == 500) alert('Something Goes Wrong');
          this.errors = resp.response.data.errors;
          console.log(resp);
        });
      }
    }
  }

</script>
