<template>
 <div class="container">
    <div class="row mt-5">
      <!-- <div class="row mt-5" v-if="$gate.isAdminOrAuthor()"> -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- <h3 class="card-title">{{ $t('Offenders Table') }}</h3> -->
                    <h3 class="card-title">{{$t('usermanagement')}}</h3>
                    <div class="card-tools">
                        <button v-tooltip="addusertooltip" class="btn btn-success" @click="newUserModal()">{{$t('addnewuser')}}<i class="fas fa-user-plus fa-fw"></i></button>
                    </div>
                </div>
                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ $t('id') }}</th>
                                <th>{{ $t('name') }}</th>
                                <th>{{ $t('email') }}</th>
                                <th>{{ $t('type') }}</th>
                                <th>{{ $t('created_at') }}</th>
                                <th>{{ $t('operation') }}</th>
                            </tr>
                            <tr v-for="user in users.data" v-bind:key="user.id">
                                <td>{{user.id}}</td>
                               <!--  <td>
                                    <a href="#">
                                    <img :src="'/storage/images/' + network.MobLogo" style="width: 50px; height: 50px" class='img-thumbnail'/></a>
                                </td> -->
                                <td>{{user.name | upText}}</td>
                                <td>{{user.email}}</td>
                                <!-- <td>{{network.Country}}</td> -->
                                <td>{{user.type}}</td>
                                <td>{{user.created_at}}</td>
                                <td>
                                    <a href="#">
                                        <!-- <i v-tooltip="viewtooltip" class="fa fa-eye blue" @click="viewNetwork(network)"></i> -->
                                        <button v-tooltip="viewtooltip" class="btn btn-info btn-sm" @click="viewUser(user)">{{ $t('view') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                    </a>
                                    <a href="#">
                                        <!-- <i v-tooltip="edittooltip" class="fa fa-edit green" @click="editNetworkModal(network)"></i> -->
                                        <button v-tooltip="edittooltip" class="btn btn-success btn-sm" @click="editUserModal(user)">{{ $t('edit') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                    </a>
                                    <a href="#">
                                        <!-- <i v-tooltip="deletetooltip" class="fa fa-trash red" @click="deleteNetwork(network.id)"></i> -->
                                        <button v-tooltip="deletetooltip" class="btn btn-danger btn-sm" @click="deleteUser(user.id)">{{ $t('delete') }}<i class="fas fa-user-plus fa-fw"></i></button>                                    
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="users" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>
    </div>
    
<!-- Modal Business form----------------------------------------------- -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="addtmode" id="addNewLabel">{{ $t('addnewuser') }}</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{ $t('updateuser') }}</h5>
                    <h5 class="modal-title" v-show="viewmode" id="addNewLabel">{{ $t('viewuser') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        
                <form id="userForm" @submit.prevent="editmode ? updateUser() : createUser()" enctype="multipart/form-data">
                    <!-- <fieldset disabled="disabled"> -->
                    <div class="modal-body">
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label class="col-md-4 col-form-label text-md-right">{{ $t('name') }}</label>
                                <input v-model="form.name" type="text" name="User Name"
                                    placeholder="user name.."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label class="col-md-4 col-form-label text-md-right">{{ $t('email') }}</label>
                                <input v-model="form.email" type="email" name="email"
                                    placeholder="Email ...."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label class="col-md-4 col-form-label text-md-right">{{ $t('type') }}</label>
                                <select name="type" v-model="form.type" id="email" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="dofi">DOFI</option>
                                    <option value="pofi">POFI</option>
                                    <option value="guest">Guest</option>
                                    <!-- <option v-for="networktype in networktypes" :key="networktype.id">{{ networktype.EngType }}</option> -->
                                </select>                                                                                                                       
                                <has-error :form="form" field="type"></has-error>
                            </div>                            
                        </div>
                        
                        <div class="form-row">  
                            <div class="form-group col-6">
                                <label class="col-md-6 col-form-label text-md-center">{{ $t('password') }}</label>
                                <input v-model="form.password" type="password" name="password"
                                        placeholder="password ...."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                <div class="form-group col-4">
                                    <!-- <div class="file-field">
                                        <div class="btn btn-success btn-md float-left">
                                            <img :src="'/storage/images/' + form.MobLogo" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                            <span>MobLogo: </span><input type="file" name="MobLogo" id="MobLogo" @change="selectFile($event)">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- </fieldset> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('close') }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('update') }}</button>
                        <button v-show="!editmode && !viewmode" type="submit" class="btn btn-primary">{{ $t('create') }}</button>
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
            addusertooltip: 'Add New User',
            edittooltip: 'Edit User.',
            deletetooltip: 'Delete User.',
            viewtooltip: 'View User.',
            addtmode: false,
            editmode: false,
            viewmode: false,
            CompanyLogo: null,   
            users: {},                 
             form: new Form ({
                    id: '',
                    name: '',
                    email: '',
                    type: '',
                    password: '',                    
              }),
        } 
    },
