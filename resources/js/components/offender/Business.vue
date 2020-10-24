<template>
    <div class="container">
        <!-- <div class="row mt-5" v-if="$gate.isAdminOrAuthor()"> -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$t('bussinesslist')}}</h3>
                        <div class="card-tools">
                            <button v-tooltip="addtooltip" class="btn btn-success" @click="newBusinessModal()">{{$t('addnewbussiness')}}<i class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- <p>{{$t('hello')}}</p> -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>{{ $t('id') }}</th>
                                    <th>{{ $t('logo') }}</th>
                                    <th>{{ $t('companyname') }}</th>
                                    <th>{{ $t('owner') }}</th>
                                    <!-- <th>Activity</th> -->
                                    <th>{{ $t('country') }}</th>
                                    <th>{{ $t('operation') }}</th>
                                </tr>
                                <tr v-for="business in businesses.data" v-bind:key="business.id">
                                    <td>{{business.id}}</td>
                                    <td>
                                        <a href="#">
                                        <img :src="'/storage/images/' + business.CompanyLogo" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                        </a> 
                                    </td>
                                    <td>{{business.CompanyName | upText}}</td>
                                    <td>{{business.Owner}}</td>
                                    <!-- <td>{{business.Activity}}</td> -->
                                    <td>{{business.Country | upText}}</td>
                                    <td>
                                        <a href="#">
                                            <!-- <i v-tooltip="viewbusinesstooltip" class="fa fa-eye blue" @click="viewBusinessModal(business)"></i> -->
                                            <button v-tooltip="viewbusinesstooltip" class="btn btn-info btn-sm" @click="viewBusinessModal(business)">{{ $t('view') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                        </a>
                                        <a href="#">
                                            <!-- <i v-tooltip="edittooltip" class="fa fa-edit green" @click="editBusinessModal(business)"></i> -->
                                            <button v-if="$gate.isAdminOrDofi()" v-tooltip="edittooltip" class="btn btn-success btn-sm" @click="editBusinessModal(business)">{{ $t('edit') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                        </a>
                                        <a href="#">
                                            <!-- <i v-tooltip="deletetooltip" class="fa fa-trash red" @click="deleteBusiness(business.id)"></i> -->
                                            <button v-if="$gate.isAdminOrDofi()" v-tooltip="deletetooltip" class="btn btn-danger btn-sm" @click="deleteBusiness(business.id)">{{ $t('delete') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="businesses" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        
        </div>
<!-- Modal Business form----------------------------------------------- -->
         <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="addmode" id="addNewLabel">{{$t('addbusiness')}}</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{$t('updatebusiness')}}</h5>
                        <h5 class="modal-title" v-show="viewmode" id="addNewLabel">{{$t('viewbusiness')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            
                    <form id="businessForm"  @submit.prevent="editmode ? updateBusiness() : createBusiness()" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-row">    
                                <div class="form-group col-4">
                                    <label for="CompanyName">{{$t('companyname')}}:</label>
                                    <input v-model="form.CompanyName" type="text" name="CompanyName"
                                        placeholder="Company Name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('CompanyName') }">
                                    <has-error :form="form" field="CompanyName"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Owner">{{$t('owner')}}:</label>
                                    <input v-model="form.Owner" type="text" name="Owner"
                                        placeholder="Owner Name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('Owner') }">
                                    <has-error :form="form" field="Owner"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Activity">{{$t('activity')}}:</label>
                                    <textarea v-model="form.Activity" name="Activity"
                                        placeholder="Activity ...."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('Activity') }"></textarea>
                                    <has-error :form="form" field="Activity"></has-error>
                                </div>
                                
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-3">
                                    <label for="Address">{{$t('address')}}:</label>
                                    <textarea v-model="form.Address" name="Address" id="Address" placeholder="Current Address ...."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('Address') }"></textarea>
                                    <has-error :form="form" field="Address"></has-error>
                                </div>   
                                <div class="form-group col-3">
                                    <label for="Country">{{$t('country')}}:</label>
                                    <select name="Country" v-model="form.Country" id="Country" class="form-control" :class="{ 'is-invalid': form.errors.has('Country') }">
                                        <option value="">Select Country</option>
                                        <option v-for="country in countries" :key="country.id">{{ country.NationEng }}</option>
                                    </select>                                                                                                                       
                                    <has-error :form="form" field="Country"></has-error>
                                </div>
                                <div class="form-group col-3">
                                    <label for="Latitude">{{$t('latitude')}}:</label>
                                    <input v-model="form.latitude" type="text" name="latitude"
                                        placeholder="Latitude ...."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('latitude') }">
                                    <has-error :form="form" field="latitude"></has-error>
                                </div>
                                <div class="form-group col-3">
                                    <label for="Longtitude">{{$t('longtitude')}}:</label>
                                    <input v-model="form.longtitude" type="text" name="longtitude"
                                        placeholder="Longtitude..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('longtitude') }">
                                    <has-error :form="form" field="longtitude"></has-error>
                                </div>
                            </div>
                            <div class="form-row">  
                                <div class="form-group col-4">
                                    <label for="Phone">{{$t('phone')}}:</label>
                                    <input v-model="form.Phone" type="text" name="Phone"
                                        placeholder="Phone number ...."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('Phone') }">
                                    <has-error :form="form" field="Phone"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Email">{{$t('email')}}:</label>
                                    <input v-model="form.Email" type="text" name="Email"
                                        placeholder="Email address ...."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('Email') }">
                                    <has-error :form="form" field="Email"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="SocialNetwork">{{$t('socialnetwork')}}:</label>
                                    <input v-model="form.SocialNetwork" type="text" name="SocialNetwork"
                                        placeholder="Social Media Network ...."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('SocialNetwork') }">
                                    <has-error :form="form" field="SocialNetwork"></has-error>
                                </div>
                            </div>
                            <div class="form-row">  
                                <div class="form-group col-4">
                                    <label for="CompanyLogo">{{$t('companylogo')}}:</label>
                                    <div class="file-field">
                                        <div class="btn btn-success btn-md float-left">
                                            <img :src="'/storage/images/' + form.CompanyLogo" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                            <!-- <a target="_blank" href= {{URL::to('/storage/images/')}} + form.CompanyLogo + ">" +  <img src="/storage/images/" + form.CompanyLogo +  width="70px" class="img-thumbnail"/> -->
                                            <!-- <a target='_blank' href=" + "{{URL::to('/storage/images/'}}" + html.data.Photo +">" +  "<img src={{URL::to('/storage')}}/images/" + html.data.Photo + " width='70px' class='img-thumbnail'/> -->
                                            <span>CompanyLogo: </span><input type="file" name="CompanyLogo" id="Photo" @change="selectFile($event)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button id="closebtn" type="button" class="btn btn-danger" data-dismiss="modal">{{$t('close')}}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">{{$t('update')}}</button>
                            <button v-show="!editmode && !viewmode" type="submit" class="btn btn-primary">{{$t('add')}}</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>   
    </div>   <!-- container div -->
</template> 
<script>
//import Vue from 'vue'
import Form from 'vform'
import VueAxios from 'vue-axios'
const axios = require('axios')
Vue.use(VueAxios, axios) 
const $ = require('jquery')
export default{
    data() {
        return {
            addtooltip: 'Add Business.',
            edittooltip: 'Edit Business.',
            deletetooltip: 'Delete Business.',
            viewbusinesstooltip: 'View Business.',
            addmode: false,
            editmode: false,
            viewmode: false,
            CompanyLogo: null,
            countries: {},
            
            business: {},
            businesses: {},
                    
             form: new Form ({
                    id: '',
                    CompanyName: '',
                    Owner: '',
                    Activity: '',
                    Address: '',
                    Country: '',
                    latitude: '',
                    longtitude: '',
                    Phone: '',
                    Email: '',
                    SocialNetwork: '',
                    CompanyLogo: '',
                    user_id: '',
              }),
        } 
    },
//------- methods class ---------------------------
    methods: {
        
        getResults(page = 1) {
			axios.get('/api/business?page=' + page)
				.then(response => {
					this.businesses = response.data;
                })
                .catch(errors => {
                    console.log(errors)
                });
        },
       
        loadBusinesses(){
          axios.get("/api/business").then(({data}) => (this.businesses = data));
                       
           /* Vue.axios.get("/api/business").then((res) => {
                                            this.businesses = res.data;
                                           // console.log(res.data);
                                        })
                                        .catch(errors => {
                                            console.log(errors)
                                        }); */
        },
        loadCountries(){
            axios.get("/api/getCountries").then(({data}) => (this.countries = data));
        },
        
        
//==========================================================================
        deleteBusiness(id){
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
                                    this.form.delete('/api/business/'+id).then(() => {
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
            this.CompanyLogo = e.target.files[0];
        },
       
        selectFile(e){
            let file = e.target.files[0];
           // console.log(this.file);
            let reader = new FileReader();
            if(file['size'] < 2111775){
                reader.onloadend = (file) => {
                    this.form.CompanyLogo = reader.result;
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
        createBusiness(){
            this.$Progress.start();
            this.form.post('/api/business')
            .then((() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Business Created in successfully'
                    })
                this.$Progress.finish();
            }))
            .catch(() => {
                this.$Progress.fail();
            });           
        },
        updateBusiness(){
            this.form.put('/api/business')           
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
        viewBusinessModal(business){
                this.addmode = false;
                this.editmode = false;
                this.viewmode = true;

                $("#businessForm :input").prop("disabled", true);
                $("#closebtn").attr("disabled",false);
                this.form.reset();
                this.loadCountries();
                $('#addNew').modal('show');
                this.form.fill(business);
        },
        editBusinessModal(business){
            $("#businessForm :input").prop("disabled", false);
            $("#closebtn").attr("disabled",false);
            this.addmode = false;
            this.editmode = true;
            this.viewmode = false;
           
            this.form.reset();
            this.loadCountries();
            $('#addNew').modal('show');
            this.form.fill(business);
        },
        newBusinessModal(){
            
            $("#businessForm :input").prop("disabled", false);
            $("#closebtn").attr("disabled",false);
            this.addmode = true;
            this.editmode = false;
            this.viewmode = false;
            
            this.form.reset();
            this.loadCountries();
            $('#addNew').modal('show');
        },
       
    },
//------- created class initialized component---------------------------
// 1-create users.vue in components folder
// 2-register route path in app.js    
    created(){
        this.loadBusinesses();
        //this.setFieldset(false);
        Fire.$on('searching',() => {
            let query = this.$parent.search;
            axios.get('/api/findBusiness?q=' + query)
            .then((data) => {
                this.businesses = data.data
            })
            .catch(() => {

            })
        }); 
        this.$Progress.start();
        this.loadBusinesses();
        this.loadCountries();
        toast.fire({
            type: 'success',
            title: 'Businesses loaded successfully'
            });
        this.$Progress.finish();
        Fire.$on('AfterCreate',() => {
               this.loadBusinesses();
           }); 
       // console.log('Component mounted..')
       
    },
    mounted(){
        this.addmode = true;
        this.editmode = true;
        this.viewmode = true
    }

}
</script>       