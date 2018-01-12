
<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="breadcrumb">
              <li>Home</li>
              <li><router-link :to="{name: 'IndexUser'}">Kelola User</router-link></li>
              <li class="active">Edit  User</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Edit  User</div>

                <div class="panel-body">
                    <form v-on:submit.prevent="saveForm()" class="form-horizontal" >
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Email</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Email User" v-model="user.email" autofocus=""/>
                        <span v-if="errors.email" class="label label-danger"> {{ errors.email[0]}}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name" class="col-md-2 control-label" >Nama</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" required="" placeholder="Nama User" v-model="user.name" autofocus=""/>
                        <span v-if="errors.name" class="label label-danger"> {{ errors.name[0]}}</span>
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
        user: {
          email: '',
          name: ''
        },
        userId : null,
        url: window.location.origin + (window.location.pathname).replace("home","user"),
        errors: [],
        message: ''
      }
    },
    mounted()  {
     var app = this;
     this.userId = this.$route.params.id;
     axios.get(app.url+'/'+this.userId+ '/edit')
     .then((resp) => {
       this.user =  resp.data;
     })
     .catch((resp) => {
        alert("Something Goes Wrong");    
     });

    },
    methods: {
      alert(pesan){
        this.$swal({
          title: "Berhasil Mengubah User",
          text: pesan,
          icon: "success"
        });
      },
      saveForm(){
        var newUser = this.user;
        axios.patch(this.url + '/' + this.userId, newUser)
        .then((resp) => {
          this.alert('Berhasil Mengubah User ' + this.user.name );
          this.$router.replace('/user/');
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
