<template>
  <card :title="$t('home')">
    <!-- {{ $t('you_are_logged_in') }} -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-3 mb-4 mt-4">
                    <div class="widget-user-image rounded">
                        <img class="img-thumbnail" :src="'images/dofilogo/dofilogo.jpg'" alt="DOFI logo" style="max-width: 8rem;">
                    </div>
                </div>
                <div class="col-6 mt-5">
                    <!-- link to Search page here -->
                    <div v-if="$gate.isGuest()"><h3><i>{{$t('guestmessage')}}</i></h3></div>
                    <div v-else><h3><i>
                        <a href="/offender/offendersearch">{{ $t('searchforoffender') }}</a>  
                        </i></h3>
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="widget-user-image">
                        <img class="img-thumbnail" :src="'images/dofilogo/maflogo.jpg'" alt="DOFI logo" style="max-width: 8rem;">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <!-- <div class="card border-primary mb-3" style="max-width: 24rem;"> -->
                    <div class="card border-primary mb-3" style="width: 400px;">
                        <div class="card-header bg-danger">{{$t('offender')}}</div>
                        <div class="card-body text-primary">
                            <h5 class="card-title">{{$t('summaryoffenders')}}</h5>
                            <p class="card-text">{{$t('totaloffenders')}}: {{totalOffenders.length}}</p> 
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to offenders
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-warning mb-3" style="width: 400px;">
                        <div class="card-header bg-warning">{{$t('case​s')}}</div>
                        <div class="card-body text-primary">
                            <h5 class="card-title">{{$t('summarycases')}}</h5>
                            <p class="card-text">{{$t('totalcases')}}: {{totalCases.length}}</p>
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to Cases
                            </a>
                        </div>                  
                    </div>
                </div>    
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card border-secondary mb-3" style="width: 400px;">
                        <div class="card-header bg-info">{{$t('bussiness')}}</div>
                        <div class="card-body text-primary">
                            <h5 class="card-title">{{$t('summarybusinnesses')}}</h5>
                             <p class="card-text">{{$t('totalbusinesses')}}: {{totalBusinesses.length}}</p> 
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to businesses
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-success mb-3" style="width: 400px;">
                        <div class="card-header bg-success">{{$t('network')}}</div>
                        <div class="card-body text-success">
                            <h5 class="card-title">{{$t('summarynetworks')}}</h5>
                              <p class="card-text">{{$t('totalnetworks')}}: {{totalNetworks.length}}</p>
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to network trafficking
                            </a>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
  </card>
</template>

<script>
const axios = require('axios')
//const ability = require('../plugins/defineAbility');
export default {
  middleware: 'auth',
  
  //------------------------- DATA ---------------------
  data(){
    return {
        totalOffenders: 0,
        totalBusinesses: 0,
        totalNetworks: 0,
        totalCases: 0,
        dofilogo:'',
        maflogo: '',
        
    }
  },
  //------------------------- METHOD ---------------------
  methods: {
    someThing() {
      console.log('do thing ...')
    },
    getTotalOffenders(){
        axios.get("api/getAlloffenders").then(
            ({data}) => (this.totalOffenders = data));
    },
    getTotalOffenders(){
        axios.get("api/getAlloffenders").then(
            ({data}) => (this.totalOffenders = data));
    },
    getTotalCases(){
        axios.get("api/getAllCases").then(({data}) => (this.totalCases = data));
    },
    getTotalBusinesses(){
        axios.get("api/getAllBusinesses").then(({data}) => (this.totalBusinesses = data));
    },
    getTotalNetworks(){
        axios.get("api/getNetworkTrafficking").then(({data}) => (this.totalNetworks = data));
    },
  },
  mounted() {
     // console.log('Component mounted.');
    //  console.log('Component mounted ability:', ability.can('read', 'Post'));
    //  this.CAN = ability.can('read', 'Post');
    //  this.CANNOT = ability.cannot('read', 'Post');
      this.getTotalOffenders();
      this.getTotalBusinesses();
      this.getTotalNetworks(); 
      this.getTotalCases();
  },
  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
