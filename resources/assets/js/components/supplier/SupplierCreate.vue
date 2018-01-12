
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexSupplier'}">Kelola Supplier</router-link></li>
              <li class="active">Tambah Supplier</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Supplier</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Supplier" v-model="supplier.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Supplier" v-model="supplier.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kontak</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kontak Supplier" v-model="supplier.kontak" autofocus=""/>
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
        supplier: {
          kode: '',
          nama: '',
          kontak: ''
        },
        url: window.location.origin + (window.location.pathname).replace("home","supplier"),
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
          title: "Berhasil Menambah Supplier",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newSupplier = this.supplier;
        axios.post(this.url,newSupplier)
        .then((resp) => {
          this.alert('Berhasil Menambah Supplier ' + this.supplier.nama );
          this.$router.replace('/supplier/');
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
