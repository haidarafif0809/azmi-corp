<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexJurnalManual'}">Jurnal Manual</router-link></li>
              <li class="active">Tambah Jurnal Manual</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Jurnal Manual</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Akun Debit</label>
                        <div class="col-md-4">
                        <vue-selectize
                          v-model="jurnalManual.akun_debit" 
                          class="form-control" 
                          required="" >
                            <option value="">Pilih Akun Debit</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun_debit" class="label label-danger"> {{ errors.akun_debit[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Akun Kredit</label>
                        <div class="col-md-4">
                        <vue-selectize v-model="jurnalManual.akun_kredit" class="form-control" required="" >
                            <option value="">Pilih Akun Kredit</option>
                            <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                          </vue-selectize>
                        <span v-if="errors.akun_kredit" class="label label-danger"> {{ errors.akun_kredit[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Keterangan</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Keterangan" v-model="jurnalManual.deskripsi" />
                        <span v-if="errors.deskripsi" class="label label-danger"> {{ errors.deskripsi[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Jumlah</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Jumlah Masuk" v-model="jurnalManual.jumlah" autofocus=""/>
                        <span v-if="errors.jumlah" class="label label-danger"> {{ errors.jumlah[0]}}</span>
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
        jurnalManual: {
          akun_debit: '',
          akun_kredit: '',
          jumlah: '',
          deskripsi: ''
        },
        akuns: [],
        url: window.location.origin + (window.location.pathname).replace("home","jurnal-manual"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     app.getAkuns();
    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Menambah Jurnal Manual",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newJurnalManual = this.jurnalManual;
        axios.post(this.url,newJurnalManual)
        .then((resp) => {
          this.alert('Berhasil Menambah Jurnal Manual Sejumlah ' + this.jurnalManual.jumlah );
          this.$router.replace('/jurnal-manual/');
        })
        .catch((resp) =>{
          if(resp.response.status == 500) alert('Something Goes Wrong');
          this.errors = resp.response.data.errors;
          console.log(resp);
        });
      },
      getAkuns(){ 
        var app = this;
        axios.get(app.url.replace("jurnal-manual","akun") + '/all?all=1')
        .then(function(resp){
          app.akuns = resp.data;
        })
        .catch(function(resp){
          console.log(resp); 
        })
      }
    }
  }

</script>
