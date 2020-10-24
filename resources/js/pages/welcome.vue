<template>
  <div class="container">
    <!-- <img src="/images/home-cover.jpg" alt="Home page" class="image">
    <div class="overlay">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif
        <div class="title m-b-md">
            OFFENDER DATABASE SYSTEM
        </div> -->   

      <img src="images/home-cover.jpg" alt="Home page" class="image">
      <div class="overlay">
        <div class="top-right links">
          <template v-if="authenticated">
            <router-link :to="{ name: 'home' }">
              {{ $t('home') }}
            </router-link>
          </template>
          <template v-else>
            <router-link :to="{ name: 'about' }">
              {{ $t('about') }}
            </router-link>
            <router-link :to="{ name: 'login' }">
              {{ $t('login') }}
            </router-link>
            <router-link :to="{ name: 'register' }">
              {{ $t('register') }}
            </router-link>
            <router-link :to="{ name: 'hello' }">
              {{ $t('helloworld') }}
            </router-link>
          </template>
        </div>

        <div class="text-center mt-5">
          <div class="title mb-3">
            {{ title }}
            <h1>Database System</h1>
          </div>

          <!-- <div class="links">
            <a href="https://laravel.com/docs">Documentation</a>
            <a href="https://vuejs.org/v2/guide/">Vuejs</a>
            <a href="https://github.com/dalholm/laravel-spa-starter-kit">GitHub</a>
          </div> -->
        </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from '~/components/LocaleDropdown'
export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),
  components: {
    LocaleDropdown
  },

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 65px;
}
.image {
    display: block;
    width: 100%;
    height: auto;
    margin: 0;
    }

.overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0.4;
    transition: .5s ease;
    background-color: #fff;
}
/* .container:hover .overlay {
    opacity: 1;
} */
</style>
