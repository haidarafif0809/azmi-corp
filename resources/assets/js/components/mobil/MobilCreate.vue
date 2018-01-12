
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexMobil'}">Kelola Mobil</router-link></li>
              <li class="active">Tambah Mobil</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Mobil</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Mobil" v-model="mobil.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Plat</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Plat Mobil" v-model="mobil.plat" autofocus=""/>
                        <span v-if="errors.plat" class="label label-danger"> {{ errors.plat[0]}}</span>
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
        mobil: {
          kode: '',
          plat: ''
        },
        url: window.location.origin + (window.location.pathname).replace("home","mobil"),
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
          title: "Berhasil Menambah Mobil",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newMobil = this.mobil;
        axios.post(this.url,newMobil)
        .then((resp) => {
          this.alert('Berhasil Menambah Mobil ' + this.mobil.plat );
          this.$router.replace('/mobil/');
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
