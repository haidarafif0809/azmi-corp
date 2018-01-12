
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexGudang'}">Kelola Gudang</router-link></li>
              <li class="active">Edit  Gudang</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  Gudang</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Gudang" v-model="gudang.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Gudang" v-model="gudang.nama" autofocus=""/>
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
        gudang: {
          kode: '',
          nama: ''
        },
        gudangId : null,
        url: window.location.origin + (window.location.pathname).replace("home","gudang"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.gudangId = this.$route.params.id;
     axios.get(app.url+'/'+this.gudangId+ '/edit')
     .then((resp) => {
       this.gudang =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");    
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Gudang",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newDriver = this.gudang;
        axios.patch(this.url + '/' + this.gudangId, newDriver)
        .then((resp) => {
          this.alert('Berhasil Mengubah Gudang ' + this.gudang.nama );
          this.$router.replace('/gudang/');
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
