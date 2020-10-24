<style scope>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
        height: 250px !important;
    }
    .widget-user .card-footer{
        padding: 0;
    }
    .img-circle {
        border-radius: 50%;
    }

    .widget-user .widget-user-image {
    position: absolute;
    top: 65px;
    left: 50%;
    margin-left: -45px;
    }

    .card-widget {
    border: none;
    position: relative;
    }

    .widget-user .widget-user-header {
        padding: 1rem;
        height: 120px;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    .widget-user .widget-user-username {
    margin-top: 0;
    margin-bottom: 5px;
    font-size: 25px;
    font-weight: 300;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }

    .widget-user .widget-user-desc {
    margin-top: 0;
    }

    .widget-user .widget-user-image {
    position: absolute;
    top: 65px;
    left: 50%;
    margin-left: -45px;
    }

    .widget-user .widget-user-image > img {
    width: 150px;
    height: auto;
    border: 3px solid #ffffff;
    }

    .widget-user .card-footer {
    padding-top: 40px;
    }

    .widget-user-2 .widget-user-header {
    padding: 1rem;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    }

    .widget-user-2 .widget-user-username {
    margin-top: 5px;
    margin-bottom: 5px;
    font-size: 25px;
    font-weight: 300;
    }

    .widget-user-2 .widget-user-desc {
    margin-top: 0;
    }

    .widget-user-2 .widget-user-username,
    .widget-user-2 .widget-user-desc {
    margin-left: 75px;
    }

    .widget-user-2 .widget-user-image > img {
    width: 65px;
    height: auto;
    float: left;
    }
    .text-center::before{
        content:"";
        margin-left:calc(100% - 75%);
    } 

</style>
<template>
    <div class="container">
        <!-- <h5 class="widget-user-desc">{{welcome}}</h5> -->
        <h5> {{$t('offenderprofile')}}: {{ offender.FirstName }}  {{ offender.LastName }}, ID: {{ offender.id }} </h5>
        <!-- <H4>{{ this.offender.FirstName }} , {{ this.offender.LastName }}, ID: {{ this.offender.id }} </h4> -->
        <div class="row">
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="width: 928px; height: 280px; background-image:url('/images/frame/offender-frame-333.jpg')">
                    <h3 class="widget-user-username">{{this.offender.FirstName}}</h3>
                    <h5 class="widget-user-desc">{{this.offender.LastName}}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" :src="getProfilePhoto()" alt="Offender Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 borderight">
                            <div class="description-block text-center">
                                <div v-if="cases_no">
                                    <h5 class="description-header">{{cases_no}}</h5>
                                    <span class="description-text">({{$t('case​s')}})</span>
                                </div>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block text-center">
                            <h5 class="description-header">{{this.offender.FirstName}} {{this.offender.LastName}}</h5>
                            <span class="description-text">({{$t('name')}})</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block text-center">
                            <h5 class="description-header">{{this.offender.Nationality}}</h5>
                            <span class="description-text">({{$t('nationality')}})</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <hr>
                    <div class="row">
                        <div class="col-sm-4 borderight">
                            <div class="description-block text-center">
                                <h6 class="description-header">{{this.offender.Age}}</h6>
                                <span class="description-text">({{ $t('age') }})</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block text-center">
                            <h6 class="description-header">{{this.offender.IDCardNumber}}</h6>
                            <span class="description-text">({{ $t('idcard') }})</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block text-center">
                            <h6 class="description-header">{{this.offender.Occupation}}</h6>
                            <span class="description-text">({{ $t('occupation') }})</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    <!-- /.col -->
                    </div>
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show green" href="#case" data-toggle="tab">{{$t('case​s')}}</a></li>
                        <li class="nav-item"><a class="nav-link green"  href="#business" data-toggle="tab">{{$t('bussiness')}}</a></li>
                        <li class="nav-item"><a class="nav-link green"  href="#network" data-toggle="tab">{{$t('network')}}</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Case Tab -->
                            <div class="tab-pane active show" id="case">
                                <!-- <h3 class="text-center">Related Cases List</h3> -->
                                <div class="row">
                                    <div class="col-6">
                                        <ul>
                                            <li v-for="item in cases" :key="item.id">
                                                <h6><u><b>{{$t('id')}}: {{item.id}}</b></u></h6>
                                                <h6>{{$t('detecteddate')}}: {{item.DetectedDate}}</h6>
                                                <h6>{{$t('type')}}: {{getStrType(item.Type)}} </h6>
                                                <h6>{{$t('itemnuber')}}: {{item.ItemNumber}} {{getStrUnit(item.Unit)}}</h6>
                                                <h6>{{$t('amount')}}: {{item.Amount}}</h6>
                                                <h6>{{$t('casedescription')}}: {{item.CaseDescription}}</h6>
                                                <!-- <h6>{{$t('photoevidence')}}: {{item.Evidence}}</h6> -->
                                                <h6>{{$t('location')}}: {{getStrLocation(item.Location)}}</h6>
                                                <h6>{{$t('status')}}: {{getStrStatus(item.Status)}}</h6>
                                                <!-- <div class="col-12"> -->
                                                <h6>{{ $t('participantname') }} 1: {{item.Participant1}}; &nbsp; {{ $t('participantname') }} 2: {{item.Participant2}} </h6>
                                                <h6>{{ $t('participantname') }} 3: {{item.Participant3}}; &nbsp; {{ $t('participantname') }} 4: {{item.Participant4}} </h6>
                                                <h6>{{ $t('participantname') }} 5: {{item.Participant5}}; &nbsp; {{ $t('participantname') }} 6: {{item.Participant6}} </h6>
                                                <!-- </div>                                                 -->
                                                <hr>                                               
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul>
                                            <li v-for="item in cases" :key="item.id">
                                                <h6>{{ $t('operation') }}</h6>
                                                <h6>
                                                    <a href="#" v-if="$gate.isAdminOrDofi()">
                                                        <!-- <i v-tooltip="editcasetooltip" class="fa fa-edit green" @click="editCaseModal(item)"></i> -->
                                                        <button v-tooltip="editcasetooltip" class="btn btn-success btn-sm" @click="editCaseModal(item)">{{ $t('edit') }}<i class="fas fa-edit green"></i></button>
                                                        <button v-tooltip="deletecasetooltip" class="btn btn-danger btn-sm" @click="deleteCase(item)">{{ $t('delete') }}<i class="fas fa-edit green"></i></button>
                                                    </a>
                                                </h6>
                                                <h6>&nbsp;</h6>
                                                <!-- <h6>&nbsp;</h6> -->
                                                <h6> {{ $t('photoevidence')}}: </h6>
                                                <div class="widget-user-image">
                                                    <img class="img-thumbnail mt-3" :src="getEvidencePhoto(item.Evidence)" style="width:300px; height:200px" alt="Evidence Avatar">
                                                </div>                                                
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <!-- Network Tab -->
                            <div class="tab-pane" id="network">
                                <!-- <h3 class="text-center">Display relate offender Network</h3> -->
                                <div class="row">
                                    <div class="col-6">
                                        <ul>
                                            <li v-for="item in network" :key="item.id">
                                                <h6><u><b>{{$t('id')}}: {{item.id}}</b></u></h6>
                                                <h6>{{$t('mobname')}}: {{item.MobName}}</h6>
                                                <!-- <h5>Network Type: {{getStrType(item.Type)}} </h5> -->
                                                <h6>{{$t('membernumber')}}: {{item.MemberNumber}}</h6>
                                                <h6>{{$t('networkactivity')}}: {{item.NetworkActivity}}</h6>
                                                <h6>{{$t('address')}}: {{item.MainAddress}}</h6>
                                                <h6>{{$t('crimelevel')}}: {{item.CrimeLevel}}</h6>
                                                <!-- <h5>Country: {{getStrLocation(item.Country)}}</h5>
                                                <h5>Status: {{getStrStatus(item.Status)}}</h5> -->
                                                <hr>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul>
                                            <li v-for="item in network" :key="item.id">
                                                <p> {{$t('moblogo')}} </p>
                                                <div class="widget-user-image">
                                                    <img class="img-circle mt-3" :src="getCompanyLogo(item.MobLogo)" style="width:200px; height:180px" alt="Offender Avatar">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Business Tab -->
                            
                            <div class="tab-pane" id="business">
                                <div class="row">
                                    <div class="col-6">
                                        <ul>
                                            <li v-for="item in business" :key="item.id">
                                                <h6><u><b>ID: {{item.id}}</b></u></h6>
                                                <h6>{{$t('companyname')}}: {{item.CompanyName}}</h6>
                                                <!-- <h5>Type: {{getStrType(item.Type)}} </h5> -->
                                                <h6>{{$t('owner')}}: {{item.Owner}}</h6>
                                                <h6>{{$t('activity')}}: {{item.Activity}}</h6>
                                                <h6>{{$t('address')}}: {{item.Address}}</h6>
                                                <h6>{{$t('country')}}: {{item.Country}}</h6>
                                                <h6>{{$t('phone')}}: {{item.Phone}}</h6>
                                                <h6>{{$t('email')}}: {{item.Email}}</h6>
                                                <h6>{{$t('latitude')}}: {{item.latitude}}</h6>
                                                <h6>{{$t('longtitude')}}: {{item.longtitude}}</h6>
                                                <h6>{{$t('socialnetwork')}}: {{item.SocialNetwork}}</h6>
                                                <hr>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul>
                                            <li v-for="item in business" :key="item.id">
                                                <p> {{$t('companylogo')}} </p>
                                                <div class="widget-user-image">
                                                    <img class="img-circle mt-3" :src="getCompanyLogo(item.CompanyLogo)" style="width:200px; height:180px" alt="Offender Avatar">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          </div>
          <!-- end tabs -->
        </div>
         <div class="modal fade" id="editCaseModal" tabindex="-1" role="dialog" aria-labelledby="editCaseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCaseModalLabel">{{$t('editcase')}}: {{formcase.id}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateCaseForm()" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="offender_id">{{$t('offenderid')}}:</label>
                                    <input v-model="formcase.offender_id" type="text" name="offender_id" readonly
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('offender_id') }">
                                    <has-error :form="formcase" field="offender_id"></has-error>
                                </div>
                            
                                <div class="form-group col-4">
                                    <label for="DetectedDate">{{$t('detecteddate')}}:</label>
                                    <input v-model="formcase.DetectedDate" type="date" name="DetectedDate"
                                    placeholder="Detected Date"
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('DetectedDate') }">
                                    <has-error :form="formcase" field="DetectedDate"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Type">{{$t('type')}}:</label>
                                    <select v-if="types" name="Type" v-model="formcase.Type" id="Type" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Type') }">
                                        <option value="">Select Case Type</option>
                                        <option v-for="type in types" :key="type.id" :value='type.id'>{{ type.TypeEng }}</option>
                                    </select>
                                    <has-error :form="formcase" field="DetectedDate"></has-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="ItemNumber">{{$t('itemnuber')}}:</label>
                                    <input v-model="formcase.ItemNumber" type="​text" name="ItemNumber"
                                        placeholder="Items Number..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('ItemNumber') }">
                                    <has-error :form="formcase" field="ItemNumber"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Unit">{{$t('unit')}}:</label>
                                    <select v-if="units" name="Unit" v-model="formcase.Unit" id="Unit" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Unit') }">
                                        <option value="">Select Case Unit</option>
                                        <option v-for="unit in units" :key="unit.id" :value='unit.id'>{{ unit.UnitEng }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Amount">{{$t('amount')}}:</label>
                                    <input v-model="formcase.Amount" type="text" name="Amount"
                                        placeholder="Case Amount value..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Amount') }">
                                    <has-error :form="formcase" field="Amount"></has-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="CaseDescription">{{$t('casedescription')}}:</label>
                                    <textarea v-model="formcase.CaseDescription" name="CaseDescription" id="CaseDescription"
                                        placeholder="Breif CaseDescription ...."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('CaseDescription') }"></textarea>
                                    <has-error :form="formcase" field="CaseDescription"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Location">{{$t('location')}}:</label>
                                    <select v-if="locations" name="Location" v-model="formcase.Location" id="Location" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Location') }">
                                        <option value="">Select Location</option>
                                        <option v-for='province in locations' :value='province.id' :key='province.id'>{{ province.NameEng }}</option>
                                    </select>
                                    <has-error :form="formcase" field="Location"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Status">{{$t('status')}}:</label>
                                    <select v-if="statuses" name="Status" v-model="formcase.Status" id="Status" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Status') }">
                                        <option value="">Select Status</option>
                                        <option v-for="status in statuses" :key="status.id" :value='status.id'>{{ status.StatusEng }}</option>
                                    </select>                                                                                                                       
                                    <has-error :form="formcase" field="Status"></has-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <div class="file-field">
                                        <div class="btn btn-success btn-md float-left">
                                            <img :src="'/storage/images/' + formcase.Evidence" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                            <span>{{$t('photoevidence')}}: </span><input type="file" name="Evidence" id="Evidence" @change="selectPicture($event)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="Participant1">{{$t('participantname')}} 1:</label>
                                    <input v-model="formcase.Participant1" type="text" name="Participant1"
                                        placeholder="Name of praticipant..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant1') }">
                                    <has-error :form="formcase" field="Participant1"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Participant2">{{$t('participantname')}} 2:</label>
                                    <input v-model="formcase.Participant2" type="text" name="Participant2"
                                        placeholder="Name of praticipant..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant2') }">
                                    <has-error :form="formcase" field="Participant2"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Participant3">{{$t('participantname')}} 3:</label>
                                    <input v-model="formcase.Participant3" type="text" name="Participant3"
                                        placeholder="Name of praticipant..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant3') }">
                                    <has-error :form="formcase" field="Participant3"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Participant4">{{$t('participantname')}} 4:</label>
                                    <input v-model="formcase.Participant4" type="text" name="Participant4"
                                        placeholder="Name of praticipant..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant4') }">
                                    <has-error :form="formcase" field="Participant4"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Participant5">{{$t('participantname')}} 5:</label>
                                    <input v-model="formcase.Participant5" type="text" name="Participant5"
                                        placeholder="Name of praticipant..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant5') }">
                                    <has-error :form="formcase" field="Participant5"></has-error>
                                </div>
                                <div class="form-group col-4">
                                    <label for="Participant6">{{$t('participantname')}} 6:</label>
                                    <input v-model="formcase.Participant6" type="text" name="Participant6"
                                        placeholder="Name of praticipant..."
                                        class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant6') }">
                                    <has-error :form="formcase" field="Participant6"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{$t('close')}}</button>
                            <button type="submit" class="btn btn-primary">{{$t('update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
         </div>
        <!-- Modal -->
    </div>
</template>
<script>
const axios = require('axios')
const $ = require('jquery')
    export default {
        props: ['msg','offender'],
        data(){
            return {
                welcome: 'None first',
                editcasetooltip: 'Edit Case',
                deletecasetooltip: 'Delete Case',
                bid: '',
                nid: '',
                types: null,
                units: null,
                cases: null,
               // cases_no: null,
                statuses: null,
                locations: null,
                totalcases: 0,
                network: {},
                business: {},
                case: {},
                formcase: new Form ({
                    id: '',
                    offender_id: '',
                    DetectedDate: '',
                    Type: '',
                    ItemNumber: '',
                    Unit: '',
                    Amount: '',
                    CaseDescription: '',
                    Evidence: '',
                    Status: '',
                    Location: '',
                    Participant1: '',
                    Participant2: '',
                    Participant3: '',
                    Participant4: '',
                    Participant5: '',
                    Participant6: '',
                    User_id: '',
                    Action: ''
                }),      
            }
        },
        computed: {
            cases_no () {
                if(this.cases){
                    return this.cases.length;
                }
            },
        },

        methods:{
            getStrType(id){
                if(this.types){
                    return this.types[id-1].TypeEng;
                }
            },
            getStrUnit(id){
                if(this.units){
                    return this.units[id-1].UnitEng;
                }
            },
            getStrStatus(id){
                if(this.statuses){
                    return this.statuses[id-1].StatusEng;
                }
            },
            getStrLocation(id){
                if(this.provinces){
                    return this.locations[id-1].NameEng;
                }
            },
            getCases(offender_id){
                axios.get("/api/getCases", {
                    params: {
                        offender_id: offender_id
                    },
                    }).then(function(response){
                        this.cases = response.data;
                        console.log(this.cases);
                    }.bind(this));
            },
            getNetworks(network_id){
                axios.get("/api/getNetworks/" + network_id) 
                    .then(function(response){
                        this.network = response.data;
                        console.log(this.network);
                    }.bind(this));
                /* axios.get("api/getNetworks", {
                    params: {
                        nid: network_id
                    },
                    }).then(function(response){
                        this.network = response.data;
                        console.log(this.network);
                    }.bind(this)); */
            },
            getBusinesses(business_id){
                axios.get("/api/getBusinesses/" + business_id)
                    .then(function(response){
                        this.business = response.data;
                        console.log(this.business);
                    }.bind(this));
                /* axios.get("api/getBusinesses", {
                    params: {
                        bid: business_id
                    },
                    }).then(function(response){
                        this.business = response.data;
                        console.log(this.business);
                    }.bind(this)); */
            },
            getCaseTypes(){
                axios.get("/api/getCaseTypes").then(({data}) => (this.types = data));
            },
            getUnits(){
                axios.get("/api/getUnits").then(({data}) => (this.units = data));
            },
            getStatus(){
                axios.get("/api/getCaseStatus").then(({data}) => (this.statuses = data));
            },
            getLocation(){
                axios.get("/api/getProvinces").then(({data}) => (this.locations = data));
            },
            getProfilePhoto(){
                let photo = (this.offender.Photo.length > 200) ? this.offender.Photo : "/storage/images/"+ this.offender.Photo ;
                return photo; 
            },
            getCompanyLogo(picture){
                let logo = (picture.length > 200) ? picture : "/storage/images/"+ picture ;
                return logo; 
            },
            getEvidencePhoto(picture){
                let photo = (picture.length > 200) ? picture : "/storage/images/"+ picture ;
                return photo; 
            },
            editCaseModal(item){
              //alert('Doing later...');
               $('#editCaseModal').modal('show');
               this.formcase.fill(item);
               
            },
            selectPicture(e){
                let file = e.target.files[0];
            // console.log(this.file);
                let reader = new FileReader();
                if(file['size'] < 2111775){
                    reader.onloadend = (file) => {
                        this.formcase.Evidence = reader.result;
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
            deleteCase(id){
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
                            this.form.delete('/api/mcase/'+id).then(() => {
                                swal.fire(
                                'Deleted!',
                                'The case has been deleted.',
                                'success'
                                )
                            Fire.$emit('AfterCreate');
                            }).catch(() => {
                                swal('Failed','Something wrong', 'warning');
                            });
                        }
                    })
                },
            updateCaseForm(){
                this.formcase.put('/api/mcase')           
                    .then(() => {
                            // success
                            $('#editCaseModal').modal('hide');
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
          //--------------------------------- old stuff --------------------------------
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(()=>{
                     Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
                    return false;
                }

                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },

        created() {
            this.cases = this.getCases(this.offender.id);
            this.network = this.getNetworks(this.offender.MainNetwork);
            this.business = this.getBusinesses(this.offender.MainBusiness);
            this.getCaseTypes();
            this.getUnits();
            this.getStatus();
            this.getLocation();
        },
        mounted() {
            // this.cases = this.getCases(this.offender.id);
            // this.network = this.getNetworks(this.offender.MainNetwork);
            // this.business = this.getBusinesses(this.offender.MainBusiness);
            // this.getCaseTypes();
            // this.getUnits();
            // this.getStatus();
            // this.getLocation();
            // if (this.msg) {
            //     this.welcome = this.msg;
            //     this.offender1 = this.offender;
              //  this.offender1 = this.offender;
               // this.getCases(this.offender.id);
                //this.todo = JSON.parse(JSON.stringify(this.populateWith))
               // this.form.fill(JSON.parse(JSON.stringify(this.offender))); 
              // this.offender = {};   
              // this.form.fill(this.offender);
           // }
            //console.log('Offender Profile Detail Component mounted...')
        }
    }
</script>
