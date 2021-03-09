@extends('layouts.app')

@section('content')
<script src="{{ asset('js/location/de.js') }}"></script>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
                @if (session('errorAppointment'))
                    <script>
                        toastr.error('{{ session('errorAppointment') }}', {timeOut:5000})
                    </script>
                @endif
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <script>
                            toastr.error('{{$error}}', {timeOut:50000})
                        </script>
                    @endforeach
                @endif
                    <form method="post" id="appointment-form" action="{{ route('store.appointment') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mb-3">
                        <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salutation">Anrede</label>
                                    <select required name="salutation" id="salutation" class="form-control{{ $errors->has('salutation') ? ' is-invalid' : '' }}" >
                                        <option value="">Anrede wählen</option>
                                        <option value="Herr" {{ old('salutation') == "Herr" ? 'selected' : '' }}>Herr</option>
                                        <option value="Frau" {{ old('salutation') == "Frau" ? 'selected' : '' }}>Frau</option>
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
                                    <input required type="text"  name="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ old('first_name') }}">
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
                                    <input required type="text"  name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}">
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
                                    <select required name="language" id="language" class="form-control{{ $errors->has('language') ? ' is-invalid' : '' }}" >
                                        <option value="">Sprache wählen</option>
                                        <option value="DE" {{ old('language') == "DE" ? 'selected' : '' }}>DE</option>
                                        <option value="FR" {{ old('language') == "FR" ? 'selected' : '' }}>FR</option>
                                        <option value="IT" {{ old('language') == "IT" ? 'selected' : '' }}>IT</option>
                                        <option value="AL" {{ old('language') == "AL" ? 'selected' : '' }}>AL</option>
                                        <option value="ESP" {{ old('language') == "ESP" ? 'selected' : '' }}>ESP</option>
                                        <option value="SRB" {{ old('language') == "SRB" ? 'selected' : '' }}>SRB</option>
                                        <option value="TR" {{ old('language') == "TR" ? 'selected' : '' }}>TR</option>
                                        <option value="Other" {{ old('language') == "Other" ? 'selected' : '' }}>Other</option>
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
                                <div class="mb-3">
                                    <label for="mobile_number">Mobile Nummer</label>
                                    <input type="text" name="mobile_number" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }} mobile_number" value="{{ old('mobile_number') }}">
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
                                <div class="mb-3">
                                    <label for="phone_number">Haus Phone Nummer</label>
                                    <input type="text" name="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }} phone_number" value="{{ old('phone_number') }}">
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
                                <div class="mb-3">
                                    <label for="house_number">Haus Nummer</label>
                                    <input required type="text" name="house_number" class="form-control{{ $errors->has('house_number') ? ' is-invalid' : '' }} house_number" value="{{ old('house_number') }}">
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
                                <div class="">
                                    <label for="company">Krankenkassen</label>
                                    <select name="company" id="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" required>
                                        <option value="">Select Company</option>
                                        <option value="CSS" {{ old('company') == "CSS" ? 'selected' : '' }} >CSS</option>
                                        <option value="Helsana" {{ old('company') == "Helsana" ? 'selected' : '' }} >Helsana</option>
                                        <option value="Swica" {{ old('company') == "Swica" ? 'selected' : '' }} >Swica</option>
                                        <option value="Concordia" {{ old('company') == "Concordia" ? 'selected' : '' }} >Concordia</option>
                                        <option value="Visana" {{ old('company') == "Visana" ? 'selected' : '' }} >Visana</option>
                                        <option value="Assura" {{ old('company') == "Assura" ? 'selected' : '' }} >Assura</option>
                                        <option value="Sanitas" {{ old('company') == "Sanitas" ? 'selected' : '' }} >Sanitas</option>
                                        <option value="Intras" {{ old('company') == "Intras" ? 'selected' : '' }} >Intras</option>
                                        <option value="Progres" {{ old('company') == "Progres" ? 'selected' : '' }} >Progres</option>
                                        <option value="KPT" {{ old('company') == "KPT" ? 'selected' : '' }} >KPT</option>
                                        <option value="Groupe Mutuel" {{ old('company') == "Groupe Mutuel" ? 'selected' : '' }} >Groupe Mutuel</option>
                                        <option value="Wincare" {{ old('company') == "Wincare" ? 'selected' : '' }} >Wincare</option>
                                        <option value="Atupri" {{ old('company') == "Atupri" ? 'selected' : '' }} >Atupri</option>
                                        <option value="EGK" {{ old('company') == "EGK" ? 'selected' : '' }} >EGK</option>
                                        <option value="Sympany" {{ old('company') == "Sympany" ? 'selected' : '' }} >Sympany</option>
                                        <option value="Sansan" {{ old('company') == "Sansan" ? 'selected' : '' }} >Sansan</option>
                                        <option value="Philos-Groupe Mutuel" {{ old('company') == "Philos-Groupe Mutuel" ? 'selected' : '' }} >Philos-Groupe Mutuel</option>
                                        <option value="Agrisano" {{ old('company') == "Agrisano" ? 'selected' : '' }} >Agrisano</option>
                                        <option value="Avenir-Groupe Mutuel" {{ old('company') == "Avenir-Groupe Mutuel" ? 'selected' : '' }} >Avenir-Groupe Mutuel</option>
                                        <option value="SKBH-Groupe Mutuel" {{ old('company') == "SKBH-Groupe Mutuel" ? 'selected' : '' }} >SKBH-Groupe Mutuel</option>
                                        <option value="Caisse-Groupe Mutuel" {{ old('company') == "Caisse-Groupe Mutuel" ? 'selected' : '' }} >Caisse-Groupe Mutuel</option>
                                        <option value="La Caisse Vaudoise-Groupe Mutuel" {{ old('company') == "La Caisse Vaudoise-Groupe Mutuel" ? 'selected' : '' }} >La Caisse Vaudoise-Groupe Mutuel</option>
                                        <option value="Avanex-Helsana" {{ old('company') == "Avanex-Helsana" ? 'selected' : '' }} >Avanex-Helsana</option>
                                        <option value="Hermes-Groupe Mutuel" {{ old('company') == "Hermes-Groupe Mutuel" ? 'selected' : '' }} >Hermes-Groupe Mutuel</option>
                                        <option value="Provita" {{ old('company') == "Provita" ? 'selected' : '' }} >Provita</option>
                                        <option value="Supra" {{ old('company') == "Supra" ? 'selected' : '' }} >Supra</option>
                                        <option value="Innova" {{ old('company') == "Innova" ? 'selected' : '' }} >Innova</option>
                                        <option value="Arcosana" {{ old('company') == "Arcosana" ? 'selected' : '' }} >Arcosana</option>
                                        <option value="Xundheit" {{ old('company') == "Xundheit" ? 'selected' : '' }} >Xundheit</option>
                                        <option value="Aerosana-Helsana" {{ old('company') == "Aerosana-Helsana" ? 'selected' : '' }} >Aerosana-Helsana</option>
                                        <option value="Kolping" {{ old('company') == "Kolping" ? 'selected' : '' }} >Kolping</option>
                                        <option value="Aquilana" {{ old('company') == "Aquilana" ? 'selected' : '' }} >Aquilana</option>
                                        <option value="Sumiswalder" {{ old('company') == "Sumiswalder" ? 'selected' : '' }} >Sumiswalder</option>
                                        <option value="Panorama-Groupe Mutuel" {{ old('company') == "Panorama-Groupe Mutuel" ? 'selected' : '' }} >Panorama-Groupe Mutuel</option>
                                        <option value="Carena" {{ old('company') == "Carena" ? 'selected' : '' }} >Carena</option>
                                        <option value="Auxilia" {{ old('company') == "Auxilia" ? 'selected' : '' }} >Auxilia</option>
                                        <option value="Easy Sana-Groupe Mutuel" {{ old('company') == "Easy Sana-Groupe Mutuel" ? 'selected' : '' }} >Easy Sana-Groupe Mutuel</option>
                                        <option value="KLuG" {{ old('company') == "KLuG" ? 'selected' : '' }} >KLuG</option>
                                        <option value="Luzerner Hinterland" {{ old('company') == "Luzerner Hinterland" ? 'selected' : '' }} >Luzerner Hinterland</option>
                                        <option value="Sodalis" {{ old('company') == "Sodalis" ? 'selected' : '' }} >Sodalis</option>
                                        <option value="SLKK" {{ old('company') == "SLKK" ? 'selected' : '' }} >SLKK</option>
                                        <option value="Galenos" {{ old('company') == "Galenos" ? 'selected' : '' }} >Galenos</option>
                                        <option value="Avantis-Groupe Mutuel" {{ old('company') == "Avantis-Groupe Mutuel" ? 'selected' : '' }} >Avantis-Groupe Mutuel</option>
                                        <option value="Rhenusana" {{ old('company') == "Rhenusana" ? 'selected' : '' }} >Rhenusana</option>
                                        <option value="KMU" {{ old('company') == "KMU" ? 'selected' : '' }} >KMU</option>
                                        <option value="Steffisburg" {{ old('company') == "Steffisburg" ? 'selected' : '' }} >Steffisburg</option>
                                        <option value="Cervino" {{ old('company') == "Cervino" ? 'selected' : '' }} >Cervino</option>
                                        <option value="Malters" {{ old('company') == "Malters" ? 'selected' : '' }} >Malters</option>
                                        <option value="Vita Surselva" {{ old('company') == "Vita Surselva" ? 'selected' : '' }} >Vita Surselva</option>
                                        <option value="Sana24" {{ old('company') == "Sana24" ? 'selected' : '' }} >Sana24</option>
                                        <option value="Birchmeier" {{ old('company') == "Birchmeier" ? 'selected' : '' }} >Birchmeier</option>
                                        <option value="SanaTop" {{ old('company') == "SanaTop" ? 'selected' : '' }} >SanaTop</option>
                                        <option value="Wdenswil" {{ old('company') == "Wdenswil" ? 'selected' : '' }} >Wdenswil</option>
                                        <option value="Publisana" {{ old('company') == "Publisana" ? 'selected' : '' }} >Publisana</option>
                                        <option value="Elm" {{ old('company') == "Elm" ? 'selected' : '' }} >Elm</option>
                                        <option value="Einsiedeln" {{ old('company') == "Einsiedeln" ? 'selected' : '' }} >Einsiedeln</option>
                                        <option value="Lumnezia" {{ old('company') == "Lumnezia" ? 'selected' : '' }} >Lumnezia</option>
                                    </select>
                                    @if ($errors->has('company'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label for="comment">Kommentar</label>
                                    <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" name="comment" rows="5">{{ old('comment') }}</textarea>
                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif
                                </div>
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
                                    <input type="hidden" value="{{ old('lat') }}" id="lat" name="lat">
                                    <input type="hidden" value="{{ old('lng') }}" id="lng" name="lng">
                                    <label for="street">Strasse</label>
                                    <input required name="street" id="autocomplete" placeholder="Enter your address" type="text" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" value="{{ old('street') }}">
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
                                    <input required type="number" name="post_code" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }} post_code" id="post_code" value="{{ old('post_code') }}">
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
                                    <select required name="canton" id="country" style="width:100% !important" class="form-control{{ $errors->has('canton') ? ' is-invalid' : '' }}" >
                                        <option value="">Kanton wählen</option>
                                        <option value="Aargau" {{ old('canton') == "Aargau" ? 'selected' : '' }}>Aargau</option>
                                        <option value="Appenzell Ausserrhoden" {{ old('canton') == "Appenzell Ausserrhoden" ? 'selected' : '' }}>Appenzell Ausserrhoden</option>
                                        <option value="Appenzell Innerrhoden" {{ old('canton') == "Appenzell Innerrhoden" ? 'selected' : '' }}>Appenzell Innerrhoden</option>
                                        <option value="Basel-Stadt" {{ old('canton') == "Basel-Stadt" ? 'selected' : '' }}>Basel-Stadt</option>
                                        <option value="Basel-Landschaft" {{ old('canton') == "Basel-Landschaft" ? 'selected' : '' }}>Basel-Landschaft</option>
                                        <option value="Bern" {{ old('canton') == "Bern" ? 'selected' : '' }}>Bern</option>
                                        <option value="Fribourg" {{ old('canton') == "Fribourg" ? 'selected' : '' }}>Fribourg</option>
                                        <option value="Geneva" {{ old('canton') == "Geneva" ? 'selected' : '' }}>Geneva</option>
                                        <option value="Glarus" {{ old('canton') == "Glarus" ? 'selected' : '' }}>Glarus</option>
                                        <option value="Graubünden" {{ old('canton') == "Graubünden" ? 'selected' : '' }}>Graubünden</option>
                                        <option value="Jura" {{ old('canton') == "Jura" ? 'selected' : '' }}>Jura</option>
                                        <option value="Lucerne" {{ old('canton') == "Lucerne" ? 'selected' : '' }}>Lucerne</option>
                                        <option value="Neuchâtel" {{ old('canton') == "Neuchâtel" ? 'selected' : '' }}>Neuchâtel</option>
                                        <option value="Nidwalden" {{ old('canton') == "Nidwalden" ? 'selected' : '' }}>Nidwalden</option>
                                        <option value="Obwalden" {{ old('canton') == "Obwalden" ? 'selected' : '' }}>Obwalden</option>
                                        <option value="Schaffhausen" {{ old('canton') == "Schaffhausen" ? 'selected' : '' }}>Schaffhausen</option>
                                        <option value="Schwyz" {{ old('canton') == "Schwyz" ? 'selected' : '' }}>Schwyz</option>
                                        <option value="Solothurn" {{ old('canton') == "Solothurn" ? 'selected' : '' }}>Solothurn</option>
                                        <option value="St. Gallen" {{ old('canton') == "St. Gallen" ? 'selected' : '' }}>St. Gallen</option>
                                        <option value="Thurgau" {{ old('canton') == "Thurgau" ? 'selected' : '' }}>Thurgau</option>
                                        <option value="Ticino" {{ old('canton') == "Ticino" ? 'selected' : '' }}>Ticino</option>
                                        <option value="Uri" {{ old('canton') == "Uri" ? 'selected' : '' }}>Uri</option>
                                        <option value="Valais" {{ old('canton') == "Valais" ? 'selected' : '' }}>Valais</option>
                                        <option value="Vaud" {{ old('canton') == "Vaud" ? 'selected' : '' }}>Vaud</option>
                                        <option value="Zug" {{ old('canton') == "Zug" ? 'selected' : '' }}>Zug</option>
                                        <option value="Zürich" {{ old('canton') == "Zürich" ? 'selected' : '' }}>Zürich</option>
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
                                <div class="mt-3">
                                    <label for="date">Termin Datum</label>
                                    <input required type="text" id="selectDate" name="date" autocomplete="off" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="dd/mm/yyyy" value="{{ old('date') }}">
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
                                <div class="mt-3">
                                    <label for="time">Termin Zeit</label>
                                    <input required type="text" name="time" id="timepicker" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" autocomplete="off" value="{{ old('time') }}">
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
                                    <label for="file">Hochladen</label>
                                    <input type="file" name="file[]" id="fileUpload" accept="image/png, image/jpeg, audio/mp3" class="form-control{{ $errors->has('file.*') ? ' is-invalid' : '' }}" multiple>
                                    @if ($errors->has('file.*'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('file.*') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Familienmitglieder</label>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Salutation</td>
                                            <td>Name</td>
                                            <td>KK</td>
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
                                            <td style="text-align:center;">
                                                <a class="add"><i class="fas fa-plus fa-lg addplus mt-2"></i></a>
                                            </td>
                                        </tr>
                                        @if(old('member-first-name.0'))
                                        @for($i=0;$i < count(old('member-first-name'));$i++)
                                        <tr>
                                            <td>
                                                <select name="member-salutation[]" id="member-saluation-2" class="form-control">
                                                    <option value="Herr" @if(old('member-salutation')[$i] == 'Herr') selected @endif>Herr</option>
                                                    <option value="Frau" @if(old('member-salutation')[$i] == 'Frau') selected @endif>Frau</option>
                                                    <option value="Kind" @if(old('member-salutation')[$i] == 'Kind') selected @endif>Kind</option>
                                                    <option value="Schwiegertochter" @if(old('member-salutation')[$i] == 'Schwiegertochter') selected @endif>Schwiegertochter</option>
                                                    <option value="Neffe" @if(old('member-salutation')[$i] == 'Neffe') selected @endif>Neffe</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="member-first-name[]" id="member-first-name-2" class="form-control" value="{{ old('member-first-name')[$i]}}"></td>
                                            <td>
                                                <select name="member-krankenkassen[]" id="member-krankenkassen-2" class="form-control">
                                                    <option value="CSS" @if(old('member-krankenkassen')[$i] == "CSS") selected @endif >CSS</option>
                                                    <option value="Helsana" @if(old('member-krankenkassen')[$i] == "Helsana") selected @endif >Helsana</option>
                                                    <option value="Swica" @if(old('member-krankenkassen')[$i] == "Swica") selected @endif >Swica</option>
                                                    <option value="Concordia" @if(old('member-krankenkassen')[$i] == "Concordia") selected @endif >Concordia</option>
                                                    <option value="Visana" @if(old('member-krankenkassen')[$i] == "Visana") selected @endif >Visana</option>
                                                    <option value="Assura" @if(old('member-krankenkassen')[$i] == "Assura") selected @endif >Assura</option>
                                                    <option value="Sanitas" @if(old('member-krankenkassen')[$i] == "Sanitas") selected @endif >Sanitas</option>
                                                    <option value="Intras" @if(old('member-krankenkassen')[$i] == "Intras") selected @endif >Intras</option>
                                                    <option value="Progres" @if(old('member-krankenkassen')[$i] == "Progres") selected @endif >Progres</option>
                                                    <option value="KPT" @if(old('member-krankenkassen')[$i] == "KPT") selected @endif >KPT</option>
                                                    <option value="Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Groupe Mutuel") selected @endif >Groupe Mutuel</option>
                                                    <option value="Wincare" @if(old('member-krankenkassen')[$i] == "Wincare") selected @endif >Wincare</option>
                                                    <option value="Atupri" @if(old('member-krankenkassen')[$i] == "Atupri") selected @endif >Atupri</option>
                                                    <option value="EGK" @if(old('member-krankenkassen')[$i] == "EGK") selected @endif >EGK</option>
                                                    <option value="Sympany" @if(old('member-krankenkassen')[$i] == "Sympany") selected @endif >Sympany</option>
                                                    <option value="Sansan" @if(old('member-krankenkassen')[$i] == "Sansan") selected @endif >Sansan</option>
                                                    <option value="Philos-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Philos-Groupe Mutuel") selected @endif >Philos-Groupe Mutuel</option>
                                                    <option value="Agrisano" @if(old('member-krankenkassen')[$i] == "Agrisano") selected @endif >Agrisano</option>
                                                    <option value="Avenir-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Avenir-Groupe Mutuel") selected @endif >Avenir-Groupe Mutuel</option>
                                                    <option value="SKBH-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "SKBH-Groupe Mutuel") selected @endif >SKBH-Groupe Mutuel</option>
                                                    <option value="Caisse-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Caisse-Groupe Mutuel") selected @endif >Caisse-Groupe Mutuel</option>
                                                    <option value="La Caisse Vaudoise-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "La Caisse Vaudoise-Groupe Mutuel") selected @endif >La Caisse Vaudoise-Groupe Mutuel</option>
                                                    <option value="Avanex-Helsana" @if(old('member-krankenkassen')[$i] == "Avanex-Helsana") selected @endif >Avanex-Helsana</option>
                                                    <option value="Hermes-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Hermes-Groupe Mutuel") selected @endif >Hermes-Groupe Mutuel</option>
                                                    <option value="Provita" @if(old('member-krankenkassen')[$i] == "Provita") selected @endif >Provita</option>
                                                    <option value="Supra" @if(old('member-krankenkassen')[$i] == "Supra") selected @endif >Supra</option>
                                                    <option value="Innova" @if(old('member-krankenkassen')[$i] == "Innova") selected @endif >Innova</option>
                                                    <option value="Arcosana" @if(old('member-krankenkassen')[$i] == "Arcosana") selected @endif >Arcosana</option>
                                                    <option value="Xundheit" @if(old('member-krankenkassen')[$i] == "Xundheit") selected @endif >Xundheit</option>
                                                    <option value="Aerosana-Helsana" @if(old('member-krankenkassen')[$i] == "Aerosana-Helsana") selected @endif >Aerosana-Helsana</option>
                                                    <option value="Kolping" @if(old('member-krankenkassen')[$i] == "Kolping") selected @endif >Kolping</option>
                                                    <option value="Aquilana" @if(old('member-krankenkassen')[$i] == "Aquilana") selected @endif >Aquilana</option>
                                                    <option value="Sumiswalder" @if(old('member-krankenkassen')[$i] == "Sumiswalder") selected @endif >Sumiswalder</option>
                                                    <option value="Panorama-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Panorama-Groupe Mutuel") selected @endif >Panorama-Groupe Mutuel</option>
                                                    <option value="Carena" @if(old('member-krankenkassen')[$i] == "Carena") selected @endif >Carena</option>
                                                    <option value="Auxilia" @if(old('member-krankenkassen')[$i] == "Auxilia") selected @endif >Auxilia</option>
                                                    <option value="Easy Sana-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Easy Sana-Groupe Mutuel") selected @endif >Easy Sana-Groupe Mutuel</option>
                                                    <option value="KLuG" @if(old('member-krankenkassen')[$i] == "KLuG") selected @endif >KLuG</option>
                                                    <option value="Luzerner Hinterland" @if(old('member-krankenkassen')[$i] == "Luzerner Hinterland") selected @endif >Luzerner Hinterland</option>
                                                    <option value="Sodalis" @if(old('member-krankenkassen')[$i] == "Sodalis") selected @endif >Sodalis</option>
                                                    <option value="SLKK" @if(old('member-krankenkassen')[$i] == "SLKK") selected @endif >SLKK</option>
                                                    <option value="Galenos" @if(old('member-krankenkassen')[$i] == "Galenos") selected @endif >Galenos</option>
                                                    <option value="Avantis-Groupe Mutuel" @if(old('member-krankenkassen')[$i] == "Avantis-Groupe Mutuel") selected @endif >Avantis-Groupe Mutuel</option>
                                                    <option value="Rhenusana" @if(old('member-krankenkassen')[$i] == "Rhenusana") selected @endif >Rhenusana</option>
                                                    <option value="KMU" @if(old('member-krankenkassen')[$i] == "KMU") selected @endif >KMU</option>
                                                    <option value="Steffisburg" @if(old('member-krankenkassen')[$i] == "Steffisburg") selected @endif >Steffisburg</option>
                                                    <option value="Cervino" @if(old('member-krankenkassen')[$i] == "Cervino") selected @endif >Cervino</option>
                                                    <option value="Malters" @if(old('member-krankenkassen')[$i] == "Malters") selected @endif >Malters</option>
                                                    <option value="Vita Surselva" @if(old('member-krankenkassen')[$i] == "Vita Surselva") selected @endif >Vita Surselva</option>
                                                    <option value="Sana24" @if(old('member-krankenkassen')[$i] == "Sana24") selected @endif >Sana24</option>
                                                    <option value="Birchmeier" @if(old('member-krankenkassen')[$i] == "Birchmeier") selected @endif >Birchmeier</option>
                                                    <option value="SanaTop" @if(old('member-krankenkassen')[$i] == "SanaTop") selected @endif >SanaTop</option>
                                                    <option value="Wdenswil" @if(old('member-krankenkassen')[$i] == "Wdenswil") selected @endif >Wdenswil</option>
                                                    <option value="Publisana" @if(old('member-krankenkassen')[$i] == "Publisana") selected @endif >Publisana</option>
                                                    <option value="Elm" @if(old('member-krankenkassen')[$i] == "Elm") selected @endif >Elm</option>
                                                    <option value="Einsiedeln" @if(old('member-krankenkassen')[$i] == "Einsiedeln") selected @endif >Einsiedeln</option>
                                                    <option value="Lumnezia" @if(old('member-krankenkassen')[$i] == "Lumnezia") selected @endif >Lumnezia</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="member-birth-year[]" id="member-birth-year-2" class="form-control" value="{{ old('member-birth-year')[$i]}}"></td>
                                            <td><input type="text" name="member-contract-duration[]" id="member-contract-duration-2" class="form-control" value="{{ old('member-contract-duration')[$i]}}"></td>
                                            <td>
                                                <select name="member-behandlung[]" id="member-behandlung-2" class="form-control">
                                                    <option value="Gesund" @if(old('member-behandlung')[$i] == 'Gesund') selected @endif>Gesund</option>
                                                    <option value="Behandlung" @if(old('member-behandlung')[$i] == 'Behandlung') selected @endif>Behandlung</option>
                                                </select>
                                            </td>
                                            <td style="text-align:center;">
                                                <a class="delete-row"><i class="fas fa-minus fa-lg addplus mt-2"></i></a>
                                            </td>
                                        </tr>
                                        @endfor
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 appointmentbuttons">
                                <a href="{{ route('show.appointment') }}" class="btn btn-danger px-5 mr-2"><b>Abbrechen</b></a>
                                <button type="submit" id="submit" class="btn btn-outline-danger px-5"><b>Speichern</b></button>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsZV9n7YkwIEi1eQ54aFWURcQYhAjQkfA&libraries=places&callback=initMap"
        async defer></script>
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
        $('.mobile_number').mask('000 000 00 00');
        // $('.mobile_number').val('0');
        $('.phone_number').mask('000 000 00 00');
        // $('.phone_number').val('0');
        $('.post_code').mask('0000');

        $('.house_number').mask('AAAA', {'translation': {
                A: {pattern: /[A-Za-z0-9.\-\/]/},
            }
        });


       // Select Date ---- Date Picker ----
        $(function() {
            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            $('#selectDate').daterangepicker({
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

        $('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '7',
            maxTime: '22',
            defaultTime: '10',
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

        $("#country").select2( {
            placeholder: "Select Canton",
            allowClear: true
        });

        $('#submit').click(function(){
            if($('.phone_number').val() == ""){
                $('.mobile_number').prop('required', true);
            }
            if($('.phone_number').val() != ""){
                $('.mobile_number').prop('required', false);
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



    // ================ Google maps API ====================
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 46.7729789, lng: 7.6107727},
          zoom: 7
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
            $('#ui-id-1 > li').hide();
            return false;
        },
    }).on( 'autocompleteresponse autocompleteselect', function( e, ui ){
        var t = $(this),
        details = $('#country');
        if(ui.content.length > 0)
        {
            label = ( e.type == 'autocompleteresponse' ? ui.content[0].label :  ui.item.label ),
            value = ( e.type == 'autocompleteresponse' ? ui.content[0].value : ui.item.value );

            details.val(value).attr('selected', true).select2({
                placeholder: 'Select Canton',
                allowClear: true,
            });
        }
    });// ============== End Auto Complete Canton by Zip code =================

    // ================ Image upload =================
    $("#fileUpload").fileinput({
            language: "de",
            theme: 'fa',
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'mp3'],
            overwriteInitial: false,
            maxFileSize:20000,
            maxFilesNum: 10,
            fileActionSettings: {showUpload: false},
            showUpload: false,
            // dropZoneEnabled: false,

            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        })// ================ Image upload ================

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
@endsection
