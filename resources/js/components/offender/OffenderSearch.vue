<style>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
        height: 250px !important;
    }
    .widget-user .card-footer{
        padding: 0;
    }
</style>
<template>
    <div class="container">
        <div class="row mt-5">
            <!-- <div class="row mt-5" v-if="$gate.isAdminOrAuthor()"> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="form-group col-4">
                            <div class="card-header">
                                <!-- <h3 class="card-title">{{ $t('Offenders Table') }}</h3> -->
                                <h3 class="card-title">{{ $t('offenderslist') }}</h3>
                            </div>
                        </div>
                        <div class="form-group col-8">
                            <div class="card-tools">
                                <!-- SEARCH FORM -->
                                <div class="form-group col-8">
                                    <div class="input-group input-group-sm mt-4">
                                        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-navbar" @click="searchit">
                                                <i class="fa fa-search"></i>
                                            </button> 
                                            <!-- <button v-tooltip="addtooltip" class="btn btn-success btn-md ml-5 mt-1" @click="newModal()">{{ $t('addoffender') }}<i class="fas fa-user-plus fa-fw"></i></button>           -->
                                        </div>
                                    </div>
                                </div>
                                <!-- <button v-tooltip="addtooltip" class="btn btn-success" @click="newModal()">Add New Offender<i class="fas fa-user-plus fa-fw"></i></button> -->
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>{{ $t('id') }}</th>
                                    <th>{{ $t('photo') }}</th>
                                    <th>{{ $t('firstname') }}</th>
                                    <th>{{ $t('lastname') }}</th>
                                    <th>{{ $t('age') }}</th>
                                    <th>{{ $t('gender') }}</th>
                                    <th>{{ $t('created') }}</th>
                                    <th>{{ $t('viewoffenderdetail') }}</th>
                                </tr>
                                <tr v-for="offender in offenders.data" v-bind:key="offender.id">
                                    <td>{{offender.id}}</td>
                                    <td>
                                        <a href="#">
                                        <img :src="'/storage/images/' + offender.Photo" style="width: 50px; height: 50px" class='img-thumbnail'/></a>
                                    </td>
                                    <td>{{offender.FirstName | upText}}</td>
                                    <td>{{offender.LastName | upText}}</td>
                                    <td>{{offender.Age}}</td>
                                    <td>{{offender.Gender}}</td>
                                    <td>{{offender.created_at | myDate}}</td>
                                    <td>
                                        <!-- <a :href="'/offender/offenderprofile/' + offender.id">
                                            <i v-tooltip="viewtooltip" class="fa fa-eye blue"></i>
                                            <i v-tooltip="viewtooltip" class="fa fa-eye blue" @click="viewOffenderProfile(offender)"></i> 
                                        </a> -->
                                        <!-- <router-link to="/offenderprofile">View More Detail</router-link> -->
                                        <router-link :to="{ name: 'offender.profiledetail', params: { msg, offender } }">
                                                    {{ $t('viewoffenderdetail') }}
                                        </router-link>
                                        <!-- <a href="#">
                                            <i v-tooltip="edittooltip" class="fa fa-edit green" @click="editModal(offender)"></i>
                                        </a>
                                        <a href="#">
                                            <i v-tooltip="deletetooltip" class="fa fa-trash red" @click="deleteOffender(offender.id)"></i>
                                        </a>
                                        
                                        <a href="#">
                                            <i v-tooltip="addcasetooltip" class="fa fa-user-secret" @click="addCaseModal(offender.id)"></i>
                                        </a> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="offenders" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- container div -->
    </div>   
