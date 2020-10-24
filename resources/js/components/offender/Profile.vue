<template>
    <div :key="componentKey" class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrDofiOrPofi()">
            <div class="form-group col-5-sm"></div>
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
                                            <button v-tooltip="addtooltip" class="btn btn-success btn-md ml-5 mt-1" @click="newModal()">{{ $t('addoffender') }}<i class="fas fa-user-plus fa-fw"></i></button>          
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
                                    <!-- <th>{{ $t('created') }}</th> -->
                                    <th>{{ $t('operation') }}</th>
                                </tr>
                                <tr v-for="offender in offenders.data" v-bind:key="offender.id">
                                <!-- <tr v-for="(offender, index) in offenders.data" :key="`${componentKey}-${index}`"> -->
                                    <td>{{offender.id}}</td>
                                    <td>                                        
                                        <a href="#">
                                            <img :src="'/storage/images/' + offender.Photo" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                        </a>
                                    </td>
                                    <td>{{offender.FirstName | upText}}</td>
                                    <td>{{offender.LastName | upText}}</td>
                                    <td>{{offender.Age}}</td>
                                    <td>{{offender.Gender}}</td>
                                    <!-- <td>{{offender.created_at | myDate}}</td> -->
                                    <td>
                                        <a href="#">
                                            <!-- <i v-tooltip="viewtooltip" class="fa fa-eye blue" @click="viewModal(offender)"></i> -->
                                            <button v-tooltip="viewtooltip" class="btn btn-info btn-sm" @click="viewModal(offender)">{{ $t('view') }}<i class="fas fa-user-plus fa-fw"></i></button>   
                                        </a>
                                        <a href="#" v-if="$gate.isAdminOrDofi()">
                                            <!-- <i v-tooltip="edittooltip" class="fa fa-edit green" @click="editModal(offender)"></i> -->
                                            <button v-tooltip="edittooltip" class="btn btn-success btn-sm" @click="editModal(offender)">{{ $t('edit') }}<i class="fas fa-user-plus fa-fw"></i></button>  
                                        </a>
                                        <a href="#" v-if="$gate.isAdminOrDofi()">
                                            <!-- <i v-tooltip="deletetooltip" class="fa fa-trash red" @click="deleteOffender(offender.id)"></i> -->
                                            <button v-tooltip="deletetooltip" class="btn btn-danger btn-sm" @click="deleteOffender(offender.id)">{{ $t('delete') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                        </a>
                                        ----->
                                        <a href="#">
                                            <!-- <i v-tooltip="addcasetooltip" class="fa fa-user-secret" @click="addCaseModal(offender.id)"></i> -->
                                            <button v-tooltip="addcasetooltip" class="btn btn-primary btn-sm" @click="addCaseModal(offender.id)">{{ $t('addcase') }}<i class="fas fa-user-plus fa-fw"></i></button>
                                        </a>
                                        <!-- <a href="#">
                                            <i v-tooltip="editcasetooltip" class="fa fa-edit green" @click="editCaseModal(offender.id)"></i>
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
<!-- Modal Offender form----------------------------------------------- -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{ $t('addoffender') }}</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{ $t('updateoffender') }}</h5> -->
                        <h5 class="modal-title" v-show="addmode" id="addNewLabel">{{ $t('addoffender') }}</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{ $t('updateoffender') }}</h5>
                        <h5 class="modal-title" v-show="viewmode" id="addNewLabel">{{ $t('viewoffender') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <!--    <form @submit.prevent="editmode ? updateOffender() : createOffender()"> -->
                <!-- <form @submit.prevent="editmode ? updateOffender() : createOffender()" enctype="multipart/form-data"> -->
                <!-- <form @submit.prevent="editmode ? updateOffender() : formSubmit" enctype="multipart/form-data"> -->
                <form id="offenderForm" @submit.prevent="editmode ? updateOffender() : createOffender()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label for="FirstName">{{ $t('firstname') }} :</label>
                                <input v-model="form.FirstName" type="text" name="FirstName"
                                    placeholder="First Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('FirstName') }">
                                <has-error :form="form" field="FirstName"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="LastName">{{ $t('lastname') }} :</label>
                                <input v-model="form.LastName" type="text" name="LastName"
                                    placeholder="Last Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('LastName') }">
                                <has-error :form="form" field="LastName"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Gender1">{{ $t('gender') }} :</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="form.Gender" class="form-check-input" type="radio" name="Gender" id="Gender1" value="M">
                                        <label class="form-check-label" for="Gender1">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="form.Gender" class="form-check-input" type="radio" name="Gender" id="Gender2" value="F">
                                        <label class="form-check-label" for="Gender2">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label for="Age">{{ $t('age') }} :</label>
                                <input v-model="form.Age" type="number" name="Age"
                                    placeholder="Age..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('Age') }">
                                <has-error :form="form" field="Age"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="IDCardNumber">{{ $t('idcard') }} :</label>
                                <input v-model="form.IDCardNumber" type="text" name="IDCardNumber"
                                    placeholder="ID card no ...."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('IDCardNumber') }">
                                <has-error :form="form" field="IDCardNumber"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Occupation">{{ $t('occupation') }} :</label>
                                <input v-model="form.Occupation" type="text" name="Occupation"
                                    placeholder="Breif Occupation..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('Occupation') }">
                                <has-error :form="form" field="Occupation"></has-error>
                            </div>
                        </div>
                        <div class="form-row">  
                            <div class="form-group col-4">
                                <label for="Nationality">{{ $t('nationality') }} :</label>
                                <select name="Nationality" v-model="form.Nationality" id="Nationality" class="form-control" :class="{ 'is-invalid': form.errors.has('Nationality') }">
                                    <option value="">Select Nationality</option>
                                    <option v-for="nationality in nationalities" :key="nationality.id">{{ nationality.NationEng }}</option>
                                </select>                                                                                                                       
                                <has-error :form="form" field="Nationality"></has-error>
                            </div>
                            <div class="form-group col-8">
                                <label for="Address">{{ $t('address') }} :</label>
                                <textarea v-model="form.Address" name="Address" id="Address"
                                placeholder="Current Address ...."
                                class="form-control" :class="{ 'is-invalid': form.errors.has('Address') }"></textarea>
                                <has-error :form="form" field="Address"></has-error>
                            </div>
                        </div>

                        <div class="form-row">  
                            <div class="form-group col-4"> 
                                <label for="Province">{{ $t('province') }} :</label>
                                <select name="Province" v-model="form.Province" id="Province" @change='getDistricts(form.Province)' class="form-control" :class="{ 'is-invalid': form.errors.has('Province') }">
                                    <option value="">Select Province</option>
                                    <option v-for='province in provinces' :value='province.id' :key='province.id'>{{ province.NameEng }}</option>
                                </select>
                                <has-error :form="form" field="Province"></has-error>
                            </div>
                            <div class="form-group" col-4>
                                <label for="District">{{ $t('district') }} :</label>
                                <select name="District" v-model="form.District" v-bind='district.id' @change='getVillages(form.District)' id="District" class="form-control" :class="{ 'is-invalid': form.errors.has('District') }">
                                    <option value="">Select District</option>
                                    <option v-for="district in districts" :value="district.districtID" :key="district.districtID">{{ district.DistrictName }}</option>
                                </select>
                                <has-error :form="form" field="District"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Village">{{ $t('village') }} :</label>
                                <select name="Village" v-model="form.Village" id="Village" class="form-control" :class="{ 'is-invalid': form.errors.has('Village') }">
                                    <option value="">Select Village</option>
                                    <option v-for="village in villages" :value="village.id" :key="village.id">{{ village.NameEng }}</option>
                                </select>
                                <has-error :form="form" field="Village"></has-error>
                            </div>                            
                        </div>

                        <div class="form-row">  
                            <div class="form-group col-4">
                                <label for="Business">{{ $t('bussiness') }} :</label>
                                <select name="MainBusiness" v-model="form.MainBusiness" id="MainBusiness" class="form-control" :class="{ 'is-invalid': form.errors.has('MainBusiness') }">
                                    <option value="">Select MainBusiness</option>
                                    <option v-for="business in businesses" :key="business.id" :value='business.id'>{{ business.CompanyName }}</option>
                                </select>
                                <has-error :form="form" field="MainBusiness"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Network">{{ $t('network') }} :</label>
                                <select name="MainNetwork" v-model="form.MainNetwork" id="MainNetwork" class="form-control" :class="{ 'is-invalid': form.errors.has('MainNetwork') }">
                                    <option value="">Select Main Network</option>
                                    <option v-for="network in networks" :key="network.id" :value='network.id'>{{ network.MobName }}</option>
                                </select>
                                <has-error :form="form" field="MainNetwork"></has-error>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <div class="file-field">
                                <div class="btn btn-success btn-md float-left">
                                    <img :src="'/storage/images/' + form.Photo" style="width: 50px; height: 50px" class='img-thumbnail'/>
                                    <!-- <a target='_blank' href=" + "{{URL::to('/storage/images/'}}" + html.data.Photo +">" +  "<img src={{URL::to('/storage')}}/images/" + html.data.Photo + " width='70px' class='img-thumbnail'/> -->
                                    <span>{{ $t('photo') }} : </span><input type="file" name="Photo" id="Photo" @change="selectFile($event)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebtn" type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('close') }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('update') }}</button>
                        <button v-show="!editmode && !viewmode" type="submit" class="btn btn-primary">{{ $t('create') }}</button>
                    </div>

                </form>

                </div>
            </div>
        </div>
