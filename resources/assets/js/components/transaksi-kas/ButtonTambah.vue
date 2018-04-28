<template>
    <div class="btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Tambah <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li>
          <router-link 
            :to="{name: 'CreateTransaksiKasMasuk'}" 
          > 
            Tambah Kas Masuk
          </router-link>
        </li>
        <li>
          <router-link 
          :to="{name: 'CreateTransaksiKasKeluar'}" 
          > 
          Tambah Kas Keluar
          </router-link>
        </li>
        <li>
       <router-link 
          :to="{name: 'CreateTransaksiKasMutasi'}" 
       > 
          Tambah Kas Mutasi
        </router-link>
        </li>
      </ul>
    </div>

</template>
