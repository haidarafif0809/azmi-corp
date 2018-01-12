
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexPelanggan'}">Kelola Pelanggan</router-link></li>
              <li class="active">Tambah Pelanggan</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Pelanggan</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Pelanggan" v-model="pelanggan.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Pelanggan" v-model="pelanggan.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kontak</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kontak Pelanggan" v-model="pelanggan.kontak" autofocus=""/>
                        <span v-if="errors.kontak" class="label label-danger"> {{ errors.kontak[0]}}</span>
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
        pelanggan: {
          kode: '',
          nama: '',
          kontak: ''
        },
        url: window.location.origin + (window.location.pathname).replace("home","pelanggan"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Menambah Pelanggan",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newPelanggan = this.pelanggan;
        axios.post(this.url,newPelanggan)
        .then((resp) => {
          this.alert('Berhasil Menambah Pelanggan ' + this.pelanggan.nama );
          this.$router.replace('/pelanggan/');
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