//------- methods class ---------------------------
  methods: {
      getResults(page = 1) {
        axios.get('/api/users?page=' + page)
        .then(response => {
            this.users = response.data;
                })
                .catch(errors => {
                    console.log(errors)
                });
        },
      
      loadUsers(){
          axios.get("/api/users").then(({data}) => (this.users = data));
          console.log(this.users);
      },
      
//==========================================================================
      deleteUser(id){
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
                                  this.form.delete('/api/users/'+id).then(() => {
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
      createUser(){
          this.$Progress.start();
          this.form.post('/api/users')
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
      updateUser(){
          this.form.put('/api/users')           
          .then(() => {
                  // success
                  $('#addNew').modal('hide');
                    swal(
                      'Updated!',
                      'User info has been updated.',
                      'success'
                      )
                      this.$Progress.finish();
                      Fire.$emit('AfterCreate');
          })
          .catch(() => {
              this.$Progress.fail();
          });
      },
      viewUser(user){
          this.addmode = false;
          this.editmode = false;
          this.setFieldset(true);
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(user);
      },

      editUserModal(user){
          this.addtmode = false;
          this.editmode = true;
          this.setFieldset(false);
          this.form.reset();
          
          $('#addNew').modal('show');
          this.form.fill(user);
      },
      newUserModal(){
          this.addtmode = true;
          this.editmode = false;
          this.setFieldset(false);
          this.form.reset();
          
          $('#addNew').modal('show');
      },
      setFieldset(viewmode){
      if (viewmode){
              $("#userForm :input").prop("disabled", true);
              this.addtmode = false;
              this.editmode = false;
              this.viewmode = true;
              console.log(viewmode);
          }else{
              $("#userForm :input").prop("disabled", false);
              //this.editmode = false;
              this.viewmode = false;
              //this.addtmode = true;
              //this.editmode = true;
              console.log(viewmode);
          } 
      
      },
},
    
//------- created class initialized component---------------------------
// 1-create users.vue in components folder
// 2-register route path in app.js    
created() {
    /* this.setFieldset(false);
    Fire.$on('searching',() => {
        let query = this.$parent.search;
        axios.get('/api/findNetwork?q=' + query)
        .then((data) => {
            this.networks = data.data
        })
        .catch(() => {

        })
    });  */
    this.$Progress.start();
    this.loadUsers();
    
    toast.fire({
        type: 'success',
        title: 'Users loaded successfully'
        });
    this.$Progress.finish();
    Fire.$on('AfterCreate',() => {
            this.loadUsers();
        });
    // console.log('Component mounted..')
    
},
mounted() {
    // console.log('Component mounted..');
    this.addtmode = true;
    this.editmode = false;
    this.setFieldset(false);

  },

  //---------------------------------------------------------
  metaInfo () {
    return { title: this.$t('user') }
  }

}
</script>
