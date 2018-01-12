
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexDriver'}">Kelola Driver</router-link></li>
              <li class="active">Edit  Driver</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  Driver</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Driver" v-model="driver.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Driver" v-model="driver.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
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
        driver: {
          kode: '',
          nama: ''
        },
        driverId : null,
        url: window.location.origin + (window.location.pathname).replace("home","driver"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.driverId = this.$route.params.id;
     axios.get(app.url+'/'+this.driverId+ '/edit')
     .then((resp) => {
       this.driver =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");    
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Driver",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newDriver = this.driver;
        axios.patch(this.url + '/' + this.driverId, newDriver)
        .then((resp) => {
          this.alert('Berhasil Mengubah Driver ' + this.driver.nama );
          this.$router.replace('/driver/');
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
