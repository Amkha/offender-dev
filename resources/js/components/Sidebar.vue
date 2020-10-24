<template>
  <!-- Sidebar -->
  <!-- <ul class="navbar-nav sidebar shadow sidebar-dark accordion" id="accordionSidebar"> -->
  <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <router-link :to="{ name: user ? 'home' : '' }" class="sidebar-brand d-flex align-items-center justify-content-center" >
      <div class="sidebar-brand-icon rotate-n-15">
        <fa icon="user"/>
      </div>
      <div class="sidebar-brand-text mx-3">
        {{ $t('appName') }}
      </div>
    </router-link>
    
    <div class="sidebar-brand-text mx-3">
      {{ $t('language') }}
    </div>
    <locale-dropdown></locale-dropdown>
    <!-- <profile></profile> -->

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    
    <li class="nav-item active">
      <router-link class="nav-link" :to="{ name: user ? 'home' : '' }">
        <fa icon="home"/>
        <span>{{ $t('home') }}</span>
      </router-link>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Offender search -->
    <li v-if="!$gate.isGuest()" class="nav-item active">
      <router-link class="nav-link" :to="{ name: user ? 'offender.offendersearch' : '' }">
        <fa icon="user"/>
        <span>{{ $t('searchoffender') }}</span>
      </router-link>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Offender section -->
    <li class="nav-item active" v-if="$gate.isAdminOrDofiOrPofi()">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
        <fa icon="user"/>
        <span>{{ $t('offender') }}</span>
      </a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">{{ $t('offender') }}:</h6> -->
          <router-link class="collapse-item" :to="{ name: 'offender.profile' }">
            {{ $t('profile') }}
          </router-link>
        </div>
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">{{ $t('offender') }}:</h6> -->
          <router-link class="collapse-item" :to="{ name: 'offender.business' }">
            {{ $t('bussiness') }}
          </router-link>
        </div>
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">{{ $t('offender') }}:</h6> -->
          <router-link class="collapse-item" :to="{ name: 'offender.network' }">
            {{ $t('network') }}
          </router-link>
        </div>
      </div>
    </li>
        
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" v-if="$gate.isAdmin()">
      {{ $t('system') }}
    </div>
    <hr class="sidebar-divider">
    <!-- Offender section -->
    <li class="nav-item active" v-if="$gate.isAdminOrDofi()">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages1" aria-expanded="true" aria-controls="collapsePages">
        <fa icon="user"/>
        <span>{{ $t('usermanagement') }}</span>
      </a>
      <div id="collapsePages1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">{{ $t('offender') }}:</h6> -->
          <router-link class="collapse-item" :to="{ name: 'usermanagement' }">
            {{ $t('userlist') }}
          </router-link>
        </div>
      </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu  v-if="$gate.isAdmin()"-->
    <hr class="sidebar-divider">
    <li class="nav-item active" v-if="$gate.isAdmin()">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages">
        <fa icon="cog"/>
        <span>{{ $t('settings') }}</span>
      </a>
      <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">{{ $t('settings') }}:</h6>
          <router-link class="collapse-item" :to="{ name: 'settings.profile' }">
            {{ $t('updateprofile') }}
          </router-link>
        </div>
      </div>
    </li>
   
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle" @click="toggleSidebar"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import Profile from './offender/Profile'
//const ability = require('../plugins/defineAbility');

export default {
  components: {
    LocaleDropdown,
    Profile
  },

  data: () => ({
    appName: window.config.appName,
    windowWidth: 0,
    windowHeight: 0,
  }),
  mounted() {
    console.log('Sidebar mounted..')
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    toggleSidebar() {
      this.$parent.toggleSidebar();
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
.change-font {
    font-family: "Phetsarath", Helvetica, sans-serif;
}
</style>
