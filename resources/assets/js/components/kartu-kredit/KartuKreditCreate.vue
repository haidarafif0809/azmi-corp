
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexKartuKredit'}">Kelola Kartu Kredit</router-link></li>
              <li class="active">Tambah Kartu Kredit</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Kartu Kredit</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Kartu Kredit" v-model="kartuKredit.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Kartu Kredit" v-model="kartuKredit.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Limit</label>
                        <div class="col-md-4">
                          <input type="number" class="form-control" required="" placeholder="Limit Kartu Kredit" v-model="kartuKredit.limit" />
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
        kartuKredit: {
          kode: '',
          nama: '',
          limit: 0
        },
        url: window.location.origin + (window.location.pathname).replace("home","kartu-kredit"),
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
          title: "Berhasil Menambah Kartu Kredit",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newKartuKredit = this.kartuKredit;
        axios.post(this.url,newKartuKredit)
        .then((resp) => {
          this.alert('Berhasil Menambah Kartu Kredit ' + this.kartuKredit.nama );
          this.$router.replace('/kartu-kredit/');
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
