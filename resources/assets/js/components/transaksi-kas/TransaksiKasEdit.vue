

<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexAkun'}">Kelola Akun</router-link></li>
              <li class="active">Edit  Akun</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  Akun</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Kode</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Kode Akun" v-model="akun.kode" autofocus=""/>
                        <span v-if="errors.kode" class="label label-danger"> {{ errors.kode[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama Akun" v-model="akun.nama" autofocus=""/>
                        <span v-if="errors.nama" class="label label-danger"> {{ errors.nama[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Jenis</label>
                        <div class="col-md-4">
                        <select v-model="akun.jenis" class="form-control" required="" >
                            <option value="">Pilih Jenis Akun</option>
                            <option value="kas">Kas</option>
                            <option value="penjualan">Penjualan</option>
                            <option value="pembelian">Pembelian</option>
                            <option value="piutang">Piutang</option>
                            <option value="modal">Modal</option>
                            <option value="persediaan">Persediaan</option>
                            <option value="hpp">Harga Pokok Penjualan</option>
                          </select>
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
        akun: {
          kode: '',
          nama: '',
          jenis: ''
        },
        mobilId : null,
        url: window.location.origin + (window.location.pathname).replace("home","akun"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.mobilId = this.$route.params.id;
     axios.get(app.url+'/'+this.mobilId+ '/edit')
     .then((resp) => {
       this.akun =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");    
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah Akun",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newAkun = this.akun;
        axios.patch(this.url + '/' + this.mobilId, newAkun)
        .then((resp) => {
          this.alert('Berhasil Mengubah Akun ' + this.akun.nama );
          this.$router.replace('/akun/');
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
