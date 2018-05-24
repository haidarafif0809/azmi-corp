
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexPerusahaan'}">Kelola Perusahaan</router-link></li>
              <li class="active">Edit  Perusahaan</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  Perusahaan</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Perusahaan" v-model="perusahaan.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >No Telp</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="No Telp Perusahaan" v-model="perusahaan.no_telp" autofocus=""/>
                        <span v-if="errors.no_telp" class="label label-danger"> {{ errors.no_telp[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Alamat</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Alamat Perusahaan" v-model="perusahaan.alamat" autofocus=""/>
                        <span v-if="errors.alamat" class="label label-danger"> {{ errors.alamat[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Website</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Website Perusahaan" v-model="perusahaan.website" autofocus=""/>
                        <span v-if="errors.website" class="label label-danger"> {{ errors.website[0]}}</span>
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
        perusahaan: {
          no_telp: '',
          nama: '',
          alamat: '',
          website: ''
        },
        perusahaanId : null,
        url: window.location.origin + (window.location.pathname).replace("home","perusahaan"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.perusahaanId = this.$route.params.id;
     axios.get(app.url+'/'+this.perusahaanId+ '/edit')
     .then((resp) => {
       this.perusahaan =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Perusahaan",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newPerusahaan = this.perusahaan;
        axios.patch(this.url + '/' + this.perusahaanId, newPerusahaan)
        .then((resp) => {
          this.alert('Berhasil Mengubah Perusahaan ' + this.perusahaan.nama );
          this.$router.replace('/perusahaan/');
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
