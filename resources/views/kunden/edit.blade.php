@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('errorAppointment'))
                <script>
                    toastr.success('{{ session('errorAppointment') }}', {timeOut:5000})
                </script>
            @endif
            @if ($errors->any())
                @foreach($errors->all() as $error)
                    <script>
                        toastr.error('{{$error}}', {timeOut:50000})
                    </script>
                @endforeach
            @endif
            <form method="post" id="edit-kunden-form" action="{{ route('update.kunden', $kunden->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input required type="text"  name="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ $kunden->first_name }}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="plz">PLZ</label>
                            <input required type="text"  name="plz" class="form-control{{ $errors->has('plz') ? ' is-invalid' : '' }} plz" value="{{ $kunden->plz }}">
                            @if ($errors->has('plz'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('plz') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="mapview">
                                <div class="pac-card" id="pac-card">
                                    <div>
                                        <div id="type-selector" class="pac-controls">
                                            <input type="hidden" name="type" id="onlyaddress" checked>
                                        </div>
                                    </div>
                                </div>

                                <div id="map"></div>
                                <div id="infowindow-content">
                                    <img src="" width="16" height="16" id="place-icon">
                                    <span id="place-name"  class="title"></span><br>
                                    <span id="place-address"></span>
                                </div>
                            </div>
                            <div class="mb-3"></div>
                            <input type="hidden" value="{{$kunden->lat}}" id="lat" name="lat">
                            <input type="hidden" value="{{$kunden->lng}}" id="lng" name="lng">
                            <label for="adresse">Adresse</label>
                            <input required name="adresse" id="autocomplete" placeholder="Enter your address" type="text" class="form-control{{ $errors->has('adresse') ? ' is-invalid' : '' }}" value="{{ $kunden->address }}">
                            @if ($errors->has('adresse'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('adresse') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="berater">Berater</label>
                            <select required name="berater" id="berater" class="form-control{{ $errors->has('berater') ? ' is-invalid' : '' }}" >
                                <option value="">Select Berater</option>
                                @foreach($beraters as $berater)
                                    <option value="{{ $berater->id }}" @if($berater->id == $kunden->berater_id) selected @endif >{{ $berater->first_name }} {{ $berater->last_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('berater'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('berater') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="basic_insurance_model">Basic Insurance Model</label>
                            <select name="basic_insurance_model" id="basic_insurance_model" class="form-control{{ $errors->has('basic_insurance_model') ? ' is-invalid' : '' }} ">
                                <option value="">Select Basic Insurance Model</option>
                                @foreach($basic_insurance_models as $basic_insurance_model)
                                    @if($basic_insurance_model->company_id == $kunden->company_id)
                                        <option value="{{ $basic_insurance_model->id }}" @if($basic_insurance_model->id == $kunden->basic_insurance_model_id) selected @endif >{{ $basic_insurance_model->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('basic_insurance_model'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('basic_insurance_model') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="franchise">Franchise</label>
                            <select name="franchise" id="franchise" class="form-control{{ $errors->has('franchise') ? ' is-invalid' : '' }} dynamicFranchise">
                                <option value="">Select Franchise</option>
                                @foreach($franchises as $franchise)
                                    <option value="{{ $franchise->id }}" @if($franchise->id == $kunden->franchise_id) selected @endif>{{ $franchise->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('franchise'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('franchise') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="basic_insurance_start_date">Basic Insurance Start Date</label>
                            <input type="text" id="datepicker" name="basic_insurance_start_date" autocomplete="off" class="form-control{{ $errors->has('basic_insurance_start_date') ? ' is-invalid' : '' }}" value="{{ $kunden->basic_insurance_start_date }}">
                            @if ($errors->has('basic_insurance_start_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('basic_insurance_start_date') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="hospitals">Hospitals</label>
                            <select name="hospitals" id="hospitals" class="form-control{{ $errors->has('hospitals') ? ' is-invalid' : '' }}" >
                                <option value="">Select Hospital</option>
                                @foreach($hospitals as $hospital)
                                    @if($hospital->company_id == $kunden->company_id)
                                        <option value="{{ $hospital->id }}" @if($hospital->id == $kunden->hospital_id) selected @endif >{{ $hospital->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('hospitals'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('hospitals') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="alternative_medicals">Alternative Medicals</label>
                            <select name="alternative_medicals" id="alternative_medicals" class="form-control{{ $errors->has('alternative_medicals') ? ' is-invalid' : '' }}" >
                                <option value="">Select Alternative Medical</option>
                                @foreach($alternative_medicals as $alternative_medical)
                                    @if($alternative_medical->company_id == $kunden->company_id)
                                        <option value="{{ $alternative_medical->id }}" @if($alternative_medical->id == $kunden->alternative_medical_id) selected @endif >{{ $alternative_medical->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('alternative_medicals'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('alternative_medicals') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="accident">Accident</label>
                            <input type="text"  name="accident" class="form-control{{ $errors->has('accident') ? ' is-invalid' : '' }} accident" value="{{ $kunden->accident }}">
                            @if ($errors->has('accident'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('accident') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="taggeld">Taggeld</label>
                            <input type="text"  name="taggeld" class="form-control{{ $errors->has('taggeld') ? ' is-invalid' : '' }} taggeld" value="{{ $kunden->taggeld }}">
                            @if ($errors->has('taggeld'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('taggeld') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }} mt-5">
                            <input type="checkbox" name="legal" id="legal" @if($kunden->legal != null) checked @endif>
                            <label for="legal">Legal</label>
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="product_type">Product Type</label>
                            <select name="product_type" id="product_type" class="form-control{{ $errors->has('product_type') ? ' is-invalid' : '' }}" >
                                <option value="">Select Product</option>
                                @foreach($product_types as $product_type)
                                    @if($product_type->company_id == $kunden->company_id)
                                        <option value="{{ $product_type->id }}" @if($product_type->id == $kunden->product_type_id) selected @endif >{{ $product_type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('product_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_type') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="duration">Duration</label>
                            <input type="text"  name="duration" class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }} duration" value="{{ $kunden->duration }}">
                            @if ($errors->has('duration'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('duration') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="monthly_premium">Monthly Premium</label>
                            <input type="text"  name="monthly_premium" class="form-control{{ $errors->has('monthly_premium') ? ' is-invalid' : '' }} monthly_premium" value="{{ $kunden->monthly_premium }}">
                            @if ($errors->has('monthly_premium'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('monthly_premium') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group generali-fields {{ ($kunden->company_id == 12) ? '' : 'hidden-field' }}">
                            <label for="occupation">Ocupations</label>
                            <input type="text"  name="occupation" class="form-control{{ $errors->has('occupation') ? ' is-invalid' : '' }} occupation" value="{{ $kunden->occupation }}">
                            @if ($errors->has('occupation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('occupation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="value">Value</label>
                            <input type="text"  name="value" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }} value" value="{{ $kunden->value }}">
                            @if ($errors->has('value'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('value') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="payment">Payment</label>
                            <select name="payment" id="payment" class="form-control{{ $errors->has('payment') ? ' is-invalid' : '' }}" >
                                <option value="">Select</option>
                                @foreach($payments as $payment)
                                    <option value="{{ $payment->id }}" @if($payment->id == $kunden->payment_id) selected @endif>{{ $payment->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="contract_signed_on">Contract Signed On</label>
                            <input type="text" id="contract_signed_on" name="contract_signed_on" autocomplete="off" class="form-control{{ $errors->has('contract_signed_on') ? ' is-invalid' : '' }}" value="{{ $kunden->contract_signed_on }}">
                            @if ($errors->has('contract_signed_on'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contract_signed_on') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>
                    </div>







                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input required type="text"  name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ $kunden->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="ort">Ort</label>
                            <input required type="text"  name="ort" class="form-control{{ $errors->has('ort') ? ' is-invalid' : '' }}" value="{{ $kunden->ort }}">
                            @if ($errors->has('ort'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('ort') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <label for="telefon">Telefon</label>
                            <input required type="text"  name="telefon" class="form-control{{ $errors->has('telefon') ? ' is-invalid' : '' }} telefon" value="{{ $kunden->telefon }}">
                            @if ($errors->has('telefon'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('telefon') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <label for="client_source">Client Source</label>
                            <select required name="client_source" id="client_source" class="form-control{{ $errors->has('client_source') ? ' is-invalid' : '' }}" >
                                <option value="">Select Client Source</option>
                                @foreach($client_sources as $client_source)
                                    <option value="{{ $client_source->id }}" @if($client_source->id == $kunden->client_source_id) selected @endif>{{ $client_source->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('client_source'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('client_source') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mt-5">
                            <label for="types_of_contract">Types of Contract</label>
                            <select required name="types_of_contract" id="types_of_contract" class="form-control{{ $errors->has('types_of_contract') ? ' is-invalid' : '' }} dynamic">
                                <option value="">Select Types of Contract</option>
                                @foreach($types_of_contracts as $types_of_contract)
                                    <option value="{{ $types_of_contract->id }}" @if($types_of_contract->id == $kunden->types_of_contract_id) selected @endif>{{ $types_of_contract->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('types_of_contract'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('types_of_contract') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="company">Company</label>
                            <select name="company" id="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }} dynamicCompany">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    @if($company->types_of_contract_id == $kunden->types_of_contract_id)
                                        <option value="{{ $company->id }}" @if($company->id == $kunden->company_id) selected @endif >{{ $company->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }} mt-5">
                            <input type="checkbox" name="accident_cover" id="accident_cover" class="" @if($kunden->accident_cover != null) checked @endif>
                            <label for="accident_cover">Accident Cover</label>
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }} mt-4">
                            <label for="franchise_details">Franchise details</label>
                            <select name="franchise_details" id="franchise_details" class="form-control{{ $errors->has('franchise_details') ? ' is-invalid' : '' }}" >
                                <option value="">Select Franchise Details</option>
                                @foreach($franchise_details as $franchise_detail)
                                    @if($franchise_detail->franchise_id == $kunden->franchise_id)
                                        <option value="{{ $franchise_detail->id }}" @if($franchise_detail->id == $kunden->franchise_details_id) selected @endif >{{ $franchise_detail->amount }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('franchise_details'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('franchise_details') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="inpatient">Inpatient</label>
                            <select name="inpatient" id="inpatient" class="form-control{{ $errors->has('inpatient') ? ' is-invalid' : '' }}">
                                <option value="">Select Inpatient</option>
                                @foreach($inpatients as $inpatient)
                                    @if($inpatient->company_id == $kunden->company_id)
                                        <option value="{{ $inpatient->id }}" @if($inpatient->id == $kunden->inpatients_id) selected @endif >{{ $inpatient->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('inpatient'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('inpatient') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="dentals">Dentals</label>
                            <select name="dentals" id="dentals" class="form-control{{ $errors->has('dentals') ? ' is-invalid' : '' }}" >
                                <option value="">Select Dentals</option>
                                @foreach($dentals as $dental)
                                    @if($dental->company_id == $kunden->company_id)
                                        <option value="{{ $dental->id }}" @if($dental->id == $kunden->dental_id) selected @endif >{{ $dental->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('dentals'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dentals') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="combi">Combi</label>
                            <input type="text" name="combi" class="form-control{{ $errors->has('combi') ? ' is-invalid' : '' }} combi" value="{{ $kunden->combi }}">
                            @if ($errors->has('combi'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('combi') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="death">Death</label>
                            <input type="text"  name="death" class="form-control{{ $errors->has('death') ? ' is-invalid' : '' }} death" value="{{ $kunden->death }}">
                            @if ($errors->has('death'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('death') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group kk-fields {{ ($kunden->types_of_contract_id == 1) ? '' : 'hidden-field' }}">
                            <label for="other">Other</label>
                            <input type="text"  name="other" class="form-control{{ $errors->has('other') ? ' is-invalid' : '' }} other" value="{{ $kunden->other }}">
                            @if ($errors->has('other'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('other') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="insurance_commencement_date">Insurance Commencement Date</label>
                            <input type="text" id="insurance_commencement_date" name="insurance_commencement_date" autocomplete="off" class="form-control{{ $errors->has('insurance_commencement_date') ? ' is-invalid' : '' }}" value="{{ $kunden->insurance_commencement_date }}">
                            @if ($errors->has('insurance_commencement_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('insurance_commencement_date') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="yearly_premium">Yearly Premium</label>
                            <input type="text"  name="yearly_premium" class="form-control{{ $errors->has('yearly_premium') ? ' is-invalid' : '' }} yearly_premium" value="{{ $kunden->yearly_premium }}">
                            @if ($errors->has('yearly_premium'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('yearly_premium') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="redeemable">Redeemable</label>
                            <input type="text" id="redeemable" name="redeemable" autocomplete="off" class="form-control{{ $errors->has('redeemable') ? ' is-invalid' : '' }}" value="{{ $kunden->redeemable }}">
                            @if ($errors->has('redeemable'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('redeemable') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group generali-fields {{ ($kunden->company_id == 12) ? '' : 'hidden-field' }}">
                            <label for="smoker">Smoker</label>
                            <input type="text" name="smoker" class="form-control{{ $errors->has('smoker') ? ' is-invalid' : '' }} smoker" value="{{ $kunden->smoker }}">
                            @if ($errors->has('smoker'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('smoker') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="options">Options</label>
                            <select name="options" id="options" class="form-control{{ $errors->has('options') ? ' is-invalid' : '' }} " >
                                <option value="">Select Option</option>
                                @foreach($options as $option)
                                    @if($option->company_id == $kunden->company_id)
                                        <option value="{{ $option->id }}" @if($option->id == $kunden->options_id) selected @endif >{{ $option->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('options'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('options') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group lv-fields {{ ($kunden->types_of_contract_id == 2) ? '' : 'hidden-field' }}">
                            <label for="payment_type">Payment Type</label>
                            <select name="payment_type" id="payment_type" class="form-control{{ $errors->has('payment_type') ? ' is-invalid' : '' }}" >
                                <option value="">Select</option>
                                @foreach($payment_types as $payment_type)
                                    <option value="{{ $payment_type->id }}" @if($payment_type->id == $kunden->payment_type_id) selected @endif>{{ $payment_type->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment_type') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12 appointmentbuttons">
                        <a href="{{ route('kunden.index') }}" class="btn btn-danger px-5 mr-2"><b>Abbrechen</b></a>
                        <button type="submit" id="submit" class="btn btn-outline-danger px-5"><b>Speichern</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
        });
        }, false);
    })();




    $(document).ready(function(){
        $('.telefon').mask('000 000 00 00');
        $('.plz').mask('0000');
    // Select Date ---- Date Picker ----
        var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            $('#datepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate: today,
                // minYear: parseInt(moment().format('YYYY')),
                // maxYear: parseInt(moment().format('YYYY'))+10,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            $('#contract_signed_on').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate:today,
                // minYear: parseInt(moment().format('YYYY')),
                // maxYear: parseInt(moment().format('YYYY'))+10,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            $('#insurance_commencement_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate:today,
                // minYear: parseInt(moment().format('YYYY')),
                // maxYear: parseInt(moment().format('YYYY'))+10,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            $('#redeemable').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate:today,
                // minYear: parseInt(moment().format('YYYY')),
                // maxYear: parseInt(moment().format('YYYY'))+10,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });// End Select Date ---- Date Picker ----

    $('.dynamic').change( function() {
        if($(this).val() != ''){
            var select = $(this).attr('id');
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('select.company') }}",
                method: "POST",
                data: {
                    select:select,
                    value:value,
                    _token:_token,
                },
                success: function(result) {
                    $('#company').html(result);
                },

            })
        } else {
            $('#company').find('option').remove().end().append('<option value=""></option>')
        }
    });

    $('.dynamicFranchise').change( function() {
        if($(this).val() != ''){
            var select = $(this).attr('id');
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('select.franchise.details') }}",
                method: "POST",
                data: {
                    select:select,
                    value:value,
                    _token:_token,
                },
                success: function(result) {
                    $('#franchise_details').html(result);
                },

            })
        } else {
            $('#franchise_details').find('option').remove().end().append('<option value=""></option>')
        }
    });

    $('.dynamicCompany').change( function() {
        if($(this).val() != ''){
            var select = $(this).attr('id');
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('select.inputs.from.companies') }}",
                method: "POST",
                data: {
                    select:select,
                    value:value,
                    _token:_token,
                },
                dataType: 'json',
                success: function(response) {
                    $('#basic_insurance_model').html(response[0]);
                    $('#hospitals').html(response[1]);
                    $('#alternative_medicals').html(response[2]);
                    $('#inpatient').html(response[3]);
                    $('#dentals').html(response[4]);

                    $('#product_type').html(response[5]);
                    $('#options').html(response[6]);
                },
                error: function (xhr) {
                    console.log(xhr);
                }

            })
        } else {
            $('#basic_insurance_model').find('option').remove().end().append('<option value=""></option>')
            $('#hospitals').find('option').remove().end().append('<option value=""></option>')
            $('#alternative_medicals').find('option').remove().end().append('<option value=""></option>')
            $('#inpatient').find('option').remove().end().append('<option value=""></option>')
            $('#dentals').find('option').remove().end().append('<option value=""></option>')

            $('#product_type').find('option').remove().end().append('<option value=""></option>')
            $('#options').find('option').remove().end().append('<option value=""></option>')
        }
    });

    $('#types_of_contract').change( function() {
        if($(this).val() == '1'){
            $('div.kk-fields').removeClass('hidden-field');
            $('div.lv-fields').addClass('hidden-field');
        } else if($(this).val() == '2') {
            $('div.kk-fields').addClass('hidden-field');
            $('div.lv-fields').removeClass('hidden-field');
        }else {
            $('div.kk-fields').addClass('hidden-field');
            $('div.lv-fields').addClass('hidden-field');
        }
    });

    $('#company').change( function() {
        if($(this).val() == '12'){
            $('div.generali-fields').removeClass('hidden-field');
        } else {
            $('div.generali-fields').addClass('hidden-field');
        }
    });

    // ================ Google maps API ====================
    function initMap() {
        var myLatLng = {lat: <?php echo $kunden->lat; ?>, lng: <?php echo $kunden->lng; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: <?php echo $kunden->lat; ?>, lng: <?php echo $kunden->lng; ?>},
          zoom: 15
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('autocomplete');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var options = {
            componentRestrictions: {country: "ch"}
        };
        var autocomplete = new google.maps.places.Autocomplete(input,options);


        autocomplete.bindTo('bounds', map);

        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {

                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var circle_centre=map.getCenter();
            var lat = circle_centre.lat();
            var lng = circle_centre.lng();
            $('#lat').val(lat);
            $('#lng').val(lng);

            var address = '';
            if (place.address_components) {
                address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
        });

        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }
        setupClickListener('onlyaddress', ['address']);
    } //================ Google maps API ====================

@hasrole('Agent Team Leader|Agent|Berater Team Leader|Berater|Broker Direktor')
$(document).ready(function () {
    $('input').attr('readonly', true)
    $('select').attr('readonly', true)
    $('input[type=checkbox]').attr('disabled', true);
    $('textarea').attr('readonly', true)
    $('button[type=submit]').remove()
});
@endhasrole

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsZV9n7YkwIEi1eQ54aFWURcQYhAjQkfA&libraries=places&callback=initMap"
        async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
@endsection