</template>
<script>
import ProfileDetail from './ProfileDetail.vue'
//import { mapGetters } from 'vuex'
const axios = require('axios')
const $ = require('jquery')
//const $gate = require('./../gate')
export default{
    name: 'Profile',
    data() {
        return {
            addtooltip: 'Add offender.',
            viewtooltip: 'View offender profile',
            edittooltip: 'Edit offender.',
            deletetooltip: 'Delete Offender.',
            addcasetooltip: 'Add new case.',
            editmode: false,
            photo: null,
            search: '',
            nationalities: {},
            provinces: {},
            province: {},
            districts: {},
            district: {},
            villages: {},
            village: {},
            business: {},
            businesses: {},
            network: {},
            networks: {},
            offenders : {},
            statuses: {},
            status: {},
            units: {},
            unit: {},
            types: {}, 
            type: {},  
            msg: `This is Amkh's profile`,       
        } 
    },
//------- methods class ---------------------------
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),
        async getResults(page = 1) {
			await axios.get('/api/offender?page=' + page)
				.then(response => {
					this.offenders = response.data;
				});
        },
        // async update () {
        //     const { data } = await this.form.patch('api/settings/profile');
        async loadOffender(){ 
           await axios.get("/api/offender").then(({data}) => (this.offenders = data));

            // let mygate = this.$gate.IsAdmin;
           
            /* if(this.$gate.IsAdmin()){
                axios.get("/api/offender").then(({data}) => (this.offenders = data));
            } else {
                 console.log('not gate');
            } */
        },
        loadNationalities(){
            axios.get("/api/nationality").then(({data}) => (this.nationalities = data));
           // console.log(this.nationalities);
        },
        loadBusinesses(){
            axios.get("/api/getBusinesses").then(({data}) => (this.businesses = data));
           // console.log(this.nationalities);
        },
        loadNetworks(){
            axios.get("api/getNetworks").then(({data}) => (this.networks = data));
           // console.log(this.nationalities);
        },
        loadDistricts(){
            axios.get("/api/loadDistricts").then(({data}) => (this.districts = data));
           // console.log(this.nationalities);
        },
        loadVillages(){
            axios.get("/api/loadVillages").then(({data}) => (this.villages = data));
           // console.log(this.nationalities);
        },
        
        getProvinces(){
            axios.get("/api/getProvinces").then(({data}) => (this.provinces = data));

            //console.log(provinces);
        },
        getDistricts(province_id){
           //console.log(province_id);
           axios.get('/api/getDistricts',{
                 params: {
                   province_id: province_id
                 }
              }).then(function(response){
                    this.districts = response.data;
                }.bind(this));
        },
        getVillages(district_id){
            axios.get("/api/getVillages", {
                params: {
                    district_id: district_id
                },
            }).then(function(response){
                    this.villages = response.data;
                }.bind(this));
        },
        getCaseTypes(){
            axios.get("/api/getCaseTypes").then(({data}) => (this.types = data));
        },
        getUnits(){
            axios.get("/api/getUnits").then(({data}) => (this.units = data));
        },
        getCaseStatus(){
            axios.get("/api/getCaseStatus").then(({data}) => (this.statuses = data));
        },
//==========================================================================
        /* deleteOffender(id){
                swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.value) {
                                    this.form.delete('/api/offender/'+id).then(() => {
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                    }).catch(() => {
                                        swal('Failed','Something wrong', 'warning');
                                    });
                                }
                        })
                    },
        onFileChange(e){
            console.log(e.target.files[0]);
            this.Photo = e.target.files[0];
        },
       
        selectFile(e){
            let file = e.target.files[0];
           // console.log(this.file);
            let reader = new FileReader();
            if(file['size'] < 2111775){
                reader.onloadend = (file) => {
                    this.form.Photo = reader.result;
                }
                reader.readAsDataURL(file);               
            }else{
                swal({
                    type: 'error',
                    title: 'Ooops..',
                    text: 'File size is more than 2MB...',
                })
            }
            
        }, */
//=================================  Add new cases on offender ===========================================
        
//-------------------------------------create offender--------------------------------------------------------------------------       
    },
//------- created class initialized component---------------------------
// 1-create users.vue in components folder
// 2-register route path in app.js    
    created(){
        Fire.$on('searching',() => {
            //let query = this.$parent.search;
            let query = this.search;
            axios.get('/api/findOffender?q=' + query)
            .then((data) => {
                this.offenders = data.data
            })
            .catch(() => {

            })
        }); 

        this.$Progress.start();
        this.loadOffender();
        this.loadNationalities();
        this.getProvinces();
        this.loadBusinesses();
        this.loadNetworks();
        this.getCaseTypes();
        this.getUnits();
        this.getCaseStatus();
        
        toast.fire({
            type: 'success',
            title: 'Offenders loaded successfully'
            });
        this.$Progress.finish();
        Fire.$on('AfterCreate',() => {
               this.loadOffender();
           });
       // console.log('Component mounted..')
       
    },
    mounted(){
       console.log('Offender Search Component mounted..');       
    }
}
</script>

