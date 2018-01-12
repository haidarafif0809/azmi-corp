
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexMobil'}">Kelola Mobil</router-link></li>
              <li class="active">Edit  Mobil</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  Mobil</div>

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
        mobilId : null,
        url: window.location.origin + (window.location.pathname).replace("home","mobil"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.mobilId = this.$route.params.id;
     axios.get(app.url+'/'+this.mobilId+ '/edit')
     .then((resp) => {
       this.mobil =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");    
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Mobil",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newMobil = this.mobil;
        axios.patch(this.url + '/' + this.mobilId, newMobil)
        .then((resp) => {
          this.alert('Berhasil Mengubah Mobil ' + this.mobil.plat );
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
