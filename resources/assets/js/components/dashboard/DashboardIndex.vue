<template>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <div class="panel panel-danger">
                    <div class="panel-heading">
                      <h3 class="panel-title"><b>Peringatan </b> Kartu Kredit</h3>
                    </div>
                    <div class="panel-body">
                      <ul class="list-group">
                        <li class="list-group-item" v-for=" kartuKredit in kartuKredits" :key="kartuKredit.id">
                          <p v-if="kartuKredit.sisaHari == 0"><b>{{ kartuKredit.akun.nama}}</b> Jatuh Tanggal Bayar <b>Hari Ini!</b></p>
                          <p v-if="kartuKredit.sisaHari < 5 && kartuKredit.sisaHari > 0"><b>{{ kartuKredit.akun.nama}}</b> Jatuh Tanggal Bayar Tinggal <b>{{ kartuKredit.sisaHari}} Hari Lagi!</b></p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>
<script>

  export default {
    data: function () {
      return {
        kartuKredits: [],
        url: window.location.origin + (window.location.pathname).replace("home","kartu-kredit"),
      }
    },
    mounted () {
      var app = this
      app.getKartuKredit()
    },
    methods: {
      getKartuKredit(page) {
        var app = this;
        if(typeof page == 'undefined'){
          page = 1;
        }
        axios.get(app.url + '/view?page=' + page)
        .then(function(resp){
          app.kartuKredits = resp.data.data;
          app.loading = false;
          app.tentukanSisaHari()
        })
        .catch(function(resp){
          console.log(resp);
          app.loading = false;

        })
      },
      tentukanSisaHari () {
        const date = new Date();
        const day = date.getDate();

        this.kartuKredits = this.kartuKredits.map(kartu => {
          let sisaHari = -1
          if (kartu.tanggal_bayar >= day) {
            sisaHari = Number(kartu.tanggal_bayar) - Number(day)
          }
          kartu.sisaHari = sisaHari
          return kartu
        })

      }
    }
  }
</script>