<!-- Modal Case form ---------------------------------------------------------------------  -->
        <div class="modal fade" id="addNewCase" tabindex="-1" role="dialog" aria-labelledby="addNewCaseLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewCaseLabel">{{ $t('addnewcase') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <form @submit.prevent="addNewCase()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label for="offender_id">{{ $t('offenderid') }} :</label>
                                <input v-model="formcase.offender_id" type="text" name="offender_id" readonly
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('offender_id') }">
                                <has-error :form="formcase" field="offender_id"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="DetectedDate">{{ $t('detecteddate') }} :</label>
                                <input v-model="formcase.DetectedDate" type="date" name="DetectedDate"
                                    placeholder="Detected Date"
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('DetectedDate') }">
                                <has-error :form="formcase" field="DetectedDate"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Type">{{ $t('casetype') }} :</label>
                                <select name="Type" v-model="formcase.Type" id="Type" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Type') }">
                                    <option value="">Select Case Type</option>
                                    <option v-for="type in types" :key="type.id" :value='type.id'>{{ type.TypeEng }}</option>
                                </select>
                                <has-error :form="formcase" field="DetectedDate"></has-error>
                            </div>
                        </div>
                        <div class="form-row">    
                            <div class="form-group col-4">
                                <label for="ItemNumber">{{ $t('itemnuber') }} :</label>
                                <input v-model="formcase.ItemNumber" type="text" name="ItemNumber"
                                    placeholder="Items Number..."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('ItemNumber') }">
                                <has-error :form="formcase" field="ItemNumber"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Unit">{{ $t('unit') }} :</label>
                                <select name="Unit" v-model="formcase.Unit" id="Unit" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Unit') }">
                                    <option value="">Select Case Unit</option>
                                    <option v-for="unit in units" :key="unit.id" :value='unit.id'>{{ unit.UnitEng }}</option>
                                </select>
                                <has-error :form="formcase" field="Unit"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Amount">{{ $t('amount') }} (kip):</label>
                                <input v-model="formcase.Amount" type="number" name="Amount"
                                    placeholder="Case Amount value..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('Amount') }">
                                <has-error :form="formcase" field="Amount"></has-error>
                            </div>
                        </div>
                        <div class="form-row">  
                            <div class="form-group col-4">
                                <label for="CaseDescription">{{ $t('casedescription') }} :</label>
                                <textarea v-model="formcase.CaseDescription" name="CaseDescription" id="CaseDescription"
                                placeholder="Case Description ...."
                                class="form-control" :class="{ 'is-invalid': formcase.errors.has('CaseDescription') }"></textarea>
                                <has-error :form="formcase" field="CaseDescription"></has-error>
                            </div>
                            
                            <div class="form-group col-4"> 
                                <label for="Location">{{ $t('location') }} :</label>
                                <select name="Location" v-model="formcase.Location" id="Location" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Location') }">
                                    <option value="">Select Location</option>
                                    <option v-for='province in provinces' :value='province.id' :key='province.id'>{{ province.NameEng }}</option>
                                </select>
                                <has-error :form="formcase" field="Location"></has-error>
                            </div>
                            
                            <div class="form-group col-4">
                                <label for="Status">{{ $t('casestatus') }} :</label>
                                <select name="Status" v-model="formcase.Status" id="Status" class="form-control" :class="{ 'is-invalid': formcase.errors.has('Status') }">
                                    <option value="">Select Status</option>
                                    <option v-for="status in statuses" :key="status.id" :value='status.id'>{{ status.StatusEng }}</option>
                                </select>                                                                                                                       
                                <has-error :form="formcase" field="Status"></has-error>
                            </div>
                        </div>
                        <div class="form-row">  
                            <div class="form-group col-6">
                                <label for="Evidence">{{ $t('photoevidence') }} :</label>
                                <div class="file-field">
                                    <div class="btn btn-success btn-md float-left">
                                        <!-- <img :src="'/storage/images/' + form.Photo" style="width: 50px; height: 50px" class='img-thumbnail'/> -->
                                        <!-- <a target='_blank' href=" + "{{URL::to('/storage/images/'}}" + html.data.Photo +">" +  "<img src={{URL::to('/storage')}}/images/" + html.data.Photo + " width='70px' class='img-thumbnail'/> -->
                                        <span>Evidence Photo: </span><input type="file" name="Evidence" id="Evidence" @change="selectPicture($event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="Participant1">{{ $t('participantname') }} 1:</label>
                                <input v-model="formcase.Participant1" type="text" name="Participant1"
                                    placeholder="Name of Participant 1 ...."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant1') }">
                                <has-error :form="formcase" field="Participant1"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Participant2">{{ $t('participantname') }} 2:</label>
                                <input v-model="formcase.Participant2" type="text" name="Participant2"
                                    placeholder="Name of Participant 2 ...."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant2') }">
                                <has-error :form="formcase" field="Participant2"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Participant3">{{ $t('participantname') }} 3:</label>
                                <input v-model="formcase.Participant3" type="text" name="Participant3"
                                    placeholder="Name of Participant 3 ...."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant3') }">
                                <has-error :form="formcase" field="Participant3"></has-error>
                            </div>
                        </div> 
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="Participant4">{{ $t('participantname') }} 4:</label>
                                <input v-model="formcase.Participant4" type="text" name="Participant4"
                                    placeholder="Name of Participant 4 ...."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant4') }">
                                <has-error :form="formcase" field="Participant4"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Participant5">{{ $t('participantname') }} 5:</label>
                                <input v-model="formcase.Participant5" type="text" name="Participant5"
                                    placeholder="Name of Participant 5 ...."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant5') }">
                                <has-error :form="formcase" field="Participant5"></has-error>
                            </div>
                            <div class="form-group col-4">
                                <label for="Participant6">{{ $t('participantname') }} 6:</label>
                                <input v-model="formcase.Participant6" type="text" name="Participant6"
                                    placeholder="Name of Participant 6 ...."
                                    class="form-control" :class="{ 'is-invalid': formcase.errors.has('Participant6') }">
                                <has-error :form="formcase" field="Participant6"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebtn" type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('close') }}</button>
                        <!-- <button type="submit" class="btn btn-primary">{{ $t('add') }}</button> -->
                        <!-- <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('update') }}</button> -->
                        <button type="submit" class="btn btn-primary">{{ $t('create') }}</button>

                        <!-- <button id="closebtn" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode && !viewmode" type="submit" class="btn btn-primary">Create</button> -->
                    </div>
                </form>
                </div>
            </div>
        </div><!-- modal case div -->
    </div>   <!-- container div -->
