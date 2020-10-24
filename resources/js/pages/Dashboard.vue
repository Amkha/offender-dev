<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-3 mb-4 mt-4">
                    <div class="widget-user-image rounded">
                        <!-- <img class="img-thumbnail" :src="'img/dofilogo.jpg'" alt="DOFI logo" style="max-width: 10rem;"> -->
                    </div>
                </div>
                <div class="col-6 mt-5">
                    <!-- link to Search page here -->
                    <div><h1><i>
                        <a href="offender/offendersearch">Search For Offender</a>  
                        </i></h1>
                    </div>
                </div>
                <div class="col-3 mt-4">
                    <div class="widget-user-image">
                        <!-- <img class="img-thumbnail" :src="'img/maflogo.jpg'" alt="DOFI logo"> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <!-- <div class="card border-primary mb-3" style="max-width: 24rem;"> -->
                    <div class="card border-primary mb-3" style="width: 400px;">
                        <div class="card-header bg-primary">Offender</div>
                        <div class="card-body text-primary">
                            <h5 class="card-title">Summary of Offenders</h5>
                            <p class="card-text">Tatal of offenders: {{totalOffenders.length}}</p>
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to offenders
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-warning mb-3" style="width: 400px;">
                        <div class="card-header bg-warning">Case</div>
                        <div class="card-body text-warning">
                            <h5 class="card-title">Summary of Cases</h5>
                            <p class="card-text">Tatal of cases: {{totalCases.length}}</p>
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
                        <div class="card-header bg-secondary">Business</div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">Summary of Businesses</h5>
                            <p class="card-text">Tatal of businesses: {{totalBusinesses.length}}</p>
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to businesses
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-success mb-3" style="width: 400px;">
                        <div class="card-header bg-success">Network</div>
                        <div class="card-body text-success">
                            <h5 class="card-title">Summary of Network Trafficking</h5>
                            <p class="card-text">Tatal of network trafficking: {{totalNetworks.length}}</p>
                            <a class="action-link float-right" tabindex="-1" @click="someThing">
                                Browse to network trafficking
                            </a>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
            
    </div>
    
</template>

<script>
//import OffenderSearch from './components/offender/OffenderSearch'
//const ability = require('./defineAbility');
    export default {
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
        methods: {
            getDofiLogo(){

                let logo = (this.dofilogo.length > 200) ? this.dofilogo : "img/"+ this.dofilogo ;
                return logo;
            },
            getTotalOffenders(){
                axios.get("/api/getAlloffenders").then(
                    ({data}) => (this.totalOffenders = data));
            },
            getTotalCases(){
                axios.get("/api/getAllCases").then(({data}) => (this.totalCases = data));
            },
            getTotalBusinesses(){
                axios.get("/api/getAllBusinesses").then(({data}) => (this.totalBusinesses = data));
            },
            getTotalNetworks(){
                axios.get("/api/getNetworkTrafficking").then(({data}) => (this.totalNetworks = data));
            },
            someThing(){

            }
        },
        create(){
            console.log('Component created...');
        },
        mounted() {
            console.log('Component mounted ability:', ability.can('read', 'Post'));
           /*  this.getTotalOffenders();
            this.getTotalBusinesses();
            this.getTotalNetworks(); 
            this.getTotalCases(); */
        }
    }
</script>
<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>
