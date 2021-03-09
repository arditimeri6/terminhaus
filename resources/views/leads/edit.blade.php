@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <script>
                    toastr.error('{{$error}}', {timeOut:50000})
                </script>
            @endforeach
        @endif
        <form method="post" action="{{ route('update.lead', $lead->id) }}" class="needs-validation" novalidate>
            @csrf
                <div class="row">
                    @hasrole('Administrator|Call Center Admin|Call Center Direktor|Agent Team Leader|Quality Controll|Agent')
                        <div class="col-md-12 mb-4 createdBy-paragraph">
                            <p></p>
                            <p>Created By: <span style="font-weight: bold;">{{$username->first_name}} {{$username->last_name}}</span></p>
                        </div>
                    @endhasrole
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kunden_type">Kundentyp</label>
                            <select required name="kunden_type" id="kunden_type" class="form-control{{ $errors->has('kunden_type') ? ' is-invalid' : '' }}" >
                                <option value="Privatgelände" @if($lead->kunden_type == 'Privatgelände') selected @endif >Privatgelände</option>
                                <option value="Unternehmen" @if($lead->kunden_type == 'Unternehmen') selected @endif >Unternehmen</option>
                            </select>
                            @if ($errors->has('kunden_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('kunden_type') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salutation">Anrede</label>
                            <select required name="salutation" id="salutation" class="form-control{{ $errors->has('salutation') ? ' is-invalid' : '' }}" >
                                <option value="">Anrede auswählen</option>
                                <option value="Herr" @if($lead->salutation == 'Herr') selected @endif >Herr</option>
                                <option value="Frau" @if($lead->salutation == 'Frau') selected @endif >Frau</option>
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Vorname</label>
                            <input required type="text" name="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ $lead->first_name }}">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Nachname</label>
                            <input required type="text" name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ $lead->last_name }}">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Jahrgang</label>
                            <input required type="text" id="yearpicker" name="year" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ $lead->year }}">
                            @if ($errors->has('year'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('year') }}</strong>
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
                            <label for="mobile_number">Mobile Nummer</label>
                            <input type="text" name="mobile_number" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }} mobile_number" value="{{ $lead->mobile_number }}">
                            @if ($errors->has('mobile_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="house_number">Haus Nummer</label>
                            <input type="text" name="house_number" class="form-control{{ $errors->has('house_number') ? ' is-invalid' : '' }} house_number" value="{{ $lead->house_number }}">
                            @if ($errors->has('house_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('house_number') }}</strong>
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
                            <label for="street">Strasse</label>
                            <input required type="text" name="street" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" value="{{ $lead->street }}">
                            @if ($errors->has('street'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('street') }}</strong>
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
                            <label for="post_code">PLZ</label>
                            <input required type="number" name="post_code" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }} post_code" value="{{ $lead->post_code }}">
                            @if ($errors->has('post_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('post_code') }}</strong>
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
                            <label for="place">Ort</label>
                            <input required type="text" name="place" class="form-control{{ $errors->has('place') ? ' is-invalid' : '' }}" value="{{ $lead->place }}">
                            @if ($errors->has('place'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('place') }}</strong>
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
                            <label for="canton">Kanton</label>
                            <select required name="canton" id="country" style="width:100% !important" class="form-control{{ $errors->has('canton') ? ' is-invalid' : '' }}" >
                                <option value="">Kanton auswählen</option>
                                <option value="Aargau" {{ $lead->canton == "Aargau" ? 'selected' : '' }}>Aargau</option>
                                <option value="Appenzell Ausserrhoden" {{ $lead->canton == "Appenzell Ausserrhoden" ? 'selected' : '' }}>Appenzell Ausserrhoden</option>
                                <option value="Appenzell Innerrhoden" {{ $lead->canton == "Appenzell Innerrhoden" ? 'selected' : '' }}>Appenzell Innerrhoden</option>
                                <option value="Basel-Stadt" {{ $lead->canton == "Basel-Stadt" ? 'selected' : '' }}>Basel-Stadt</option>
                                <option value="Basel-Landschaft" {{ $lead->canton == "Basel-Landschaft" ? 'selected' : '' }}>Basel-Landschaft</option>
                                <option value="Bern" {{ $lead->canton == "Bern" ? 'selected' : '' }}>Bern</option>
                                <option value="Fribourg" {{ $lead->canton == "Fribourg" ? 'selected' : '' }}>Fribourg</option>
                                <option value="Geneva" {{ $lead->canton == "Geneva" ? 'selected' : '' }}>Geneva</option>
                                <option value="Glarus" {{ $lead->canton == "Glarus" ? 'selected' : '' }}>Glarus</option>
                                <option value="Graubünden" {{ $lead->canton == "Graubünden" ? 'selected' : '' }}>Graubünden</option>
                                <option value="Jura" {{ $lead->canton == "Jura" ? 'selected' : '' }}>Jura</option>
                                <option value="Lucerne" {{ $lead->canton == "Lucerne" ? 'selected' : '' }}>Lucerne</option>
                                <option value="Neuchâtel" {{ $lead->canton == "Neuchâtel" ? 'selected' : '' }}>Neuchâtel</option>
                                <option value="Nidwalden" {{ $lead->canton == "Nidwalden" ? 'selected' : '' }}>Nidwalden</option>
                                <option value="Obwalden" {{ $lead->canton == "Obwalden" ? 'selected' : '' }}>Obwalden</option>
                                <option value="Schaffhausen" {{ $lead->canton == "Schaffhausen" ? 'selected' : '' }}>Schaffhausen</option>
                                <option value="Schwyz" {{ $lead->canton == "Schwyz" ? 'selected' : '' }}>Schwyz</option>
                                <option value="Solothurn" {{ $lead->canton == "Solothurn" ? 'selected' : '' }}>Solothurn</option>
                                <option value="St. Gallen" {{ $lead->canton == "St. Gallen" ? 'selected' : '' }}>St. Gallen</option>
                                <option value="Thurgau" {{ $lead->canton == "Thurgau" ? 'selected' : '' }}>Thurgau</option>
                                <option value="Ticino" {{ $lead->canton == "Ticino" ? 'selected' : '' }}>Ticino</option>
                                <option value="Uri" {{ $lead->canton == "Uri" ? 'selected' : '' }}>Uri</option>
                                <option value="Valais" {{ $lead->canton == "Valais" ? 'selected' : '' }}>Valais</option>
                                <option value="Vaud" {{ $lead->canton == "Vaud" ? 'selected' : '' }}>Vaud</option>
                                <option value="Zug" {{ $lead->canton == "Zug" ? 'selected' : '' }}>Zug</option>
                                <option value="Zürich" {{ $lead->canton == "Zürich" ? 'selected' : '' }}>Zürich</option>
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
                    </div>
                    <div class="col-md-6" id="company_field">
                        <div class="form-group">
                            <label for="company_name">Name der Firma</label>
                            <input type="text" name="company_name" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" value="{{ $lead->company_name }}">
                            @if ($errors->has('company_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> This field is required </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                    <label>Sprache</label>
                        <div class="form-inline formcostumstyle">
                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="deutsch" id="deutsch" name="language[]" @foreach($languages as $language) {{ $language->language == "deutsch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="deutsch">Deutsch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="italienisch" id="italienisch" name="language[]" @foreach($languages as $language) {{ $language->language == "italienisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="italienisch">Italienisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="franzosisch" id="franzosisch" name="language[]" @foreach($languages as $language) {{ $language->language == "franzosisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="franzosisch">Französisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="englisch" id="englisch" name="language[]" @foreach($languages as $language) {{ $language->language == "englisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="englisch">Englisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="albanisch" id="albanisch" name="language[]" @foreach($languages as $language) {{ $language->language == "albanisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="albanisch">Albanisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="arabisch" id="arabisch" name="language[]" @foreach($languages as $language) {{ $language->language == "arabisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="arabisch">Arabisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="bosnisch" id="bosnisch" name="language[]" @foreach($languages as $language) {{ $language->language == "bosnisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="bosnisch">Bosnisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="bulgarisch" id="bulgarisch" name="language[]" @foreach($languages as $language) {{ $language->language == "bulgarisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="bulgarisch">Bulgarisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="kurdisch" id="kurdisch" name="language[]" @foreach($languages as $language) {{ $language->language == "kurdisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="kurdisch">Kurdisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="mazedonisch" id="mazedonisch" name="language[]" @foreach($languages as $language) {{ $language->language == "mazedonisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="mazedonisch">Mazedonisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="portugiesisch" id="portugiesisch" name="language[]" @foreach($languages as $language) {{ $language->language == "portugiesisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="portugiesisch">Portugiesisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="turkisch" id="turkisch" name="language[]" @foreach($languages as $language) {{ $language->language == "turkisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="turkisch">Türkisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="skroatisch" id="skroatisch" name="language[]" @foreach($languages as $language) {{ $language->language == "skroatisch" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="skroatisch">Serbo-Kroatisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="spanich" id="spanich" name="language[]" @foreach($languages as $language) {{ $language->language == "spanich" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="spanich">Spanich</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="deutschalb" id="deutschalb" name="language[]" @foreach($languages as $language) {{ $language->language == "deutschalb" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="deutschalb">Deutsch Albanisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="deutschen" id="deutschen" name="language[]" @foreach($languages as $language) {{ $language->language == "deutschen" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="deutschen">Deutsch Englisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="andere" id="andere" name="language[]" @foreach($languages as $language) {{ $language->language == "andere" ? 'checked' : '' }} @endforeach>
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="andere">Andere</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="autoversicherung">Autoversicherung</label>
                            <select required name="autoversicherung" id="autoversicherung" class="form-control{{ $errors->has('autoversicherung') ? ' is-invalid' : '' }}" >
                                <option value="Keine" {{ $lead->autoversicherung == "Keine" ? 'selected' : '' }}>Keine</option>
                                <option value="Alliany" {{ $lead->autoversicherung == "Alliany" ? 'selected' : '' }}>Alliany</option>
                                <option value="AXA" {{ $lead->autoversicherung == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="Basler" {{ $lead->autoversicherung == "Basler" ? 'selected' : '' }}>Basler</option>
                                <option value="click2drive" {{ $lead->autoversicherung == "click2drive" ? 'selected' : '' }}>click2drive</option>
                                <option value="Dextra" {{ $lead->autoversicherung == "Dextra" ? 'selected' : '' }}>Dextra</option>
                                <option value="Mobiliar" {{ $lead->autoversicherung == "Mobiliar" ? 'selected' : '' }}>Mobiliar</option>
                                <option value="ELVIA" {{ $lead->autoversicherung == "ELVIA" ? 'selected' : '' }}>ELVIA</option>
                                <option value="Generali" {{ $lead->autoversicherung == "Generali" ? 'selected' : '' }}>Generali</option>
                                <option value="Helvetia" {{ $lead->autoversicherung == "Helvetia" ? 'selected' : '' }}>Helvetia</option>
                                <option value="smile" {{ $lead->autoversicherung == "smile" ? 'selected' : '' }}>smile</option>
                                <option value="Sympany" {{ $lead->autoversicherung == "Sympany" ? 'selected' : '' }}>Sympany</option>
                                <option value="TCS" {{ $lead->autoversicherung == "TCS" ? 'selected' : '' }}>TCS</option>
                                <option value="PostFinance" {{ $lead->autoversicherung == "PostFinance" ? 'selected' : '' }}>PostFinance</option>
                                <option value="Vaudoise" {{ $lead->autoversicherung == "Vaudoise" ? 'selected' : '' }}>Vaudoise</option>
                                <option value="Zurich" {{ $lead->autoversicherung == "Zurich" ? 'selected' : '' }}>Zurich</option>
                            </select>
                            @if ($errors->has('autoversicherung'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('autoversicherung') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="hausrat_privathaftpflicht">Hausrat Privathaftpflicht</label>
                            <select required name="hausrat_privathaftpflicht" id="hausrat_privathaftpflicht" class="form-control{{ $errors->has('hausrat_privathaftpflicht') ? ' is-invalid' : '' }}" >
                                <option value="Keine" {{ $lead->hausrat_privathaftpflicht == "Keine" ? 'selected' : '' }}>Keine</option>
                                <option value="Allianz" {{ $lead->hausrat_privathaftpflicht == "Allianz" ? 'selected' : '' }}>Allianz</option>
                                <option value="AXA" {{ $lead->hausrat_privathaftpflicht == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="CSS" {{ $lead->hausrat_privathaftpflicht == "CSS" ? 'selected' : '' }}>CSS</option>
                                <option value="ELVIA" {{ $lead->hausrat_privathaftpflicht == "ELVIA" ? 'selected' : '' }}>ELVIA</option>
                                <option value="Generali" {{ $lead->hausrat_privathaftpflicht == "Generali" ? 'selected' : '' }}>Generali</option>
                                <option value="Helvetia" {{ $lead->hausrat_privathaftpflicht == "Helvetia" ? 'selected' : '' }}>Helvetia</option>
                                <option value="smile" {{ $lead->hausrat_privathaftpflicht == "smile" ? 'selected' : '' }}>smile</option>
                                <option value="Visana" {{ $lead->hausrat_privathaftpflicht == "Visana" ? 'selected' : '' }}>Visana</option>
                                <option value="Zurich" {{ $lead->hausrat_privathaftpflicht == "Zurich" ? 'selected' : '' }}>Zurich</option>
                            </select>
                            @if ($errors->has('hausrat_privathaftpflicht'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('hausrat_privathaftpflicht') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lebensversicherung">Lebensversicherung</label>
                            <select required name="lebensversicherung" id="lebensversicherung" class="form-control{{ $errors->has('lebensversicherung') ? ' is-invalid' : '' }}" >
                                <option value="Andere" {{ $lead->lebensversicherung == "Andere" ? 'selected' : '' }}>Andere</option>
                                <option value="Allianz" {{ $lead->lebensversicherung == "Allianz" ? 'selected' : '' }}>Allianz</option>
                                <option value="AXA" {{ $lead->lebensversicherung == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="Generali" {{ $lead->lebensversicherung == "Generali" ? 'selected' : '' }}>Generali</option>
                                <option value="Groupe Mutuel" {{ $lead->lebensversicherung == "Groupe Mutuel" ? 'selected' : '' }}>Groupe Mutuel</option>
                                <option value="Helvetia" {{ $lead->lebensversicherung == "Helvetia" ? 'selected' : '' }}>Helvetia</option>
                                <option value="Liechtenstein" {{ $lead->lebensversicherung == "Liechtenstein" ? 'selected' : '' }}>Liechtenstein</option>
                                <option value="Skandia" {{ $lead->lebensversicherung == "Skandia" ? 'selected' : '' }}>Skandia</option>
                                <option value="Swiss Life" {{ $lead->lebensversicherung == "Swiss Life" ? 'selected' : '' }}>Swiss Life</option>
                                <option value="PAX" {{ $lead->lebensversicherung == "PAX" ? 'selected' : '' }}>PAX</option>
                            </select>
                            @if ($errors->has('lebensversicherung'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lebensversicherung') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rechtsschutzversicherung">Rechtsschutzversicherung</label>
                            <select required name="rechtsschutzversicherung" id="rechtsschutzversicherung" class="form-control{{ $errors->has('rechtsschutzversicherung') ? ' is-invalid' : '' }}" >
                                <option value="Andere" {{ $lead->rechtsschutzversicherung == "Andere" ? 'selected' : '' }}>Andere</option>
                                <option value="AXA" {{ $lead->rechtsschutzversicherung == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="Basler" {{ $lead->rechtsschutzversicherung == "Basler" ? 'selected' : '' }}>Basler</option>
                                <option value="CAP" {{ $lead->rechtsschutzversicherung == "CAP" ? 'selected' : '' }}>CAP</option>
                                <option value="CSS" {{ $lead->rechtsschutzversicherung == "CSS" ? 'selected' : '' }}>CSS</option>
                                <option value="Coop" {{ $lead->rechtsschutzversicherung == "Coop" ? 'selected' : '' }}>Coop</option>
                                <option value="DAS" {{ $lead->rechtsschutzversicherung == "DAS" ? 'selected' : '' }}>DAS</option>
                                <option value="Dextra" {{ $lead->rechtsschutzversicherung == "Dextra" ? 'selected' : '' }}>Dextra</option>
                                <option value="Fortuna" {{ $lead->rechtsschutzversicherung == "Fortuna" ? 'selected' : '' }}>Fortuna</option>
                                <option value="Groupe Mutuel" {{ $lead->rechtsschutzversicherung == "Groupe Mutuel" ? 'selected' : '' }}>Groupe Mutuel</option>
                                <option value="National Siusse" {{ $lead->rechtsschutzversicherung == "National Siusse" ? 'selected' : '' }}>National Siusse</option>
                                <option value="Justis" {{ $lead->rechtsschutzversicherung == "Justis" ? 'selected' : '' }}>Justis</option>
                                <option value="TCS" {{ $lead->rechtsschutzversicherung == "TCS" ? 'selected' : '' }}>TCS</option>
                                <option value="Orion" {{ $lead->rechtsschutzversicherung == "Orion" ? 'selected' : '' }}>Orion</option>
                                <option value="Protekta" {{ $lead->rechtsschutzversicherung == "Protekta" ? 'selected' : '' }}>Protekta</option>
                            </select>
                            @if ($errors->has('rechtsschutzversicherung'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('rechtsschutzversicherung') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="krankenversicherung">Krankenversicherung</label>
                            <select required name="krankenversicherung" id="krankenversicherung" class="form-control{{ $errors->has('krankenversicherung') ? ' is-invalid' : '' }}">
                                <option value="">Select Company</option>
                                <option value="CSS" @if($lead->krankenversicherung == "CSS") selected @endif >CSS</option>
                                <option value="Helsana" @if($lead->krankenversicherung == "Helsana") selected @endif >Helsana</option>
                                <option value="Swica" @if($lead->krankenversicherung == "Swica") selected @endif >Swica</option>
                                <option value="Concordia" @if($lead->krankenversicherung == "Concordia") selected @endif >Concordia</option>
                                <option value="Visana" @if($lead->krankenversicherung == "Visana") selected @endif >Visana</option>
                                <option value="Assura" @if($lead->krankenversicherung == "Assura") selected @endif >Assura</option>
                                <option value="Sanitas" @if($lead->krankenversicherung == "Sanitas") selected @endif >Sanitas</option>
                                <option value="Intras" @if($lead->krankenversicherung == "Intras") selected @endif >Intras</option>
                                <option value="Progres" @if($lead->krankenversicherung == "Progres") selected @endif >Progres</option>
                                <option value="KPT" @if($lead->krankenversicherung == "KPT") selected @endif >KPT</option>
                                <option value="Groupe Mutuel" @if($lead->krankenversicherung == "Groupe Mutuel") selected @endif >Groupe Mutuel</option>
                                <option value="Wincare" @if($lead->krankenversicherung == "Wincare") selected @endif >Wincare</option>
                                <option value="Atupri" @if($lead->krankenversicherung == "Atupri") selected @endif >Atupri</option>
                                <option value="EGK" @if($lead->krankenversicherung == "EGK") selected @endif >EGK</option>
                                <option value="Sympany" @if($lead->krankenversicherung == "Sympany") selected @endif >Sympany</option>
                                <option value="Sansan" @if($lead->krankenversicherung == "Sansan") selected @endif >Sansan</option>
                                <option value="Philos-Groupe Mutuel" @if($lead->krankenversicherung == "Philos-Groupe Mutuel") selected @endif >Philos-Groupe Mutuel</option>
                                <option value="Agrisano" @if($lead->krankenversicherung == "Agrisano") selected @endif >Agrisano</option>
                                <option value="Avenir-Groupe Mutuel" @if($lead->krankenversicherung == "Avenir-Groupe Mutuel") selected @endif >Avenir-Groupe Mutuel</option>
                                <option value="SKBH-Groupe Mutuel" @if($lead->krankenversicherung == "SKBH-Groupe Mutuel") selected @endif >SKBH-Groupe Mutuel</option>
                                <option value="Caisse-Groupe Mutuel" @if($lead->krankenversicherung == "Caisse-Groupe Mutuel") selected @endif >Caisse-Groupe Mutuel</option>
                                <option value="La Caisse Vaudoise-Groupe Mutuel" @if($lead->krankenversicherung == "La Caisse Vaudoise-Groupe Mutuel") selected @endif >La Caisse Vaudoise-Groupe Mutuel</option>
                                <option value="Avanex-Helsana" @if($lead->krankenversicherung == "Avanex-Helsana") selected @endif >Avanex-Helsana</option>
                                <option value="Hermes-Groupe Mutuel" @if($lead->krankenversicherung == "Hermes-Groupe Mutuel") selected @endif >Hermes-Groupe Mutuel</option>
                                <option value="Provita" @if($lead->krankenversicherung == "Provita") selected @endif >Provita</option>
                                <option value="Supra" @if($lead->krankenversicherung == "Supra") selected @endif >Supra</option>
                                <option value="Innova" @if($lead->krankenversicherung == "Innova") selected @endif >Innova</option>
                                <option value="Arcosana" @if($lead->krankenversicherung == "Arcosana") selected @endif >Arcosana</option>
                                <option value="Xundheit" @if($lead->krankenversicherung == "Xundheit") selected @endif >Xundheit</option>
                                <option value="Aerosana-Helsana" @if($lead->krankenversicherung == "Aerosana-Helsana") selected @endif >Aerosana-Helsana</option>
                                <option value="Kolping" @if($lead->krankenversicherung == "Kolping") selected @endif >Kolping</option>
                                <option value="Aquilana" @if($lead->krankenversicherung == "Aquilana") selected @endif >Aquilana</option>
                                <option value="Sumiswalder" @if($lead->krankenversicherung == "Sumiswalder") selected @endif >Sumiswalder</option>
                                <option value="Panorama-Groupe Mutuel" @if($lead->krankenversicherung == "Panorama-Groupe Mutuel") selected @endif >Panorama-Groupe Mutuel</option>
                                <option value="Carena" @if($lead->krankenversicherung == "Carena") selected @endif >Carena</option>
                                <option value="Auxilia" @if($lead->krankenversicherung == "Auxilia") selected @endif >Auxilia</option>
                                <option value="Easy Sana-Groupe Mutuel" @if($lead->krankenversicherung == "Easy Sana-Groupe Mutuel") selected @endif >Easy Sana-Groupe Mutuel</option>
                                <option value="KLuG" @if($lead->krankenversicherung == "KLuG") selected @endif >KLuG</option>
                                <option value="Luzerner Hinterland" @if($lead->krankenversicherung == "Luzerner Hinterland") selected @endif >Luzerner Hinterland</option>
                                <option value="Sodalis" @if($lead->krankenversicherung == "Sodalis") selected @endif >Sodalis</option>
                                <option value="SLKK" @if($lead->krankenversicherung == "SLKK") selected @endif >SLKK</option>
                                <option value="Galenos" @if($lead->krankenversicherung == "Galenos") selected @endif >Galenos</option>
                                <option value="Avantis-Groupe Mutuel" @if($lead->krankenversicherung == "Avantis-Groupe Mutuel") selected @endif >Avantis-Groupe Mutuel</option>
                                <option value="Rhenusana" @if($lead->krankenversicherung == "Rhenusana") selected @endif >Rhenusana</option>
                                <option value="KMU" @if($lead->krankenversicherung == "KMU") selected @endif >KMU</option>
                                <option value="Steffisburg" @if($lead->krankenversicherung == "Steffisburg") selected @endif >Steffisburg</option>
                                <option value="Cervino" @if($lead->krankenversicherung == "Cervino") selected @endif >Cervino</option>
                                <option value="Malters" @if($lead->krankenversicherung == "Malters") selected @endif >Malters</option>
                                <option value="Vita Surselva" @if($lead->krankenversicherung == "Vita Surselva") selected @endif >Vita Surselva</option>
                                <option value="Sana24" @if($lead->krankenversicherung == "Sana24") selected @endif >Sana24</option>
                                <option value="Birchmeier" @if($lead->krankenversicherung == "Birchmeier") selected @endif >Birchmeier</option>
                                <option value="SanaTop" @if($lead->krankenversicherung == "SanaTop") selected @endif >SanaTop</option>
                                <option value="Wdenswil" @if($lead->krankenversicherung == "Wdenswil") selected @endif >Wdenswil</option>
                                <option value="Publisana" @if($lead->krankenversicherung == "Publisana") selected @endif >Publisana</option>
                                <option value="Elm" @if($lead->krankenversicherung == "Elm") selected @endif >Elm</option>
                                <option value="Einsiedeln" @if($lead->krankenversicherung == "Einsiedeln") selected @endif >Einsiedeln</option>
                                <option value="Lumnezia" @if($lead->krankenversicherung == "Lumnezia") selected @endif >Lumnezia</option>
                            </select>
                            @if ($errors->has('krankenversicherung'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('krankenversicherung') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vertrag_seit_wann">Vertrag Seit wann</label>
                            <input type="text" name="vertrag_seit_wann" class="form-control{{ $errors->has('vertrag_seit_wann') ? ' is-invalid' : '' }}" value="{{ $lead->vertrag_seit_wann }}">
                            @if ($errors->has('vertrag_seit_wann'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('vertrag_seit_wann') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="letzte_optimierung">Letzte Optimierung</label>
                            <input type="text" name="letzte_optimierung" class="form-control{{ $errors->has('letzte_optimierung') ? ' is-invalid' : '' }}" value="{{ $lead->letzte_optimierung }}">
                            @if ($errors->has('letzte_optimierung'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('letzte_optimierung') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="anzahl_personen">Anzahl Personen</label>
                            <input type="text" name="anzahl_personen" class="form-control{{ $errors->has('anzahl_personen') ? ' is-invalid' : '' }}" value="{{ $lead->anzahl_personen }}">
                            @if ($errors->has('anzahl_personen'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('anzahl_personen') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="anruf_erwunscht">Anruf Erwünscht</label>
                            <input type="text" name="anruf_erwunscht" id="timepicker" class="form-control{{ $errors->has('anruf_erwunscht') ? ' is-invalid' : '' }}" value="{{ $lead->anruf_erwünscht }}" autocomplete="off">
                            @if ($errors->has('anruf_erwunscht'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('anruf_erwunscht') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ereichbar">Ereichbar</label>
                            <select name="ereichbar" id="ereichbar" class="form-control{{ $errors->has('ereichbar') ? ' is-invalid' : '' }}">
                                <option value="">Select Ereichbar</option>
                                <option value="Vormittag" @if($lead->ereichbar == "Vormittag") selected @endif >Vormittag</option>
                                <option value="Nachmittag" @if($lead->ereichbar == "Nachmittag") selected @endif >Nachmittag</option>
                                <option value="Abend" @if($lead->ereichbar == "Abend") selected @endif >Abend</option>
                            </select>
                            @if ($errors->has('ereichbar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('ereichbar') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @hasrole('Administrator|Call Center Admin|Quality Controll')
                        <div class="col-md-6 form-group mt-1 single-select-control">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Angenommen-JA" @if($lead->status == "Angenommen-JA") selected @endif> Angenommen-JA </option>
                                <option value="Angenommen-NEIN" @if($lead->status == "Angenommen-NEIN") selected @endif> Angenommen-NEIN </option>
                                <option value="Abgelehnt" @if($lead->status == "Abgelehnt") selected @endif> Abgelehnt </option>
                            </select>
                        </div>
                    @endhasrole
                    @hasrole('Administrator|Call Center Admin|Quality Controll')
                        <div class="col-md-6">
                            <div class="col mt-4 custom-control custom-checkbox under-checkbox">
                                <input type="checkbox" class="check custom-control-input" id="commentAccessCC" name="commentAccessCC" {{$lead->qccomment_access_cc ? 'checked' : ''}}>
                                <label class="custom-control-label checkbox-inline costumcheckbox1" for="commentAccessCC" >Enable comments for Call Center</label>
                            </div>
                            <div class="col mt-4 custom-control custom-checkbox under-checkbox">
                                <input type="checkbox" class="check custom-control-input" id="commentAccessBr" name="commentAccessBr" {{$lead->qccomment_access_br ? 'checked' : ''}}>
                                <label class="custom-control-label checkbox-inline costumcheckbox1" for="commentAccessBr" >Enable comments for Broker</label>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="comment">Quality Controll Kommentar</label>
                            <textarea class="form-control{{ $errors->has('qcComment') ? ' is-invalid' : '' }}" name="qcComment" rows="3"></textarea>
                            @if ($errors->has('qcComment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('qcComment') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col mt-4">
                            @foreach($multipleComments as $key => $multipeComment)
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
                        @if($lead->qccomment_access_br == 1)
                            <div class="col mt-4">
                                @foreach($multipleComments as $key => $multipeComment)
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
                        @if($lead->qccomment_access_cc == 1)
                            <div class="col mt-4">
                                @foreach($multipleComments as $key => $multipeComment)
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
                    <div class=" mt-4 col-md-12">
                        <div class="form-group">
                            <label for="comment">Bemerkung</label>
                            <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" name="comment" rows="5">{{ $lead->comment }}</textarea>
                            @if ($errors->has('comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12 appointmentbuttons">
                        <a href="{{ route('leads.index') }}" class="btn btn-danger px-5 mr-2"><b>Abbrechen</b></a>
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
$(document).ready(function () {

    $('.mobile_number').mask('000 000 00 00');
    // $('.mobile_number').val('0');
    $('.phone_number').mask('000 000 00 00');
    // $('.phone_number').val('0');
    $('.post_code').mask('0000');

    $('.house_number').mask('AAAA', {'translation': {
            A: {pattern: /[A-Za-z0-9.\-\/]/},
        }
    });

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
    @hasrole('Agent Team Leader|Agent|Berater Team Leader|Berater')
        $('input').attr('readonly', true)
        $('select').attr('readonly', true)
        $('input[type=checkbox]').attr('disabled', true);
        $('textarea').attr('readonly', true)
        $('button[type=submit]').remove()
    @endhasrole
});

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
            url: '/lead/'+thisCommentId+'/comment/edit',
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
            url: '/lead/'+thisCommentId+'/comment/delete',
            success: function () {
                deleteComment.remove() // remove row form table after delete
                toastr.success('Comment Deleted', {timeOut:5000})
                // rowCss.css("border-bottom", "1px solid #dee2e6") /// set borders for <tr></tr>
            },
        });
@endhasrole
        });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
@endsection