</template> 

<script>

import Form from 'vform'
const axios = require('axios')
const $ = require('jquery')
//const ability = require('~/plugins/defineAbility');
const gate = require('./Gate')
export default{
    data() {
        return {
            addtooltip: 'Add offender.',
            viewtooltip: 'View offender profile',
            edittooltip: 'Edit offender.',
            deletetooltip: 'Delete Offender.',
            addcasetooltip: 'Add new case.',
            editcasetooltip: 'Edit case...',
            addmode: true,
            editmode: true,
            viewmode: true,
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
            componentKey: 0,
             form: new Form ({
                    id: '',
                    FirstName: '',
                    LastName: '',
                    Gender: '',
                    Age: '',
                    IDCardNumber: '',
                    Occupation: '',
                    Nationality: '',
                    Address: '',
                    Province: '',
                    District: '',
                    Village: '',
                    MainBusiness: '',
                    MainNetwork: '',
                    Photo: '',
              }),
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
                    User_id: '',
                    Action: ''
                }),               
        } 
    },
//------- methods class ---------------------------
    methods: {
        forceRerender() {
            this.componentKey += 1;
            this.$forceUpdate();
            this.$parent.reload();
        },
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),
        getResults(page = 1) {
			axios.get('/api/offender?page=' + page)
				.then(response => {
					this.offenders = response.data;
				});
		},
        loadOffender(){
            axios.get("/api/offender").then(({data}) => (this.offenders = data));
            //console.log(this.offenders);
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
            axios.get("/api/getNetworks").then(({data}) => (this.networks = data));
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
        deleteOffender(id){
                swal.fire({
                            title: "Are you sure.. ທ່ານ​ແນ່​ໃຈ​ແທ້ ບໍ ?",
                            text: "You won't be able to revert this!​.. ທ່ານ​ຈະ​ບໍ່​ສາ​ມາດ​ເອົາ​ຄືນ​ໄດ້​ອີກ",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!... ລືບ​ໄດ້'
                            }).then((result) => {
                                if (result.value) {
                                    this.form.delete('/api/offender/'+id).then(() => {
                                        swal.fire(
                                        'Deleted!​..ລືບ​ແລ້ວ',
                                        'Your file has been deleted... ຟາຍ​ທ່ານ​ຖືກ​ລືບ​ອອກ​ແລ້ວ',
                                        'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                    }).catch(() => {
                                        swal('Failed','Something wrong.. ມີ​ການ​ຜິດ​ພາດ', 'warning');
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
            console.log(this.file);
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
        },
        selectPicture(e){
            let file = e.target.files[0];
            console.log(this.file);
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
//=================================  Add new cases on offender ===========================================
        addCaseModal(id){
            addtmode: true,
            this.formcase.reset();
            //this.offender_id = id;
            //console.log(this.offender_id);
            this.formcase.offender_id = id;
            //console.log(this.formcase.offender_id);
            this.getCaseTypes();
            this.getUnits();
            this.getCaseStatus();
            $('#addNewCase').modal('show');
        },
        addNewCase(){
            this.$Progress.start();
            this.formcase.post('/api/mcase/')
            .then(() => {
                Fire.$emit('AfterCreate');
                $('#addNewCase').modal('hide');
                toast({
                    type: 'success',
                    title: 'Case added successfully'
                    })
                this.$Progress.finish();
            })
            .catch(() => {
                $('#addNewCase').modal('hide');
                toast({
                    type: 'warning',
                    title: 'Case added failed...'
                    })
                this.$Progress.fail();
            });  
        },
        editCaseModal(id){
            alert('Please edit case in Find Offender deatil page..');
        },
//-------------------------------------create offender--------------------------------------------------------------------------
        createOffender(){
            this.$Progress.start();
            this.form.post('/api/offender')
            .then((() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
                toast({
                    type: 'success',
                    title: 'Offender Created in successfully'
                    })
                this.$Progress.finish();
            }))
            .catch(() => {
                this.$Progress.fail();
            });           
        },
        updateOffender(){
            this.form.put('/api/offender')           
            .then(() => {
                    
                    // success
                   // this.$parent.reload();
                   // this.$parent.refresh();
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                     swal(
                        'Updated!',
                        'Profile has been updated.',
                        'success'
                        )
                    this.$Progress.finish();
                    
            })
            .catch(() => {
                this.$Progress.fail();
            });
        },
        viewModal(offender){
            this.addmode = false;
            this.editmode = false;
            this.viewmode = true;

            $("#offenderForm :input").prop("disabled", true);
            $("#closebtn").attr("disabled",false);
            this.form.reset();
            this.loadNationalities();
            this.getProvinces();
            this.loadDistricts();
            this.loadVillages();
            this.loadBusinesses();
            this.loadNetworks();
            $('#addNew').modal('show');
            this.form.fill(offender);
        },
        editModal(offender){
            $("#offenderForm :input").prop("disabled", false);
            $("#closebtn").attr("disabled",false);
            this.addmode = false;
            this.editmode = true;
            this.viewmode = false;
            this.form.reset();
            this.loadNationalities();
            this.getProvinces();
            this.loadDistricts();
            this.loadVillages();
            this.loadBusinesses();
            this.loadNetworks();
            $('#addNew').modal('show');
            this.form.fill(offender);
        },
        newModal(){
            $("#offenderForm :input").prop("disabled", false);
            $("#closebtn").attr("disabled",false);
            this.addmode = true;
            this.editmode = false;
            this.viewmode = false;
            this.form.reset();
            this.loadNationalities();
            this.getProvinces();
            this.loadBusinesses();
            this.loadNetworks();
            $('#addNew').modal('show');
        },
        
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
               //location.reload();
               //this.$forceUpdate();
            //    this.$parent.reload();
            //    this.forceRerender();
               //alert("HEeee");
           });
       // console.log('Component mounted..')
       
    },
    mounted(){
       
    }

}
</script>
        