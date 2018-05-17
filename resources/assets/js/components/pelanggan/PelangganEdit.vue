
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexPelanggan'}">Kelola Pelanggan</router-link></li>
              <li class="active">Edit  Pelanggan</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  Pelanggan</div>

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
                        <label for="name" class="col-md-2 control-label" >Alamat</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Alamat Pelanggan" v-model="pelanggan.alamat" autofocus=""/>
                        <span v-if="errors.alamat" class="label label-danger"> {{ errors.alamat[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Email</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Email Pelanggan" v-model="pelanggan.email" autofocus=""/>
                        <span v-if="errors.email" class="label label-danger"> {{ errors.email[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Alamat Kantor</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Alamat Kantor Pelanggan" v-model="pelanggan.alamat_kantor" autofocus=""/>
                        <span v-if="errors.alamat_kantor" class="label label-danger"> {{ errors.alamat_kantor[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Perusahaan</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control"  placeholder="Perusahaan Pelanggan" v-model="pelanggan.perusahaan" autofocus=""/>
                        <span v-if="errors.perusahaan" class="label label-danger"> {{ errors.perusahaan[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kontak</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control"  placeholder="Kontak Pelanggan" v-model="pelanggan.kontak" autofocus=""/>
                        <span v-if="errors.kontak" class="label label-danger"> {{ errors.kontak[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Koordinat</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control"  placeholder="Koordinat Pelanggan" v-model="pelanggan.koordinat" autofocus=""/>
                        <span v-if="errors.koordinat" class="label label-danger"> {{ errors.koordinat[0]}}</span>
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
          kontak: '',
          alamat: '',
          email: '',
          alamat_kantor: '',
          perusahaan: '',
          koordinat: ''
        },
        pelangganId : null,
        url: window.location.origin + (window.location.pathname).replace("home","pelanggan"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.pelangganId = this.$route.params.id;
     axios.get(app.url+'/'+this.pelangganId+ '/edit')
     .then((resp) => {
       this.pelanggan =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Pelanggan",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newPelanggan = this.pelanggan;
        axios.patch(this.url + '/' + this.pelangganId, newPelanggan)
        .then((resp) => {
          this.alert('Berhasil Mengubah Pelanggan ' + this.pelanggan.nama );
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
