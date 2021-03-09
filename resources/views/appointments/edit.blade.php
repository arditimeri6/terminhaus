@extends('layouts.app')

@section('content')

<script src="{{ asset('js/location/de.js') }}"></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('errorAppointment'))
                <script>
                    toastr.success('{{ session('errorAppointment') }}', {timeOut:5000})
                </script>
            @endif
            @if ($errors->any())
                <script>
                    toastr.error('Please check again all fields and fill them', {timeOut:5000})
                </script>
            @endif
            <form method="post" id="appointment-form" action="{{ route('update.appointment', $appointment->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row mb-3">
                @hasrole('Administrator|Call Center Admin|Call Center Direktor|Agent Team Leader|Quality Controll|Agent')
                    <div class="col-md-12 mb-4 createdBy-paragraph">
                        <p></p>
                        <p>Created By: <span style="font-weight: bold;">{{$username->first_name}} {{$username->last_name}}</span></p>
                    </div>
                @endhasrole
                <div class="col-md-6">
                        <div class="mb-3">
                            <label for="salutation">Anrede</label>
                            <select required name="salutation" id="salutation" class="form-control{{ $errors->has('salutation') ? ' is-invalid' : '' }}">
                                <option value="">Anrede wählen</option>
                                <option value="Herr" @if($appointment->salutation == 'Herr') selected @endif >Herr</option>
                                <option value="Frau" @if($appointment->salutation == 'Frau') selected @endif >Frau</option>
                            </select>
                            @if ($errors->has('salutation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('salutation') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="first_name">Vorname</label>
                            <input required id="first_name" type="text" name="first_name" value="{{ $appointment->first_name }}" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="last_name">Nachname</label>
                            <input required type="text" name="last_name" value="{{ $appointment->last_name }}" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="language">Sprache</label>
                            <select required name="language" id="language" class="form-control{{ $errors->has('language') ? ' is-invalid' : '' }}">
                                <option value="">Sprache wählen</option>
                                <option value="DE" @if($appointment->language == 'DE') selected @endif >DE</option>
                                <option value="FR" @if($appointment->language == 'FR') selected @endif >FR</option>
                                <option value="IT" @if($appointment->language == 'IT') selected @endif >IT</option>
                                <option value="AL" @if($appointment->language == 'AL') selected @endif >AL</option>
                                <option value="ESP" @if($appointment->language == 'ESP') selected @endif >ESP</option>
                                <option value="SRB" @if($appointment->language == 'SRB') selected @endif >SRB</option>
                                <option value="TR" @if($appointment->language == 'TR') selected @endif >TR</option>
                                <option value="Other" @if($appointment->language == 'Other') selected @endif >Other</option>
                            </select>
                            @if ($errors->has('language'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('language') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>

                            @if($appointment->mobile_grant_access == 1)
                                <div class="mb-3">
                                    <label for="mobile_number">Mobile Nummer</label>
                                    @hasrole('Administrator|Call Center Admin')
                                        <div class="d-flex">
                                    @endhasrole
                                            <input type="text" name="mobile_number" value="{{ $appointment->mobile_number }}"
                                            class="form-control  {{ $errors->has('mobile_number') ? ' is-invalid' : '' }} mobile_number @hasrole('Administrator|Call Center Admin') w-75 @endhasrole ">
                                    @hasrole('Administrator|Call Center Admin')
                                            <div class="custom-control custom-checkbox under-checkbox">
                                                <input class="float-right ml-1 mt-2 pt-4 check custom-control-input" style="margin-top:11px !important;" type="checkbox" id="mobileGrantAccess" name="mobileGrantAccess" {{$appointment->mobile_grant_access ? 'checked' : ''}}>
                                                <label class="mt-1 pt-1 ml-4 custom-control-label checkbox-inline costumcheckbox1" for="mobileGrantAccess">Grant Access</label>
                                            </div>
                                        </div>
                                    @endhasrole
                                    @if ($errors->has('mobile_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobile_number') }}</strong>
                                        </span>
                                    @else
                                        <div class="invalid-feedback">
                                            <strong> Dieses Feld ist erforderlich </strong>
                                        </div>
                                    @endif
                                </div>
                            @else
                                @hasrole('Administrator|Call Center Admin')
                                    <div class="mb-3">
                                        <label for="mobile_number">Mobile Nummer</label>
                                        <div class="d-flex">
                                            <input type="text" name="mobile_number" value="{{ $appointment->mobile_number }}"  class="form-control w-75 {{ $errors->has('mobile_number') ? ' is-invalid' : '' }} mobile_number">
                                            <div class="custom-control custom-checkbox under-checkbox">
                                                <input class="float-right ml-1 mt-2 pt-4 check custom-control-input" style="margin-top:11px !important;" type="checkbox" id="mobileGrantAccess" name="mobileGrantAccess" {{$appointment->mobile_grant_access ? 'checked' : ''}}>
                                                <label class="mt-1 pt-1 ml-4 custom-control-label checkbox-inline costumcheckbox1" for="mobileGrantAccess">Grant Access</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('mobile_number'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                            </span>
                                        @else
                                            <div class="invalid-feedback">
                                                <strong> Dieses Feld ist erforderlich </strong>
                                            </div>
                                        @endif
                                    </div>
                                @endhasrole
                            @endif

                            @if($appointment->phone_grant_access == 1)
                                <div class="mb-3">
                                    <label for="phone_number">Haus Phone Nummer</label>
                                    @hasrole('Administrator|Call Center Admin')
                                        <div class="d-flex">
                                    @endhasrole
                                            <input type="text" name="phone_number" value="{{ $appointment->phone_number }}"
                                            class="form-control  {{ $errors->has('phone_number') ? ' is-invalid' : '' }} phone_number @hasrole('Administrator|Call Center Admin') w-75 @endhasrole">
                                    @hasrole('Administrator|Call Center Admin')
                                            <div class="custom-control custom-checkbox under-checkbox">
                                                <input  class="float-right ml-1 mt-2 pt-4 check custom-control-input" style="margin-top:11px !important;" type="checkbox" id="phoneGrantAccess" name="phoneGrantAccess" {{$appointment->phone_grant_access ? 'checked' : ''}}>
                                                <label class="mt-1 pt-1 ml-4 custom-control-label checkbox-inline costumcheckbox1" for="phoneGrantAccess">Grant Access</label>
                                            </div>
                                        </div>
                                    @endhasrole
                                    @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @else
                                        <div class="invalid-feedback">
                                            <strong> Dieses Feld ist erforderlich </strong>
                                        </div>
                                    @endif
                                </div>
                                @else
                                    @hasrole('Administrator|Call Center Admin')
                                        <div class="mb-3">
                                            <label for="phone_number">Haus Phone Nummer</label>
                                            <div class="d-flex">
                                                <input type="text" name="phone_number" value="{{ $appointment->phone_number }}" class="form-control w-75 {{ $errors->has('phone_number') ? ' is-invalid' : '' }} phone_number" >
                                                <div class="custom-control custom-checkbox under-checkbox">
                                                    <input  class="float-right ml-1 mt-2 pt-4 check custom-control-input" style="margin-top:11px !important;" type="checkbox" id="phoneGrantAccess" name="phoneGrantAccess" {{$appointment->phone_grant_access ? 'checked' : ''}}>
                                                    <label class="mt-1 pt-1 ml-4 custom-control-label checkbox-inline costumcheckbox1" for="phoneGrantAccess">Grant Access</label>
                                                </div>
                                            </div>
                                            @if ($errors->has('phone_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </span>
                                            @else
                                                <div class="invalid-feedback">
                                                    <strong> Dieses Feld ist erforderlich </strong>
                                                </div>
                                            @endif
                                        </div>
                                    @endhasrole
                            @endif
                        <div class="mb-1">
                            <label for="house_number">Haus Nummer</label>
                            <input required type="text" name="house_number" value="{{ $appointment->house_number }}" class="form-control{{ $errors->has('house_number') ? ' is-invalid' : '' }} house_number" autocomplete="off">
                            @if ($errors->has('house_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('house_number') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        @hasrole('Administrator|Call Center Admin|Quality Controll')
                            <div class="col mt-4 mb-4 custom-control custom-checkbox under-checkbox">
                                <input type="checkbox" class="check custom-control-input" id="photoAccessBr" name="photoAccessBr" {{$appointment->photo_access_br ? 'checked' : ''}}>
                                <label class="custom-control-label checkbox-inline costumcheckbox1" for="photoAccessBr" >Enable upload photos for Broker</label>
                            </div>
                        @endhasrole
                        @if(Auth::user()->hasRole('Administrator') || Auth::user()->country == 'Call Center' || Auth::user()->country == 'Broker' &&  $appointment->photo_access_br != 0)
                            <label for="file">Hochladen</label>
                            <input id="fileUpload" type="file"  name="file[]" accept="image/png, image/jpeg, audio/mp3" multiple class="file form-control{{ $errors->has('file.*') ? ' is-invalid' : '' }}" data-overwrite-initial="false" >
                            @if ($errors->has('file.*'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('file.*') }}</strong>
                                </span>
                            @endif
                        @endif
                        @hasrole('Administrator|Call Center Admin|Quality Controll')
                            <div class="col mt-4 custom-control custom-checkbox under-checkbox">
                                <input type="checkbox" class="check custom-control-input" id="commentAccessCC" name="commentAccessCC" {{$appointment->qccomment_access_cc ? 'checked' : ''}}>
                                <label class="custom-control-label checkbox-inline costumcheckbox1" for="commentAccessCC" >Enable comments for Call Center</label>
                            </div>
                            <div class="col mt-4 custom-control custom-checkbox under-checkbox">
                                <input type="checkbox" class="check custom-control-input" id="commentAccessBr" name="commentAccessBr" {{$appointment->qccomment_access_br ? 'checked' : ''}}>
                                <label class="custom-control-label checkbox-inline costumcheckbox1" for="commentAccessBr" >Enable comments for Broker</label>
                            </div>
                        @endhasrole
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
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
                            <input type="hidden" value="{{$appointment->lat}}" id="lat" name="lat">
                            <input type="hidden" value="{{$appointment->lng}}" id="lng" name="lng">
                            <label for="street">Strasse</label>
                            <input required name="street" id="autocomplete" placeholder="Enter your address" type="text" value="{{ $appointment->street }}"  class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}">
                            @if ($errors->has('street'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('street') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="post_code">Postleitzahl</label>
                            <input required type="number" name="post_code" value="{{ $appointment->post_code }}" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }} post_code" id="post_code">
                            @if ($errors->has('post_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('post_code') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2 mb-2">
                            <label for="canton">Kanton</label>
                            <select required name="canton" id="country" style="width:100% !important" class="form-control{{ $errors->has('canton') ? ' is-invalid' : '' }}">
                                <option value="">Select Canton</option>
                                <option value="Aargau" @if($appointment->canton == 'Aargau') selected @endif >Aargau</option>
                                <option value="Appenzell Ausserrhoden" @if($appointment->canton == 'Appenzell Ausserrhoden') selected @endif >Appenzell Ausserrhoden</option>
                                <option value="Appenzell Innerrhoden" @if($appointment->canton == 'Appenzell Innerrhoden') selected @endif >Appenzell Innerrhoden</option>
                                <option value="Basel-Stadt" @if($appointment->canton == 'Basel-Stadt') selected @endif >Basel-Stadt</option>
                                <option value="Basel-Landschaft" @if($appointment->canton == 'Basel-Landschaft') selected @endif >Basel-Landschaft</option>
                                <option value="Bern" @if($appointment->canton == 'Bern') selected @endif >Bern</option>
                                <option value="Fribourg" @if($appointment->canton == 'Fribourg') selected @endif >Fribourg</option>
                                <option value="Geneva" @if($appointment->canton == 'Geneva') selected @endif >Geneva</option>
                                <option value="Glarus" @if($appointment->canton == 'Glarus') selected @endif >Glarus</option>
                                <option value="Graubünden" @if($appointment->canton == 'Graubünden') selected @endif >Graubünden</option>
                                <option value="Jura" @if($appointment->canton == 'Jura') selected @endif >Jura</option>
                                <option value="Lucerne" @if($appointment->canton == 'Lucerne') selected @endif >Lucerne</option>
                                <option value="Neuchâtel" @if($appointment->canton == 'Neuchâtel') selected @endif >Neuchâtel</option>
                                <option value="Nidwalden" @if($appointment->canton == 'Nidwalden') selected @endif >Nidwalden</option>
                                <option value="Obwalden" @if($appointment->canton == 'Obwalden') selected @endif >Obwalden</option>
                                <option value="Schaffhausen" @if($appointment->canton == 'Schaffhausen') selected @endif >Schaffhausen</option>
                                <option value="Schwyz" @if($appointment->canton == 'Schwyz') selected @endif >Schwyz</option>
                                <option value="Solothurn" @if($appointment->canton == 'Solothurn') selected @endif >Solothurn</option>
                                <option value="St. Gallen" @if($appointment->canton == 'St. Gallen') selected @endif >St. Gallen</option>
                                <option value="Thurgau" @if($appointment->canton == 'Thurgau') selected @endif >Thurgau</option>
                                <option value="Ticino" @if($appointment->canton == 'Ticino') selected @endif >Ticino</option>
                                <option value="Uri" @if($appointment->canton == 'Uri') selected @endif >Uri</option>
                                <option value="Valais" @if($appointment->canton == 'Valais') selected @endif >Valais</option>
                                <option value="Vaud" @if($appointment->canton == 'Vaud') selected @endif >Vaud</option>
                                <option value="Zug" @if($appointment->canton == 'Zug') selected @endif >Zug</option>
                                <option value="Zürich" @if($appointment->canton == 'Zürich') selected @endif >Zürich</option>
                            </select>
                            @if ($errors->has('canton'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('canton') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="date">Termin Datum</label>
                            <input required type="text" id="selectDate" value="{{ date('d/m/Y', strtotime($appointment->date)) }}" name="date" autocomplete="off" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}">
                            @if ($errors->has('date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-1">
                            <label for="time">Termin Zeit</label>
                            <input required type="text" name="time" id="timepicker" value="{{ $appointment->time }}" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" autocomplete="off">
                            @if ($errors->has('time'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('time') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mt-3">
                            <label for="company">Krankenkassen</label>
                            <select name="company" id="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" required>
                                <option value="">Select Company</option>
                                <option value="CSS" @if($appointment->krankenkassen == "CSS") selected @endif >CSS</option>
                                <option value="Helsana" @if($appointment->krankenkassen == "Helsana") selected @endif >Helsana</option>
                                <option value="Swica" @if($appointment->krankenkassen == "Swica") selected @endif >Swica</option>
                                <option value="Concordia" @if($appointment->krankenkassen == "Concordia") selected @endif >Concordia</option>
                                <option value="Visana" @if($appointment->krankenkassen == "Visana") selected @endif >Visana</option>
                                <option value="Assura" @if($appointment->krankenkassen == "Assura") selected @endif >Assura</option>
                                <option value="Sanitas" @if($appointment->krankenkassen == "Sanitas") selected @endif >Sanitas</option>
                                <option value="Intras" @if($appointment->krankenkassen == "Intras") selected @endif >Intras</option>
                                <option value="Progres" @if($appointment->krankenkassen == "Progres") selected @endif >Progres</option>
                                <option value="KPT" @if($appointment->krankenkassen == "KPT") selected @endif >KPT</option>
                                <option value="Groupe Mutuel" @if($appointment->krankenkassen == "Groupe Mutuel") selected @endif >Groupe Mutuel</option>
                                <option value="Wincare" @if($appointment->krankenkassen == "Wincare") selected @endif >Wincare</option>
                                <option value="Atupri" @if($appointment->krankenkassen == "Atupri") selected @endif >Atupri</option>
                                <option value="EGK" @if($appointment->krankenkassen == "EGK") selected @endif >EGK</option>
                                <option value="Sympany" @if($appointment->krankenkassen == "Sympany") selected @endif >Sympany</option>
                                <option value="Sansan" @if($appointment->krankenkassen == "Sansan") selected @endif >Sansan</option>
                                <option value="Philos-Groupe Mutuel" @if($appointment->krankenkassen == "Philos-Groupe Mutuel") selected @endif >Philos-Groupe Mutuel</option>
                                <option value="Agrisano" @if($appointment->krankenkassen == "Agrisano") selected @endif >Agrisano</option>
                                <option value="Avenir-Groupe Mutuel" @if($appointment->krankenkassen == "Avenir-Groupe Mutuel") selected @endif >Avenir-Groupe Mutuel</option>
                                <option value="SKBH-Groupe Mutuel" @if($appointment->krankenkassen == "SKBH-Groupe Mutuel") selected @endif >SKBH-Groupe Mutuel</option>
                                <option value="Caisse-Groupe Mutuel" @if($appointment->krankenkassen == "Caisse-Groupe Mutuel") selected @endif >Caisse-Groupe Mutuel</option>
                                <option value="La Caisse Vaudoise-Groupe Mutuel" @if($appointment->krankenkassen == "La Caisse Vaudoise-Groupe Mutuel") selected @endif >La Caisse Vaudoise-Groupe Mutuel</option>
                                <option value="Avanex-Helsana" @if($appointment->krankenkassen == "Avanex-Helsana") selected @endif >Avanex-Helsana</option>
                                <option value="Hermes-Groupe Mutuel" @if($appointment->krankenkassen == "Hermes-Groupe Mutuel") selected @endif >Hermes-Groupe Mutuel</option>
                                <option value="Provita" @if($appointment->krankenkassen == "Provita") selected @endif >Provita</option>
                                <option value="Supra" @if($appointment->krankenkassen == "Supra") selected @endif >Supra</option>
                                <option value="Innova" @if($appointment->krankenkassen == "Innova") selected @endif >Innova</option>
                                <option value="Arcosana" @if($appointment->krankenkassen == "Arcosana") selected @endif >Arcosana</option>
                                <option value="Xundheit" @if($appointment->krankenkassen == "Xundheit") selected @endif >Xundheit</option>
                                <option value="Aerosana-Helsana" @if($appointment->krankenkassen == "Aerosana-Helsana") selected @endif >Aerosana-Helsana</option>
                                <option value="Kolping" @if($appointment->krankenkassen == "Kolping") selected @endif >Kolping</option>
                                <option value="Aquilana" @if($appointment->krankenkassen == "Aquilana") selected @endif >Aquilana</option>
                                <option value="Sumiswalder" @if($appointment->krankenkassen == "Sumiswalder") selected @endif >Sumiswalder</option>
                                <option value="Panorama-Groupe Mutuel" @if($appointment->krankenkassen == "Panorama-Groupe Mutuel") selected @endif >Panorama-Groupe Mutuel</option>
                                <option value="Carena" @if($appointment->krankenkassen == "Carena") selected @endif >Carena</option>
                                <option value="Auxilia" @if($appointment->krankenkassen == "Auxilia") selected @endif >Auxilia</option>
                                <option value="Easy Sana-Groupe Mutuel" @if($appointment->krankenkassen == "Easy Sana-Groupe Mutuel") selected @endif >Easy Sana-Groupe Mutuel</option>
                                <option value="KLuG" @if($appointment->krankenkassen == "KLuG") selected @endif >KLuG</option>
                                <option value="Luzerner Hinterland" @if($appointment->krankenkassen == "Luzerner Hinterland") selected @endif >Luzerner Hinterland</option>
                                <option value="Sodalis" @if($appointment->krankenkassen == "Sodalis") selected @endif >Sodalis</option>
                                <option value="SLKK" @if($appointment->krankenkassen == "SLKK") selected @endif >SLKK</option>
                                <option value="Galenos" @if($appointment->krankenkassen == "Galenos") selected @endif >Galenos</option>
                                <option value="Avantis-Groupe Mutuel" @if($appointment->krankenkassen == "Avantis-Groupe Mutuel") selected @endif >Avantis-Groupe Mutuel</option>
                                <option value="Rhenusana" @if($appointment->krankenkassen == "Rhenusana") selected @endif >Rhenusana</option>
                                <option value="KMU" @if($appointment->krankenkassen == "KMU") selected @endif >KMU</option>
                                <option value="Steffisburg" @if($appointment->krankenkassen == "Steffisburg") selected @endif >Steffisburg</option>
                                <option value="Cervino" @if($appointment->krankenkassen == "Cervino") selected @endif >Cervino</option>
                                <option value="Malters" @if($appointment->krankenkassen == "Malters") selected @endif >Malters</option>
                                <option value="Vita Surselva" @if($appointment->krankenkassen == "Vita Surselva") selected @endif >Vita Surselva</option>
                                <option value="Sana24" @if($appointment->krankenkassen == "Sana24") selected @endif >Sana24</option>
                                <option value="Birchmeier" @if($appointment->krankenkassen == "Birchmeier") selected @endif >Birchmeier</option>
                                <option value="SanaTop" @if($appointment->krankenkassen == "SanaTop") selected @endif >SanaTop</option>
                                <option value="Wdenswil" @if($appointment->krankenkassen == "Wdenswil") selected @endif >Wdenswil</option>
                                <option value="Publisana" @if($appointment->krankenkassen == "Publisana") selected @endif >Publisana</option>
                                <option value="Elm" @if($appointment->krankenkassen == "Elm") selected @endif >Elm</option>
                                <option value="Einsiedeln" @if($appointment->krankenkassen == "Einsiedeln") selected @endif >Einsiedeln</option>
                                <option value="Lumnezia" @if($appointment->krankenkassen == "Lumnezia") selected @endif >Lumnezia</option>
                            </select>
                            @if ($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="mt-4">
                            <label for="comment">Kommentar</label>
                            <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" name="comment" rows="5">{{ $appointment->comment }}</textarea>
                            @if ($errors->has('comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                            @endif
                        </div>
                        @hasrole('Administrator|Call Center Admin|Quality Controll')
                            <div class="mt-4 single-select-control">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Bestatigt auswahlen" @if($appointment->status == 'Bestatigt auswahlen') selected @endif >Bestatigt auswahlen</option>
                                    <option value="Bestatigt" @if($appointment->status == 'Bestatigt') selected @endif>Bestatigt</option>
                                    <option value="N. Bestatigt" @if($appointment->status == 'N. Bestatigt') selected @endif>N. Bestatigt</option>
                                    <option value="1h vorher Anrufen" @if($appointment->status == '1h vorher Anrufen') selected @endif>1h vorher Anrufen</option>
                                    <option value="Abgesagt" @if($appointment->status == 'Abgesagt') selected @endif>Abgesagt</option>
                                    <option value="Storno" @if($appointment->status == 'Storno') selected @endif>Storno</option>
                                </select>
                            </div>
                        @endhasrole
                    </div>

                </div>
                <div class="row mb-3">
                    @hasrole('Administrator|Quality Controll|Call Center Admin')
                        <div class="col-md-12 mt-2">
                            <label for="comment">Quality Controll Kommentar</label>
                            <textarea class="form-control{{ $errors->has('qcComment') ? ' is-invalid' : '' }}" name="qcComment" rows="3">{{ $appointment->qc_comment }}</textarea>
                            @if ($errors->has('qcComment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('qcComment') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col mt-4">
                            @foreach($multipeComments as $key => $multipeComment)
                                <div class="card card-style" id="{{$multipeComment->id}}">
                                <h5 class="card-header"><span class="text-left"><span class="qcComment-appointmentEdit"><i class="fas fa-comment-dots"></i>&nbsp;</span>&nbsp; {{$multipeComment->name}}&nbsp;{{$multipeComment->lastname}}</span> <span class="date-qcComent">{{Carbon\Carbon::parse($multipeComment->created_at)->diffForHumans()}} ({{Carbon\Carbon::parse($multipeComment->created_at)->format('d.m.Y H:i:s')}})</span> @hasrole('Administrator|Call Center Admin') <span class="float-right comment-buttons"> <button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-sm btn-outline-secondary delete-comment-button"><i class="far fa-trash-alt"></i></button></span>@endhasrole</h5>
                                    <div class="card-body">
                                    <p class="card-text comment"><span class="{{$multipeComment->id}}-comment">{{$multipeComment->comment}}<span></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endhasrole
                    @hasrole('Berater Admin|Broker Direktor|Berater Team Leader|Berater')
                        @if($appointment->qccomment_access_br == 1)
                            <div class="col mt-4">
                                @foreach($multipeComments as $key => $multipeComment)
                                    <div class="card card-style" id="{{$multipeComment->id}}">
                                    <h5 class="card-header"><span class="text-left"><span class="qcComment-appointmentEdit"><i class="fas fa-comment-dots"></i>&nbsp;</span>&nbsp; {{$multipeComment->name}}&nbsp;{{$multipeComment->lastname}}</span> <span class="date-qcComent">{{Carbon\Carbon::parse($multipeComment->created_at)->diffForHumans()}} ({{Carbon\Carbon::parse($multipeComment->created_at)->format('d.m.Y H:i:s')}})</span> @hasrole('Administrator|Call Center Admin') <span class="float-right comment-buttons"> <button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-sm btn-outline-secondary delete-comment-button"><i class="far fa-trash-alt"></i></button></span>@endhasrole</h5>
                                        <div class="card-body">
                                        <p class="card-text comment"><span class="{{$multipeComment->id}}-comment">{{$multipeComment->comment}}<span></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endhasrole
                    @hasrole('Call Center Direktor|Agent Team Leader|Agent')
                        @if($appointment->qccomment_access_cc == 1)
                            <div class="col mt-4">
                                @foreach($multipeComments as $key => $multipeComment)
                                    <div class="card card-style" id="{{$multipeComment->id}}">
                                    <h5 class="card-header"><span class="text-left"><span class="qcComment-appointmentEdit"><i class="fas fa-comment-dots"></i>&nbsp;</span>&nbsp; {{$multipeComment->name}}&nbsp;{{$multipeComment->lastname}}</span> <span class="date-qcComent">{{Carbon\Carbon::parse($multipeComment->created_at)->diffForHumans()}} ({{Carbon\Carbon::parse($multipeComment->created_at)->format('d.m.Y H:i:s')}})</span> @hasrole('Administrator|Call Center Admin') <span class="float-right comment-buttons"> <button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-sm btn-outline-secondary delete-comment-button"><i class="far fa-trash-alt"></i></button></span>@endhasrole</h5>
                                        <div class="card-body">
                                        <p class="card-text comment"><span class="{{$multipeComment->id}}-comment">{{$multipeComment->comment}}<span></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endhasrole
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Familienmitglieder</label>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Salutation</td>
                                    <td>Vorname</td>
                                    <td>Nachname</td>
                                    <td>Geburtsdatum</td>
                                    <td>Vertragslaufzeit bis</td>
                                    <td>Behandlung</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="inputs-row">
                                    <td>
                                        <select name="" id="salutation1" class="form-control">
                                            <option value="Herr">Herr</option>
                                            <option value="Frau">Frau</option>
                                            <option value="Kind">Kind</option>
                                            <option value="Schwiegertochter">Schwiegertochter</option>
                                            <option value="Neffe">Neffe</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="first-name" class="form-control">
                                    </td>
                                    <td>
                                        <select name="" id="krankenkassen1" class="form-control">
                                            <option value="" >Select Company</option>
                                            <option value="CSS" >CSS</option>
                                            <option value="Helsana" >Helsana</option>
                                            <option value="Swica" >Swica</option>
                                            <option value="Concordia" >Concordia</option>
                                            <option value="Visana" >Visana</option>
                                            <option value="Assura" >Assura</option>
                                            <option value="Sanitas" >Sanitas</option>
                                            <option value="Intras" >Intras</option>
                                            <option value="Progres" >Progres</option>
                                            <option value="KPT" >KPT</option>
                                            <option value="Groupe Mutuel" >Groupe Mutuel</option>
                                            <option value="Wincare" >Wincare</option>
                                            <option value="Atupri" >Atupri</option>
                                            <option value="EGK" >EGK</option>
                                            <option value="Sympany" >Sympany</option>
                                            <option value="Sansan" >Sansan</option>
                                            <option value="Philos-Groupe Mutuel" >Philos-Groupe Mutuel</option>
                                            <option value="Agrisano" >Agrisano</option>
                                            <option value="Avenir-Groupe Mutuel" >Avenir-Groupe Mutuel</option>
                                            <option value="SKBH-Groupe Mutuel" >SKBH-Groupe Mutuel</option>
                                            <option value="Caisse-Groupe Mutuel" >Caisse-Groupe Mutuel</option>
                                            <option value="La Caisse Vaudoise-Groupe Mutuel" >La Caisse Vaudoise-Groupe Mutuel</option>
                                            <option value="Avanex-Helsana"  >Avanex-Helsana</option>
                                            <option value="Hermes-Groupe Mutuel" >Hermes-Groupe Mutuel</option>
                                            <option value="Provita" >Provita</option>
                                            <option value="Supra" >Supra</option>
                                            <option value="Innova" >Innova</option>
                                            <option value="Arcosana" >Arcosana</option>
                                            <option value="Xundheit" >Xundheit</option>
                                            <option value="Aerosana-Helsana" >Aerosana-Helsana</option>
                                            <option value="Kolping" >Kolping</option>
                                            <option value="Aquilana" >Aquilana</option>
                                            <option value="Sumiswalder" >Sumiswalder</option>
                                            <option value="Panorama-Groupe Mutuel" >Panorama-Groupe Mutuel</option>
                                            <option value="Carena" >Carena</option>
                                            <option value="Auxilia" >Auxilia</option>
                                            <option value="Easy Sana-Groupe Mutuel" >Easy Sana-Groupe Mutuel</option>
                                            <option value="KLuG" >KLuG</option>
                                            <option value="Luzerner Hinterland" >Luzerner Hinterland</option>
                                            <option value="Sodalis" >Sodalis</option>
                                            <option value="SLKK" >SLKK</option>
                                            <option value="Galenos" >Galenos</option>
                                            <option value="Avantis-Groupe Mutuel" >Avantis-Groupe Mutuel</option>
                                            <option value="Rhenusana" >Rhenusana</option>
                                            <option value="KMU"  >KMU</option>
                                            <option value="Steffisburg" >Steffisburg</option>
                                            <option value="Cervino">Cervino</option>
                                            <option value="Malters" >Malters</option>
                                            <option value="Vita Surselva" >Vita Surselva</option>
                                            <option value="Sana24" >Sana24</option>
                                            <option value="Birchmeier" >Birchmeier</option>
                                            <option value="SanaTop" >SanaTop</option>
                                            <option value="Wdenswil" >Wdenswil</option>
                                            <option value="Publisana" >Publisana</option>
                                            <option value="Elm" >Elm</option>
                                            <option value="Einsiedeln" >Einsiedeln</option>
                                            <option value="Lumnezia" >Lumnezia</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="birth-year" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" id="contract-duration" class="form-control">
                                    </td>
                                    <td>
                                        <select name="" id="behandlung1" class="form-control">
                                            <option>Gesund</option>
                                            <option>Behandlung</option>
                                        </select>
                                    </td>
                                    @hasrole("Agent|Berater|Agent Team Leader|Berater Team Leader")
                                        <td style="text-align:center;">&nbsp;</td>
                                    @else
                                        <td style="text-align:center;"><a class="add"><i class="fas fa-plus fa-lg addplus mt-2"></i></a></td>
                                    @endhasrole
                                </tr>
                                @foreach($members as $member)
                                    <tr class="inputs-row">
                                        <td>
                                            <select name="member-salutation[]" id="salutation2" class="form-control">
                                                <option value="Herr" @if($member->salutation == "Herr") selected @endif >Herr</option>
                                                <option value="Frau" @if($member->salutation == "Frau") selected @endif >Frau</option>
                                                <option value="Kind" @if($member->salutation == "Kind") selected @endif >Kind</option>
                                                <option value="Schwiegertochter" @if($member->salutation == "Schwiegertochter") selected @endif >Schwiegertochter</option>
                                                <option value="Neffe" @if($member->salutation == "Neffe") selected @endif >Neffe</option>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="member-first-name[]" value="{{ $member->first_name }}" class="form-control">
                                        </td>
                                        <td>
                                            <select name="member-krankenkassen[]" id="krankenkassen2" class="form-control">
                                                <option value="">Select Company</option>
                                                <option value="CSS" @if($member->krankenkassen == "CSS") selected @endif >CSS</option>
                                                <option value="Helsana" @if($member->krankenkassen == "Helsana") selected @endif >Helsana</option>
                                                <option value="Swica" @if($member->krankenkassen == "Swica") selected @endif >Swica</option>
                                                <option value="Concordia" @if($member->krankenkassen == "Concordia") selected @endif >Concordia</option>
                                                <option value="Visana" @if($member->krankenkassen == "Visana") selected @endif >Visana</option>
                                                <option value="Assura" @if($member->krankenkassen == "Assura") selected @endif >Assura</option>
                                                <option value="Sanitas" @if($member->krankenkassen == "Sanitas") selected @endif >Sanitas</option>
                                                <option value="Intras" @if($member->krankenkassen == "Intras") selected @endif >Intras</option>
                                                <option value="Progres" @if($member->krankenkassen == "Progres") selected @endif >Progres</option>
                                                <option value="KPT" @if($member->krankenkassen == "KPT") selected @endif >KPT</option>
                                                <option value="Groupe Mutuel" @if($member->krankenkassen == "Groupe Mutuel") selected @endif >Groupe Mutuel</option>
                                                <option value="Wincare" @if($member->krankenkassen == "Wincare") selected @endif >Wincare</option>
                                                <option value="Atupri" @if($member->krankenkassen == "Atupri") selected @endif >Atupri</option>
                                                <option value="EGK" @if($member->krankenkassen == "EGK") selected @endif >EGK</option>
                                                <option value="Sympany" @if($member->krankenkassen == "Sympany") selected @endif >Sympany</option>
                                                <option value="Sansan" @if($member->krankenkassen == "Sansan") selected @endif >Sansan</option>
                                                <option value="Philos-Groupe Mutuel" @if($member->krankenkassen == "Philos-Groupe Mutuel") selected @endif >Philos-Groupe Mutuel</option>
                                                <option value="Agrisano" @if($member->krankenkassen == "Agrisano") selected @endif >Agrisano</option>
                                                <option value="Avenir-Groupe Mutuel" @if($member->krankenkassen == "Avenir-Groupe Mutuel") selected @endif >Avenir-Groupe Mutuel</option>
                                                <option value="SKBH-Groupe Mutuel" @if($member->krankenkassen == "SKBH-Groupe Mutuel") selected @endif >SKBH-Groupe Mutuel</option>
                                                <option value="Caisse-Groupe Mutuel" @if($member->krankenkassen == "Caisse-Groupe Mutuel") selected @endif >Caisse-Groupe Mutuel</option>
                                                <option value="La Caisse Vaudoise-Groupe Mutuel" @if($member->krankenkassen == "La Caisse Vaudoise-Groupe Mutuel") selected @endif >La Caisse Vaudoise-Groupe Mutuel</option>
                                                <option value="Avanex-Helsana" @if($member->krankenkassen == "Avanex-Helsana") selected @endif >Avanex-Helsana</option>
                                                <option value="Hermes-Groupe Mutuel" @if($member->krankenkassen == "Hermes-Groupe Mutuel") selected @endif >Hermes-Groupe Mutuel</option>
                                                <option value="Provita" @if($member->krankenkassen == "Provita") selected @endif >Provita</option>
                                                <option value="Supra" @if($member->krankenkassen == "Supra") selected @endif >Supra</option>
                                                <option value="Innova" @if($member->krankenkassen == "Innova") selected @endif >Innova</option>
                                                <option value="Arcosana" @if($member->krankenkassen == "Arcosana") selected @endif >Arcosana</option>
                                                <option value="Xundheit" @if($member->krankenkassen == "Xundheit") selected @endif >Xundheit</option>
                                                <option value="Aerosana-Helsana" @if($member->krankenkassen == "Aerosana-Helsana") selected @endif >Aerosana-Helsana</option>
                                                <option value="Kolping" @if($member->krankenkassen == "Kolping") selected @endif >Kolping</option>
                                                <option value="Aquilana" @if($member->krankenkassen == "Aquilana") selected @endif >Aquilana</option>
                                                <option value="Sumiswalder" @if($member->krankenkassen == "Sumiswalder") selected @endif >Sumiswalder</option>
                                                <option value="Panorama-Groupe Mutuel" @if($member->krankenkassen == "Panorama-Groupe Mutuel") selected @endif >Panorama-Groupe Mutuel</option>
                                                <option value="Carena" @if($member->krankenkassen == "Carena") selected @endif >Carena</option>
                                                <option value="Auxilia" @if($member->krankenkassen == "Auxilia") selected @endif >Auxilia</option>
                                                <option value="Easy Sana-Groupe Mutuel" @if($member->krankenkassen == "Easy Sana-Groupe Mutuel") selected @endif >Easy Sana-Groupe Mutuel</option>
                                                <option value="KLuG" @if($member->krankenkassen == "KLuG") selected @endif >KLuG</option>
                                                <option value="Luzerner Hinterland" @if($member->krankenkassen == "Luzerner Hinterland") selected @endif >Luzerner Hinterland</option>
                                                <option value="Sodalis" @if($member->krankenkassen == "Sodalis") selected @endif >Sodalis</option>
                                                <option value="SLKK" @if($member->krankenkassen == "SLKK") selected @endif >SLKK</option>
                                                <option value="Galenos" @if($member->krankenkassen == "Galenos") selected @endif >Galenos</option>
                                                <option value="Avantis-Groupe Mutuel" @if($member->krankenkassen == "Avantis-Groupe Mutuel") selected @endif >Avantis-Groupe Mutuel</option>
                                                <option value="Rhenusana" @if($member->krankenkassen == "Rhenusana") selected @endif >Rhenusana</option>
                                                <option value="KMU" @if($member->krankenkassen == "KMU") selected @endif >KMU</option>
                                                <option value="Steffisburg" @if($member->krankenkassen == "Steffisburg") selected @endif >Steffisburg</option>
                                                <option value="Cervino" @if($member->krankenkassen == "Cervino") selected @endif >Cervino</option>
                                                <option value="Malters" @if($member->krankenkassen == "Malters") selected @endif >Malters</option>
                                                <option value="Vita Surselva" @if($member->krankenkassen == "Vita Surselva") selected @endif >Vita Surselva</option>
                                                <option value="Sana24" @if($member->krankenkassen == "Sana24") selected @endif >Sana24</option>
                                                <option value="Birchmeier" @if($member->krankenkassen == "Birchmeier") selected @endif >Birchmeier</option>
                                                <option value="SanaTop" @if($member->krankenkassen == "SanaTop") selected @endif >SanaTop</option>
                                                <option value="Wdenswil" @if($member->krankenkassen == "Wdenswil") selected @endif >Wdenswil</option>
                                                <option value="Publisana" @if($member->krankenkassen == "Publisana") selected @endif >Publisana</option>
                                                <option value="Elm" @if($member->krankenkassen == "Elm") selected @endif >Elm</option>
                                                <option value="Einsiedeln" @if($member->krankenkassen == "Einsiedeln") selected @endif >Einsiedeln</option>
                                                <option value="Lumnezia" @if($member->krankenkassen == "Lumnezia") selected @endif >Lumnezia</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="member-birth-year[]" value="{{ $member->birth_year }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="member-contract-duration[]" value="{{ $member->contract_duration }}" class="form-control">
                                        </td>
                                        <td>
                                            <select name="member-behandlung[]" id="behandlung2" class="form-control">
                                                <option value="Gesund" @if($member->behandlung == "Gesund") selected @endif >Gesund</option>
                                                <option value="Behandlung" @if($member->behandlung == "Behandlung") selected @endif >Behandlung</option>
                                            </select>
                                        </td>
                                        @hasrole("Agent|Berater|Agent Team Leader|Berater Team Leader")
                                            <td style="text-align:center;">&nbsp;</td>
                                        @else
                                            <td style="text-align:center;"><a class="delete-row"><i class="fas fa-minus fa-lg addplus mt-2"></i></a></td>
                                        @endhasrole
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-12 appointmentbuttons">
                        <a href="{{ route('show.appointment') }}" class="btn btn-danger px-5 mr-2"><b>Abbrechen</b></a>
                            <button type="submit" id="submit" class="btn btn-outline-danger px-5"><b>Aktualisieren</b></button>
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
        $('body').on('click', '#showComments', function(){
            $('#showCommentModal').modal('show')
        });

        @hasrole('Agent Team Leader|Quality Controll|Agent|Berater|Agent Team Leader|Berater Team Leader')
            $(document).ready(function () {
                $('.mobile_number').prop('readonly', true)
                $('.phone_number').prop('readonly', true)
            });
        @endhasrole

        @hasrole("Agent|Berater|Berater Team Leader|Agent Team Leader")
            $(document).ready(function () {
                $('input, select, textarea').attr('readonly', true)
                $('input[type=checkbox]').attr('disabled', true);
                $('button[type=submit]').remove()
                $('select option').hide()
                $('#fileUpload').fileinput('cancel').fileinput('disable');
            });
        @endhasrole
        @hasrole("Quality Controll")
            $(document).ready(function () {
                $('select, input, textarea').attr('readonly', true)
                $('[name=first_name],[name=last_name],[name=street],[name=date],[name=time],.inputs-row td select,[name=status], .inputs-row td select,[name=qcComment]').attr('readonly', false)
                // $('select option').hide()
            });
        @endhasrole
        // @hasrole("Call Center Direktor")
        //     $(document).ready(function () {
        //         $('select').attr('readonly', true)
        //         $('textarea, input').attr('readonly', true)
        //         $('[name=first_name],[name=last_name],.inputs-row td input,.inputs-row td select ,[name=street] ').attr('readonly', false)
        //         $('select option').hide()
        //     });
        // @endhasrole
        // @hasrole('Broker Direktor')
        //     $(document).ready(function () {
        //         $('input, select, textarea').attr('readonly', true)
        //         $('select option').hide()
        //         $('.inputs-row input ,.inputs-row select').attr('readonly', false)
        //         $('.inputs-row select option').show()
        //         $('#fileUpload').fileinput('cancel').fileinput('disable');
        //         if($('.mobile_number').val() == ''){
        //             $('.mobile_number').attr('readonly', false)
        //         }
        //         else if($('.phone_number').val() == ''){
        //             $('.phone_number').attr('readonly', false)
        //         }
        //     })
        // @endhasrole

        $('.mobile_number').mask('000 000 00 00');
        $('.phone_number').mask('000 000 00 00');
        $('.post_code').mask('0000');
        $('.house_number').mask('AAAA', {'translation': {
                A: {pattern: /[A-Za-z0-9.\-\/]/},
            }
        });


       // Select Date ---- Date Picker ----
       $(function() {
            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            var datepicked = $('#selectdate').val()
            $('#selectDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate:today,
                startDate: datepicked,
                // minYear: parseInt(moment().format('YYYY')),
                // maxYear: parseInt(moment().format('YYYY'))+10,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });// End Select Date ---- Date Picker ----

        var time = $('#timepicker').val();
        $('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '7',
            maxTime: '22',
            defaultTime: time,
            startTime: '1:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            use24hours: true
        });

        $(".add").on("click",function(){
            var row = $(this).closest("tr");
            var index = $(this).closest("table").find("tbody").find("tr").length - 1;

            row.after('<tr> <td> <select name="member-salutation[]" id="member-saluation-'+index+'" class="form-control"> <option value="Herr">Herr</option> <option value="Frau">Frau</option> <option value="Kind">Kind</option> <option value="Schwiegertochter">Schwiegertochter </option> <option value="Neffe">Neffe </option> </select> </td></td><td> <input type="text" name="member-first-name[]" id="member-first-name-'+index+'" class="form-control" value='+$("#first-name").val()+'> </td><td> <select name="member-krankenkassen[]" id="member-krankenkassen-'+index+'" class="form-control"> <option value="CSS">CSS</option> <option value="Helsana">Helsana</option> <option value="Swica">Swica</option> <option value="Concordia">Concordia</option> <option value="Visana">Visana</option> <option value="Assura">Assura</option> <option value="Sanitas">Sanitas</option> <option value="Intras">Intras</option> <option value="Progres">Progres</option> <option value="KPT">KPT</option> <option value="Groupe Mutuel">Groupe Mutuel</option> <option value="Wincare">Wincare</option> <option value="Atupri">Atupri</option> <option value="EGK">EGK</option> <option value="Sympany">Sympany</option> <option value="Sansan">Sansan</option> <option value="Philos-Groupe Mutuel">Philos-Groupe Mutuel</option> <option value="Agrisano">Agrisano</option> <option value="Avenir-Groupe Mutuel">Avenir-Groupe Mutuel</option> <option value="SKBH-Groupe Mutuel">SKBH-Groupe Mutuel</option> <option value="Caisse-Groupe Mutuel">Caisse-Groupe Mutuel</option> <option value="La Caisse Vaudoise-Groupe Mutuel">La Caisse Vaudoise-Groupe Mutuel</option> <option value="Avanex-Helsana">Avanex-Helsana</option> <option value="Hermes-Groupe Mutuel">Hermes-Groupe Mutuel</option> <option value="Provita">Provita</option> <option value="Supra">Supra</option> <option value="Innova">Innova</option> <option value="Arcosana">Arcosana</option> <option value="Xundheit">Xundheit</option> <option value="Aerosana-Helsana">Aerosana-Helsana</option> <option value="Kolping">Kolping</option> <option value="Aquilana">Aquilana</option> <option value="Sumiswalder">Sumiswalder</option> <option value="Panorama-Groupe Mutuel">Panorama-Groupe Mutuel</option> <option value="Carena">Carena</option> <option value="Auxilia">Auxilia</option> <option value="Easy Sana-Groupe Mutuel">Easy Sana-Groupe Mutuel</option> <option value="KLuG">KLuG</option> <option value="Luzerner Hinterland">Luzerner Hinterland</option> <option value="Sodalis">Sodalis</option> <option value="SLKK">SLKK</option> <option value="Galenos">Galenos</option> <option value="Avantis-Groupe Mutuel">Avantis-Groupe Mutuel</option> <option value="Rhenusana">Rhenusana</option> <option value="KMU">KMU</option> <option value="Steffisburg">Steffisburg</option> <option value="Cervino">Cervino</option> <option value="Malters">Malters</option> <option value="Vita Surselva">Vita Surselva</option> <option value="Sana24">Sana24</option> <option value="Birchmeier">Birchmeier</option> <option value="SanaTop">SanaTop</option> <option value="Wdenswil">Wdenswil</option> <option value="Publisana">Publisana</option> <option value="Elm">Elm</option> <option value="Einsiedeln">Einsiedeln</option> <option value="Lumnezia">Lumnezia</option> </select> </td><td> <input type="text" name="member-birth-year[]" id="member-birth-year-'+index+'" class="form-control" value='+$("#birth-year").val()+'> </td><td> <input type="text" name="member-contract-duration[]" id="member-contract-duration-'+index+'" class="form-control" value='+$("#contract-duration").val()+'> </td><td> <select name="member-behandlung[]" id="member-behandlung-'+index+'" class="form-control"> <option value="Gesund">Gesund</option> <option value="Behandlung">Behandlung</option> </select> </td></td><td style="text-align:center;"><a class="delete-row"><i class="fas fa-minus fa-lg addplus mt-2"></i></a></td></tr>')
            $("#member-saluation-"+index).val($('#salutation1').val())
            $("#member-behandlung-"+index).val($('#behandlung1').val())
            $("#member-krankenkassen-"+index).val($('#krankenkassen1').val())
            $("#first-name").val("")
            $("#birth-year").val("")
            $("#contract-duration").val("")
        })
        $("body").on("click",".delete-row",function(){
            var row = $(this).closest('tr');
            row.remove();
        })

        @hasrole('Administrator|Call Center Admin|Berater Admin')
            $("#country").select2( {
                placeholder: "Select Canton",
                allowClear: true
            });
        @endrole

        $('#submit').click(function(){
            if($('.phone_number').val() == ""){
                $('.mobile_number').prop('required', true);
            }
        });

        if($('button[type="submit"]').click(function(){
            var value = $('select#country').val()
            if(value == ''){
                $('.select2-selection--single').css('border','1px solid #e3342f')
            } else {
                $('.select2-selection--single').css('border','1px solid #38c172')
            }
            $('select#country').change(function(){
                var demo = $(this).children("option:selected").val();
                if(demo){
                    $('.select2-selection--single').css('border','1px solid #38c172')
                }else {
                    $('.select2-selection--single').css('border','1px solid #e3342f')
                }
            });
        }));
    });





////////// Multiple Comments /////////////////
@unlessrole('Administrator')
$('.delete-comment-button').remove()
@endunlessrole


$('body').on('click', '.edit-comment-button', function(){
   var thisCommentId = $(this).parent().parent().parent().attr('id');
   var oldCoomentButtons = $(this).parent().html();
   var commentButtons = $(this).parent();
   var oldCommentValue = $('.'+thisCommentId+'-comment').text();
   var commentField = $('.'+thisCommentId+'-comment').parent();

   commentField.html('<span class="'+thisCommentId+'-comment"><textarea style="width:100%; height:7rem;">'+oldCommentValue+'</textarea><span>')
   commentButtons.html('<button type="button" class="btn btn-sm btn-outline-success saveComment"><i class="fas fa-check"></i></button><button type="button" class="btn btn-sm btn-outline-danger ml-1 cancelComment"><i class="fas fa-times"></i></button>');
});

$('body').on('click', '.cancelComment', function(){
        var thisCommentId = $(this).parent().parent().parent().attr('id');
        var commentButtons = $(this).parent();
        var commentField = $('.'+thisCommentId+'-comment').parent();
        var oldCommentValue = $('.'+thisCommentId+'-comment').text();

    @hasrole('Administrator')
        commentButtons.html('<button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-sm btn-outline-secondary delete-comment-button"><i class="far fa-trash-alt"></i></button>')
    @else
        @hasrole('Call Center Admin')
            commentButtons.html('<button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button>')
        @endhasrole
    @endhasrole
        commentField.html('<span class="'+thisCommentId+'-comment">'+oldCommentValue+'</span>')

});



$('body').on('click','.saveComment', function(){
    var thisCommentId = $(this).parent().parent().parent().attr('id');
    var commentButtons = $(this).parent();
    var commentField = $('.'+thisCommentId+'-comment').parent();
    var newCommentValue = $('.'+thisCommentId+'-comment textarea').val();


    $.ajax({
            type: 'PATCH',
            data: { _token: '{{ csrf_token() }}', newValue:newCommentValue },
            url: '/appointment/'+thisCommentId+'/comment/edit',
            success: function (result) {
                toastr.success('Comment Updated', {timeOut:5000})
                @hasrole('Administrator')
                    commentButtons.html('<button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-sm btn-outline-secondary delete-comment-button"><i class="far fa-trash-alt"></i></button>')
                @else
                    @hasrole('Call Center Admin')
                        commentButtons.html('<button class="btn btn-sm btn-outline-secondary edit-comment-button" type="button"><i class="fas fa-edit"></i></button>')
                    @endhasrole
                @endhasrole
                commentField.html('<span class="'+thisCommentId+'-comment">'+newCommentValue+'</span>')
            },
            error: function (xhr) {  toastr.error('Comment is not valid', {timeOut:5000})
                                },
        })
});

$('body').on('click','.delete-comment-button', function(){

@hasrole('Administrator')
    var thisCommentId = $(this).parent().parent().parent().attr('id');
    var deleteComment = $(this).parent().parent().parent();
         $.ajax({
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            url: '/appointment/'+thisCommentId+'/comment/delete',
            success: function () {
                deleteComment.remove() // remove row form table after delete
                toastr.success('Comment Deleted', {timeOut:5000})
                rowCss.css("border-bottom", "1px solid #dee2e6") /// set borders for <tr></tr>
            },
        });
@endhasrole


});






// /////// End Multiple Comment ///////////////






// ================ Google maps API ====================
function initMap() {
    var myLatLng = {lat: <?php echo $appointment->lat; ?>, lng: <?php echo $appointment->lng; ?>};
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: <?php echo $appointment->lat; ?>, lng: <?php echo $appointment->lng; ?>},
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
}// ================ Google maps API ====================

      // ============== Start Auto Complete Canton by Zip code =================
    var x = [
        { label :  '', value : 'Select Canton' },
        { label : '12', value : 'Geneva' },
        { label : '13', value : 'Jura' },
        { label : '17', value : 'Fribourg' },
        { label : '18', value : 'Geneva' },
        { label : '19', value : 'Valais' },
        { label : '20', value : 'Neuchâtel'},
        { label : '3', value : 'Bern'},
        { label : '30', value : 'Bern'},
        { label : '31', value : 'Bern'},
        { label : '4', value : 'Basel-Stadt'},
        { label : '40', value : 'Basel-Stadt'},
        { label : '44', value : 'Basel-Landschaft'},
        { label : '45', value : 'Solothurn'},
        { label : '60', value : 'Lucerne'},
        { label : '601', value : 'Obwalden'},
        { label : '605', value : 'Nidwalden'},
        { label : '6053', value : 'Obwalden'},
        { label : '6055', value : 'Obwalden'},
        { label : '6056', value : 'Obwalden'},
        { label : '606', value : 'Obwalden'},
        { label : '607', value : 'Obwalden'},
        { label : '63', value : 'Zug'},
        { label : '636', value : 'Nidwalden'},
        { label : '637', value : 'Nidwalden'},
        { label : '6377', value : 'Uri'},
        { label : '638', value : 'Nidwalden'},
        { label : '6388', value : 'Obwalden'},
        { label : '639', value : 'Obwalden'},
        { label : '639', value : 'Obwalden'},
        { label : '64', value : 'Schwyz'},
        { label : '6441', value : 'Uri'},
        { label : '6452', value : 'Uri'},
        { label : '6454', value : 'Uri'},
        { label : '646', value : 'Uri'},
        { label : '647', value : 'Uri'},
        { label : '648', value : 'Uri'},
        { label : '649', value : 'Uri'},
        { label : '7', value : 'Graubünden'},
        { label : '70', value : 'Graubünden'},
        { label : '8', value : 'Zürich' },
        { label : '80', value : 'Zürich'},
        { label : '82', value : 'Schaffhausen'},
        { label : '87', value : 'Glarus'},
        { label : '8751', value : 'Uri'},
        { label : '89', value : 'Aargau'},
        { label : '90', value : 'St. Gallen'},
        { label : '91', value : 'Appenzell Ausserrhoden'},
        { label : '910', value : 'Appenzell Ausserrhoden'},
    ];

    $( "#post_code" ).autocomplete({
        source: x,
        open: function(){
            $('li').hide();
                return false;
            },
    }).on( 'autocompleteresponse autocompleteselect', function( e, ui ){
        var t = $(this),
        details = $('#country');
            label = ( e.type == 'autocompleteresponse' ? ui.content[0].label :  ui.item.label ),
            value = ( e.type == 'autocompleteresponse' ? ui.content[0].value : ui.item.value );

            details.val(value).attr('selected', true).select2({
                placeholder: 'Select Canton',
                allowClear: true,
            });
    });// ============== Start Auto Complete Canton by Zip code =================

    // =================Image Upload =========================
    <?php foreach($images as $key => $image){
        ?> var image{{$key}} = '{{ url('uploads/' . $image) }}';//storage
        <?php
    } ?>
    $("#fileUpload").fileinput({
        language: "de",
        initialPreview: [
            <?php foreach($images as $key => $image){ ?>
                image{{$key}},
            <?php } ?>
        ],
        initialPreviewAsData: true,
        initialPreviewConfig: [
            <?php foreach($images as $key => $image){
                $mime = substr($image,-3);
                if($mime == 'mp3'){
                    $type = 'audio';
                    $filetype = 'audio/mp3';
                }else {
                    $type = 'image';
                    $filetype = 'image/*';
                }
                ?>
                {type: "{{$type}}", caption: "{{$image}}", filetype: "{{$filetype}}", filename: "{{$image}}", url:"{{ route('delete.image',[$appointment, $image]) }}", downloadUrl:'{{ url('uploads/' . $image) }}',width: "120px", key:{{$image[$key]}} },//storage
            <?php } ?>
        ],
        deleteExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        uploadUrl: "{{ route('upload.image', $appointment) }}",
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        fileActionSettings: {showDrag:false},
        theme: 'fa',
        allowedFileExtensions: ['jpg', 'png', 'jpeg', 'mp3'],
        overwriteInitial: false,
        maxFileSize:20000,
        maxFilesNum: 10,
        // dropZoneEnabled: false,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }


    })// =================Image Upload =========================
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsZV9n7YkwIEi1eQ54aFWURcQYhAjQkfA&libraries=places&callback=initMap"
        async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>

@endsection
