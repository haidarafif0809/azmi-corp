
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexKartuKredit'}">Kelola Kartu Kredit</router-link></li>
              <li class="active">Edit  Kartu Kredit</li>
            </ul>
            <div class="panel panel-default">
              <div class="panel-heading">Edit  Kartu Kredit</div>
              <div class="panel-body">
                <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                  <div class="form-group">
                    <label for="name" class="col-md-2 control-label" >Akun Hutang</label>
                    <div class="col-md-4">
                    <vue-selectize
                      v-model="kartuKredit.akun"
                      class="form-control"
                      required="" >
                        <option value="">Pilih Akun Hutang </option>
                        <option v-for="akun in akuns" :value="akun.id">{{ akun.nama}}</option>
                      </vue-selectize>
                    <span v-if="errors.akun" class="label label-danger"> {{ errors.akun[0]}}</span>
                    </div>
                  </div>
                    <div class="form-group">
                      <label for="name" class="col-md-2 control-label" >Limit</label>
                      <div class="col-md-4">
                        <input type="number" class="form-control" required="" placeholder="Limit Kartu Kredit" v-model="kartuKredit.limit" />
                      <span v-if="errors.limit" class="label label-danger"> {{ errors.limit[0]}}</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name" class="col-md-2 control-label" >Tanggal Bayar</label>
                      <div class="col-md-4">
                        <input type="number" class="form-control" required="" placeholder="Tanggal Bayar Kartu Kredit" v-model="kartuKredit.tanggal_bayar" />
                      <span v-if="errors.tanggal_bayar" class="label label-danger"> {{ errors.tanggal_bayar[0]}}</span>
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
        kartuKredit: {
          akun: '',
          limit: 0,
          tanggal_bayar: '',
        },
        kartuKreditId : null,
        url: window.location.origin + (window.location.pathname).replace("home","kartu-kredit"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     app.getAkuns()
     this.kartuKreditId = this.$route.params.id;
     axios.get(app.url+'/'+this.kartuKreditId+ '/edit')
     .then((resp) => {
       this.kartuKredit =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Kartu Kredit",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newDriver = this.kartuKredit;
        axios.patch(this.url + '/' + this.kartuKreditId, newDriver)
        .then((resp) => {
          this.alert('Berhasil Mengubah Kartu Kredit ' + this.kartuKredit.nama );
          this.$router.replace('/kartu-kredit/');
        })
        .catch((resp) =>{
          if(resp.response.status == 500) alert('Something Goes Wrong');
          this.errors = resp.response.data.errors;
          console.log(resp);
        });
      },
      getAkuns(){
        var app = this;
        axios.get(app.url.replace("kartu-kredit","akun") + '/all?all=1')
        .then(function(resp){
          const akunHutang = resp.data.filter( res => res.jenis == 'hutang')
          app.akuns = akunHutang;
        })
        .catch(function(resp){
          console.log(resp);
        })
      }
    }
  }

</script>
