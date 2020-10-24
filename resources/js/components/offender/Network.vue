<template>
 <div class="container">
    <div class="row mt-5">
      <!-- <div class="row mt-5" v-if="$gate.isAdminOrAuthor()"> -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- <h3 class="card-title">{{ $t('Offenders Table') }}</h3> -->
                    <h3 class="card-title">{{$t('network​list')}}</h3>
                    <div class="card-tools">
                        <button v-tooltip="addnetworktooltip" class="btn btn-success" @click="newNetworkModal()">{{$t('addnewnetwork')}}<i class="fas fa-user-plus fa-fw"></i></button>
                    </div>
                </div>
                <p>{{$t('hello')}}</p>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ $t('id') }}</th>
                                <th>{{ $t('logo') }}</th>
                                <th>{{ $t('networkname') }}</th>
                                <th>{{ $t('networktype') }}</th>
                                <!-- <th>{{ $t('country') }}</th> -->
                                <th>{{ $t('crimelevel') }}</th>
                                <th>{{ $t('operation') }}</th>
                            </tr>
                            <tr v-for="network in networks.data" v-bind:key="network.id">
                                <td>{{network.id}}</td>
                                <td>
                                    <a href="#">
                                    <img :src="'/storage/images/' + network.MobLogo" style="width: 50px; height: 50px" class='img-thumbnail'/></a>
                                </td>
                                <td>{{network.MobName | upText}}</td>
                                <td>{{network.NetworkType}}</td>
                                <!-- <td>{{network.Country}}</td> -->
                                <td>{{network.CrimeLevel}}</td>
                                <td>
                                    <a href="#">
                                        <!-- <i v-tooltip="viewtooltip" class="fa fa-eye blue" @click="viewNetwork(network)"></i> -->
                                        <button v-tooltip="viewtooltip" class="btn btn-info btn-sm" @click="viewNetwork(network)">{{ $t('view') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                    </a>
                                    <a href="#">
                                        <!-- <i v-tooltip="edittooltip" class="fa fa-edit green" @click="editNetworkModal(network)"></i> -->
                                        <button v-if="$gate.isAdminOrDofi()" v-tooltip="edittooltip" class="btn btn-success btn-sm" @click="editNetworkModal(network)">{{ $t('edit') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                    </a>
                                    <a href="#">
                                        <!-- <i v-tooltip="deletetooltip" class="fa fa-trash red" @click="deleteNetwork(network.id)"></i> -->
                                        <button v-if="$gate.isAdminOrDofi()" v-tooltip="deletetooltip" class="btn btn-danger btn-sm" @click="deleteNetwork(network.id)">{{ $t('delete') }}<i class="fas fa-user-plus fa-fw"></i></button>                                    
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="networks" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>
    </div>
    
<!-- Modal Business form----------------------------------------------- -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="addmode" id="addNewLabel">{{$t('addnetwork')}}</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{$t('updatenetwork')}}</h5>
                    <h5 class="modal-title" v-show="viewmode" id="addNewLabel">{{$t('viewnetwork')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        
                <form id="networkForm" @submit.prevent="editmode ? updateNetwork() : createNetwork()" enctype="multipart/form-data">
                    <!-- <fieldset disabled="disabled"> -->
                    <div class="modal-body">
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label for="MobName">{{$t('mobname')}}:</label>
                                <input v-model="form.MobName" type="text" name="MobName"
                                    placeholder="Mob Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('MobName') }">
                                <has-error :form="form" field="MobName"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="NetworkType">{{$t('networktype')}}:</label>
                                <select name="NetworkType" v-model="form.NetworkType" id="NetworkType" class="form-control" :class="{ 'is-invalid': form.errors.has('NetworkType') }">
                                    <option value="">Select Network Type</option>
                                    <option v-for="networktype in networktypes" :key="networktype.id">{{ networktype.EngType }}</option>
                                </select>                                                                                                                       
                                <has-error :form="form" field="NetworkType"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="NetworkActivity">{{$t('activity')}}:</label>
                                <input v-model="form.NetworkActivity" type="text" name="NetworkActivity"
                                    placeholder="Activity ...."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('NetworkActivity') }">
                                <has-error :form="form" field="NetworkActivity"></has-error>
                            </div>
                            
                        </div>
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label for="MainAddress">{{$t('mainaddress')}}:</label>
                                <div class="form-group">
                                    <textarea v-model="form.MainAddress" name="MainAddress" id="Address" placeholder="Main Address ...."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('MainAddress') }"></textarea>
                                    <has-error :form="form" field="MainAddress"></has-error>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="Country">{{$t('country')}}:</label>
                                <select name="Country" v-model="form.Country" id="Country" class="form-control" :class="{ 'is-invalid': form.errors.has('Country') }">
                                    <option value="">Select Country</option>
                                    <option v-for="country in countries" :key="country.id">{{ country.NationEng }}</option>
                                </select>                                                                                                                       
                                <has-error :form="form" field="Country"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="MemberNumber">{{$t('membernumber')}}:</label>
                                <input v-model="form.MemberNumber" type="number" name="MemberNumber"
                                    placeholder="Member Number..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('MemberNumber') }">
                                <has-error :form="form" field="MemberNumber"></has-error>
                            </div>
                        </div>
                        <div class="form-row">  
                            <div class="form-group col-4">
                                <label for="CrimeLevel">{{$t('crimelevel')}}:</label>
                                <select name="CrimeLevel" v-model="form.CrimeLevel" id="CrimeLevel" class="form-control" :class="{ 'is-invalid': form.errors.has('CrimeLevel') }">
                                    <option value="">Select Crime Level</option>
                                    <option v-for="crimelevel in networkcrimelevels" :key="crimelevel.id">{{ crimelevel.LevelEng }}</option>
                                </select>                                                                                                                       
                                <has-error :form="form" field="CrimeLevel"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="moblogo">{{$t('moblogo')}}:</label>
                                <div class="file-field">
                                    <div class="btn btn-success btn-md float-left">
                                        <img :src="'/storage/images/' + form.MobLogo" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                        <span>MobLogo: </span><input type="file" name="MobLogo" id="MobLogo" @change="selectFile($event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- </fieldset> -->
                    <div class="modal-footer">
                        <button id="closebtn" type="button" class="btn btn-danger" data-dismiss="modal">{{$t('close')}}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{$t('update')}}</button>
                        <button v-show="!editmode && !viewmode" type="submit" class="btn btn-primary">{{$t('create')}}</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div> 
  </div>  <!-- CONTAINER -->
</template>
<script>

import Form from 'vform'
import VueAxios from 'vue-axios'
const axios = require('axios')
Vue.use(VueAxios, axios) 
const $ = require('jquery')

export default {
  middleware: 'auth',
//------------------------------ DATA -----------------------
data() {
        return {
            addnetworktooltip: 'Add New Network.',
            edittooltip: 'Edit Network.',
            deletetooltip: 'Delete Network.',
            viewtooltip: 'View Network.',
            addmode: false,
            editmode: false,
            viewmode: false,
            CompanyLogo: null,
            countries: {},
            networktypes: {},
            networkcrimelevels: {},
            network: {},
            networks: {},
                    
             form: new Form ({
                    id: '',
                    MobName: '',
                    NetworkType: '',
                    NetworkActivity: '',
                    MainAddress: '',
                    Country: '',
                    MemberNumber: '',
                    CrimeLevel: '',
                    MobLogo: '',
                    user_id: '',
              }),
        } 
    },
//------- methods class ---------------------------
  methods: {
      
      getResults(page = 1) {
        axios.get('/api/network?page=' + page)
        .then(response => {
            this.networks = response.data;
                })
                .catch(errors => {
                    console.log(errors)
                });
      },
      
      loadNetworks(){
          axios.get("/api/network").then(({data}) => (this.networks = data));
          // console.log(this.nationalities);
      },
      loadCountries(){
          axios.get("/api/getCountries").then(({data}) => (this.countries = data));
          // console.log(this.nationalities);
      },
      getNetworktypes(){
          axios.get("/api/getNetworktypes").then(({data}) => (this.networktypes = data));
      },
      getNetworkCrimelevels(){
          axios.get("/api/getNetworkCrimelevels").then(({data}) => (this.networkcrimelevels = data));
      },
//==========================================================================
      deleteNetwork(id){
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
                                  this.form.delete('api/network/'+id).then(() => {
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
          this.MobLogo = e.target.files[0];
      },
      
      selectFile(e){
          let file = e.target.files[0];
          // console.log(this.file);
          let reader = new FileReader();
          if(file['size'] < 2111775){
              reader.onloadend = (file) => {
                  this.form.MobLogo = reader.result;
              }
              reader.readAsDataURL(file);               
          }else{
              swal({
                  type: 'error',
                  title: 'Ooops..',
                  text: 'File size is more than 2MB...',
              })
          }
          
      },
      
//-------------------------------------create Business--------------------------------------------------------------------------
      createNetwork(){
          this.$Progress.start();
          this.form.post('/api/network')
          .then((() => {
              Fire.$emit('AfterCreate');
              $('#addNew').modal('hide');
              toast({
                  type: 'success',
                  title: 'Network Created in successfully'
                  })
              this.$Progress.finish();
          }))
          .catch(() => {
              this.$Progress.fail();
          });           
      },
      updateNetwork(){
          this.form.put('/api/network')           
          .then(() => {
                  // success
                  $('#addNew').modal('hide');
                    swal(
                      'Updated!',
                      'Information has been updated.',
                      'success'
                      )
                      this.$Progress.finish();
                      Fire.$emit('AfterCreate');
          })
          .catch(() => {
              this.$Progress.fail();
          });
      },
      viewNetwork(network){

          this.addmode = false;
          this.editmode = false;
          this.viewmode = true;

          $("#networkForm :input").prop("disabled", true);
          $("#closebtn").attr("disabled",false);
        
          this.form.reset();
          this.loadCountries();
          this.getNetworktypes();
          this.getNetworkCrimelevels();
          
          $('#addNew').modal('show');
          this.form.fill(network);
      },

      editNetworkModal(network){
          
          //this.setFieldset(false);
          $("#networkForm :input").prop("disabled", false);
          $("#closebtn").attr("disabled",false);
          this.addmode = false;
          this.editmode = true;
          this.viewmode = false;
          this.form.reset();
          this.loadCountries();
          this.getNetworktypes();
          this.getNetworkCrimelevels();
          $('#addNew').modal('show');
          this.form.fill(network);
      },
      newNetworkModal(){
         $("#networkForm :input").prop("disabled", false);
         $("#closebtn").attr("disabled",false);
          this.addmode = true;
          this.editmode = false;
          this.viewmode = false;
          this.form.reset();
          this.loadCountries();
          this.getNetworktypes();
          this.getNetworkCrimelevels();
          $('#addNew').modal('show');
      },
},
    
//------- created class initialized component---------------------------
// 1-create users.vue in components folder
// 2-register route path in app.js    
created() {
   // this.setFieldset(false);
    Fire.$on('searching',() => {
        let query = this.$parent.search;
        axios.get('/api/findNetwork?q=' + query)
        .then((data) => {
            this.networks = data.data
        })
        .catch(() => {

        })
    }); 
    this.$Progress.start();
    this.loadNetworks();
    this.loadCountries();
    this.getNetworktypes();
    this.getNetworkCrimelevels();
    toast.fire({
        type: 'success',
        title: 'Networks loaded successfully'
        });
    this.$Progress.finish();
    Fire.$on('AfterCreate',() => {
            this.loadNetworks();
        });
    // console.log('Component mounted..')
    
},
mounted() {
    // console.log('Component mounted..');
    this.addmode = true;
    this.editmode = true;
    this.viewmode = true
    //this.setFieldset(false);

  },

  //---------------------------------------------------------
  metaInfo () {
    return { title: this.$t('network') }
  }

}
</script>
