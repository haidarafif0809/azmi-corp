
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexProduk'}">Kelola Produk</router-link></li>
              <li class="active">Tambah Produk</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Produk</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Produk" v-model="produk.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Produk" v-model="produk.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Warna</label>
                        <div class="col-md-4">
                          <input type="color" class="form-control" required="" placeholder="Warna Produk" v-model="produk.warna" autofocus=""/>
                        <span v-if="errors.warna" class="label label-danger"> {{ errors.warna[0]}}</span>
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
        produk: {
          kode: '',
          nama: '',
          warna: ''
        },
        url: window.location.origin + (window.location.pathname).replace("home","produk"),
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
          title: "Berhasil Menambah Produk",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newProduk = this.produk;
        axios.post(this.url,newProduk)
        .then((resp) => {
          this.alert('Berhasil Menambah Produk ' + this.produk.nama );
          this.$router.replace('/produk/');
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
