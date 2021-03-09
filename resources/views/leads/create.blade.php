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
            <form method="post" action="{{ route('store.lead') }}" class="needs-validation" novalidate>
            @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kunden_type">Kundentyp</label>
                            <select required name="kunden_type" id="kunden_type" class="form-control{{ $errors->has('kunden_type') ? ' is-invalid' : '' }}" >
                                <option value="">Kundentyp auswählen</option>
                                <option value="Privatgelände" {{ old('kunden_type') == "Privatgelände" ? 'selected' : '' }}>Privatgelände</option>
                                <option value="Unternehmen" {{ old('kunden_type') == "Unternehmen" ? 'selected' : '' }}>Unternehmen</option>
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Vorname</label>
                            <input required type="text" name="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ old('first_name') }}">
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
                            <input required type="text" name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}">
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
                            <input required type="text" id="yearpicker" name="year" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ old('year') }}">
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
                            <input required type="text" name="mobile_number" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }} mobile_number" value="{{ old('mobile_number') }}">
                            @if ($errors->has('mobile_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile_number') }}</strong>
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
                            <label for="house_number">Haus Nummer</label>
                            <input type="text" name="house_number" class="form-control{{ $errors->has('house_number') ? ' is-invalid' : '' }} house_number" value="{{ old('house_number') }}">
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
                            <input required type="text" name="street" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" value="{{ old('street') }}">
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
                            <input required type="number" name="post_code" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }} post_code" value="{{ old('post_code') }}">
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
                            <input required type="text" name="place" class="form-control{{ $errors->has('place') ? ' is-invalid' : '' }}" value="{{ old('place') }}">
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
                    </div>
                    <div class="col-md-6" id="company_field">
                        <div class="form-group">
                            <label for="company_name">Name der Firma</label>
                            <input type="text" name="company_name" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" value="{{ old('company_name') }}">
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
                            <input type="checkbox" class="custom-control-input" value="deutsch" id="deutsch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="deutsch">Deutsch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="italienisch" id="italienisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="italienisch">Italienisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="franzosisch" id="franzosisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="franzosisch">Französisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="englisch" id="englisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="englisch">Englisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="albanisch" id="albanisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="albanisch">Albanisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="arabisch" id="arabisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="arabisch">Arabisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="bosnisch" id="bosnisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="bosnisch">Bosnisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="bulgarisch" id="bulgarisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="bulgarisch">Bulgarisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="kurdisch" id="kurdisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="kurdisch">Kurdisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="mazedonisch" id="mazedonisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="mazedonisch">Mazedonisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="portugiesisch" id="portugiesisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="portugiesisch">Portugiesisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="turkisch" id="turkisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="turkisch">Türkisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="skroatisch" id="skroatisch" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="skroatisch">Serbo-Kroatisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="spanich" id="spanich" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="spanich">Spanich</label>
                            </div>


                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="deutschalb" id="deutschalb" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="deutschalb">Deutsch Albanisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="deutschen" id="deutschen" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="deutschen">Deutsch Englisch</label>
                            </div>

                            <div class="custom-control custom-checkbox languagestyle">
                            <input type="checkbox" class="custom-control-input" value="andere" id="andere" name="language[]">
                            <label class="custom-control-label checkbox-inline costumcheckbox1" for="andere">Andere</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="autoversicherung">Autoversicherung</label>
                            <select required name="autoversicherung" id="autoversicherung" class="form-control{{ $errors->has('autoversicherung') ? ' is-invalid' : '' }}" >
                                <option value="Keine" {{ old('autoversicherung') == "Keine" ? 'selected' : '' }}>Keine</option>
                                <option value="Alliany" {{ old('autoversicherung') == "Alliany" ? 'selected' : '' }}>Alliany</option>
                                <option value="AXA" {{ old('autoversicherung') == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="Basler" {{ old('autoversicherung') == "Basler" ? 'selected' : '' }}>Basler</option>
                                <option value="Click2drive" {{ old('autoversicherung') == "Click2drive" ? 'selected' : '' }}>Click2drive</option>
                                <option value="Dextra" {{ old('autoversicherung') == "Dextra" ? 'selected' : '' }}>Dextra</option>
                                <option value="Mobiliar" {{ old('autoversicherung') == "Mobiliar" ? 'selected' : '' }}>Mobiliar</option>
                                <option value="ELVIA" {{ old('autoversicherung') == "ELVIA" ? 'selected' : '' }}>ELVIA</option>
                                <option value="Generali" {{ old('autoversicherung') == "Generali" ? 'selected' : '' }}>Generali</option>
                                <option value="Helvetia" {{ old('autoversicherung') == "Helvetia" ? 'selected' : '' }}>Helvetia</option>
                                <option value="Smile" {{ old('autoversicherung') == "Smile" ? 'selected' : '' }}>Smile</option>
                                <option value="Sympany" {{ old('autoversicherung') == "Sympany" ? 'selected' : '' }}>Sympany</option>
                                <option value="TCS" {{ old('autoversicherung') == "TCS" ? 'selected' : '' }}>TCS</option>
                                <option value="PostFinance" {{ old('autoversicherung') == "PostFinance" ? 'selected' : '' }}>PostFinance</option>
                                <option value="Vaudoise" {{ old('autoversicherung') == "Vaudoise" ? 'selected' : '' }}>Vaudoise</option>
                                <option value="Zurich" {{ old('autoversicherung') == "Zurich" ? 'selected' : '' }}>Zurich</option>
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
                                <option value="Keine" {{ old('hausrat_privathaftpflicht') == "Keine" ? 'selected' : '' }}>Keine</option>
                                <option value="Allianz" {{ old('hausrat_privathaftpflicht') == "Allianz" ? 'selected' : '' }}>Allianz</option>
                                <option value="AXA" {{ old('hausrat_privathaftpflicht') == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="CSS" {{ old('hausrat_privathaftpflicht') == "CSS" ? 'selected' : '' }}>CSS</option>
                                <option value="ELVIA" {{ old('hausrat_privathaftpflicht') == "ELVIA" ? 'selected' : '' }}>ELVIA</option>
                                <option value="Generali" {{ old('hausrat_privathaftpflicht') == "Generali" ? 'selected' : '' }}>Generali</option>
                                <option value="Helvetia" {{ old('hausrat_privathaftpflicht') == "Helvetia" ? 'selected' : '' }}>Helvetia</option>
                                <option value="Smile" {{ old('hausrat_privathaftpflicht') == "Smile" ? 'selected' : '' }}>Smile</option>
                                <option value="Visana" {{ old('hausrat_privathaftpflicht') == "Visana" ? 'selected' : '' }}>Visana</option>
                                <option value="Zurich" {{ old('hausrat_privathaftpflicht') == "Zurich" ? 'selected' : '' }}>Zurich</option>
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
                                <option value="Andere" {{ old('lebensversicherung') == "Andere" ? 'selected' : '' }}>Andere</option>
                                <option value="Allianz" {{ old('lebensversicherung') == "Allianz" ? 'selected' : '' }}>Allianz</option>
                                <option value="AXA" {{ old('lebensversicherung') == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="Generali" {{ old('lebensversicherung') == "Generali" ? 'selected' : '' }}>Generali</option>
                                <option value="Groupe Mutuel" {{ old('lebensversicherung') == "Groupe Mutuel" ? 'selected' : '' }}>Groupe Mutuel</option>
                                <option value="Helvetia" {{ old('lebensversicherung') == "Helvetia" ? 'selected' : '' }}>Helvetia</option>
                                <option value="Liechtenstein" {{ old('lebensversicherung') == "Liechtenstein" ? 'selected' : '' }}>Liechtenstein</option>
                                <option value="Skandia" {{ old('lebensversicherung') == "Skandia" ? 'selected' : '' }}>Skandia</option>
                                <option value="Swiss Life" {{ old('lebensversicherung') == "Swiss Life" ? 'selected' : '' }}>Swiss Life</option>
                                <option value="PAX" {{ old('lebensversicherung') == "PAX" ? 'selected' : '' }}>PAX</option>
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
                                <option value="Andere" {{ old('rechtsschutzversicherung') == "Andere" ? 'selected' : '' }}>Andere</option>
                                <option value="AXA" {{ old('rechtsschutzversicherung') == "AXA" ? 'selected' : '' }}>AXA</option>
                                <option value="Basler" {{ old('rechtsschutzversicherung') == "Basler" ? 'selected' : '' }}>Basler</option>
                                <option value="CAP" {{ old('rechtsschutzversicherung') == "CAP" ? 'selected' : '' }}>CAP</option>
                                <option value="CSS" {{ old('rechtsschutzversicherung') == "CSS" ? 'selected' : '' }}>CSS</option>
                                <option value="Coop" {{ old('rechtsschutzversicherung') == "Coop" ? 'selected' : '' }}>Coop</option>
                                <option value="DAS" {{ old('rechtsschutzversicherung') == "DAS" ? 'selected' : '' }}>DAS</option>
                                <option value="Dextra" {{ old('rechtsschutzversicherung') == "Dextra" ? 'selected' : '' }}>Dextra</option>
                                <option value="Fortuna" {{ old('rechtsschutzversicherung') == "Fortuna" ? 'selected' : '' }}>Fortuna</option>
                                <option value="Groupe Mutuel" {{ old('rechtsschutzversicherung') == "Groupe Mutuel" ? 'selected' : '' }}>Groupe Mutuel</option>
                                <option value="National Siusse" {{ old('rechtsschutzversicherung') == "National Siusse" ? 'selected' : '' }}>National Siusse</option>
                                <option value="Justis" {{ old('rechtsschutzversicherung') == "Justis" ? 'selected' : '' }}>Justis</option>
                                <option value="TCS" {{ old('rechtsschutzversicherung') == "TCS" ? 'selected' : '' }}>TCS</option>
                                <option value="Orion" {{ old('rechtsschutzversicherung') == "Orion" ? 'selected' : '' }}>Orion</option>
                                <option value="Protekta" {{ old('rechtsschutzversicherung') == "Protekta" ? 'selected' : '' }}>Protekta</option>
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
                                <option value="CSS" {{ old('krankenversicherung') == "CSS" ? 'selected' : '' }} >CSS</option>
                                <option value="Helsana" {{ old('krankenversicherung') == "Helsana" ? 'selected' : '' }} >Helsana</option>
                                <option value="Swica" {{ old('krankenversicherung') == "Swica" ? 'selected' : '' }} >Swica</option>
                                <option value="Concordia" {{ old('krankenversicherung') == "Concordia" ? 'selected' : '' }} >Concordia</option>
                                <option value="Visana" {{ old('krankenversicherung') == "Visana" ? 'selected' : '' }} >Visana</option>
                                <option value="Assura" {{ old('krankenversicherung') == "Assura" ? 'selected' : '' }} >Assura</option>
                                <option value="Sanitas" {{ old('krankenversicherung') == "Sanitas" ? 'selected' : '' }} >Sanitas</option>
                                <option value="Intras" {{ old('krankenversicherung') == "Intras" ? 'selected' : '' }} >Intras</option>
                                <option value="Progres" {{ old('krankenversicherung') == "Progres" ? 'selected' : '' }} >Progres</option>
                                <option value="KPT" {{ old('krankenversicherung') == "KPT" ? 'selected' : '' }} >KPT</option>
                                <option value="Groupe Mutuel" {{ old('krankenversicherung') == "Groupe Mutuel" ? 'selected' : '' }} >Groupe Mutuel</option>
                                <option value="Wincare" {{ old('krankenversicherung') == "Wincare" ? 'selected' : '' }} >Wincare</option>
                                <option value="Atupri" {{ old('krankenversicherung') == "Atupri" ? 'selected' : '' }} >Atupri</option>
                                <option value="EGK" {{ old('krankenversicherung') == "EGK" ? 'selected' : '' }} >EGK</option>
                                <option value="Sympany" {{ old('krankenversicherung') == "Sympany" ? 'selected' : '' }} >Sympany</option>
                                <option value="Sansan" {{ old('krankenversicherung') == "Sansan" ? 'selected' : '' }} >Sansan</option>
                                <option value="Philos-Groupe Mutuel" {{ old('krankenversicherung') == "Philos-Groupe Mutuel" ? 'selected' : '' }} >Philos-Groupe Mutuel</option>
                                <option value="Agrisano" {{ old('krankenversicherung') == "Agrisano" ? 'selected' : '' }} >Agrisano</option>
                                <option value="Avenir-Groupe Mutuel" {{ old('krankenversicherung') == "Avenir-Groupe Mutuel" ? 'selected' : '' }} >Avenir-Groupe Mutuel</option>
                                <option value="SKBH-Groupe Mutuel" {{ old('krankenversicherung') == "SKBH-Groupe Mutuel" ? 'selected' : '' }} >SKBH-Groupe Mutuel</option>
                                <option value="Caisse-Groupe Mutuel" {{ old('krankenversicherung') == "Caisse-Groupe Mutuel" ? 'selected' : '' }} >Caisse-Groupe Mutuel</option>
                                <option value="La Caisse Vaudoise-Groupe Mutuel" {{ old('krankenversicherung') == "La Caisse Vaudoise-Groupe Mutuel" ? 'selected' : '' }} >La Caisse Vaudoise-Groupe Mutuel</option>
                                <option value="Avanex-Helsana" {{ old('krankenversicherung') == "Avanex-Helsana" ? 'selected' : '' }} >Avanex-Helsana</option>
                                <option value="Hermes-Groupe Mutuel" {{ old('krankenversicherung') == "Hermes-Groupe Mutuel" ? 'selected' : '' }} >Hermes-Groupe Mutuel</option>
                                <option value="Provita" {{ old('krankenversicherung') == "Provita" ? 'selected' : '' }} >Provita</option>
                                <option value="Supra" {{ old('krankenversicherung') == "Supra" ? 'selected' : '' }} >Supra</option>
                                <option value="Innova" {{ old('krankenversicherung') == "Innova" ? 'selected' : '' }} >Innova</option>
                                <option value="Arcosana" {{ old('krankenversicherung') == "Arcosana" ? 'selected' : '' }} >Arcosana</option>
                                <option value="Xundheit" {{ old('krankenversicherung') == "Xundheit" ? 'selected' : '' }} >Xundheit</option>
                                <option value="Aerosana-Helsana" {{ old('krankenversicherung') == "Aerosana-Helsana" ? 'selected' : '' }} >Aerosana-Helsana</option>
                                <option value="Kolping" {{ old('krankenversicherung') == "Kolping" ? 'selected' : '' }} >Kolping</option>
                                <option value="Aquilana" {{ old('krankenversicherung') == "Aquilana" ? 'selected' : '' }} >Aquilana</option>
                                <option value="Sumiswalder" {{ old('krankenversicherung') == "Sumiswalder" ? 'selected' : '' }} >Sumiswalder</option>
                                <option value="Panorama-Groupe Mutuel" {{ old('krankenversicherung') == "Panorama-Groupe Mutuel" ? 'selected' : '' }} >Panorama-Groupe Mutuel</option>
                                <option value="Carena" {{ old('krankenversicherung') == "Carena" ? 'selected' : '' }} >Carena</option>
                                <option value="Auxilia" {{ old('krankenversicherung') == "Auxilia" ? 'selected' : '' }} >Auxilia</option>
                                <option value="Easy Sana-Groupe Mutuel" {{ old('krankenversicherung') == "Easy Sana-Groupe Mutuel" ? 'selected' : '' }} >Easy Sana-Groupe Mutuel</option>
                                <option value="KLuG" {{ old('krankenversicherung') == "KLuG" ? 'selected' : '' }} >KLuG</option>
                                <option value="Luzerner Hinterland" {{ old('krankenversicherung') == "Luzerner Hinterland" ? 'selected' : '' }} >Luzerner Hinterland</option>
                                <option value="Sodalis" {{ old('krankenversicherung') == "Sodalis" ? 'selected' : '' }} >Sodalis</option>
                                <option value="SLKK" {{ old('krankenversicherung') == "SLKK" ? 'selected' : '' }} >SLKK</option>
                                <option value="Galenos" {{ old('krankenversicherung') == "Galenos" ? 'selected' : '' }} >Galenos</option>
                                <option value="Avantis-Groupe Mutuel" {{ old('krankenversicherung') == "Avantis-Groupe Mutuel" ? 'selected' : '' }} >Avantis-Groupe Mutuel</option>
                                <option value="Rhenusana" {{ old('krankenversicherung') == "Rhenusana" ? 'selected' : '' }} >Rhenusana</option>
                                <option value="KMU" {{ old('krankenversicherung') == "KMU" ? 'selected' : '' }} >KMU</option>
                                <option value="Steffisburg" {{ old('krankenversicherung') == "Steffisburg" ? 'selected' : '' }} >Steffisburg</option>
                                <option value="Cervino" {{ old('krankenversicherung') == "Cervino" ? 'selected' : '' }} >Cervino</option>
                                <option value="Malters" {{ old('krankenversicherung') == "Malters" ? 'selected' : '' }} >Malters</option>
                                <option value="Vita Surselva" {{ old('krankenversicherung') == "Vita Surselva" ? 'selected' : '' }} >Vita Surselva</option>
                                <option value="Sana24" {{ old('krankenversicherung') == "Sana24" ? 'selected' : '' }} >Sana24</option>
                                <option value="Birchmeier" {{ old('krankenversicherung') == "Birchmeier" ? 'selected' : '' }} >Birchmeier</option>
                                <option value="SanaTop" {{ old('krankenversicherung') == "SanaTop" ? 'selected' : '' }} >SanaTop</option>
                                <option value="Wdenswil" {{ old('krankenversicherung') == "Wdenswil" ? 'selected' : '' }} >Wdenswil</option>
                                <option value="Publisana" {{ old('krankenversicherung') == "Publisana" ? 'selected' : '' }} >Publisana</option>
                                <option value="Elm" {{ old('krankenversicherung') == "Elm" ? 'selected' : '' }} >Elm</option>
                                <option value="Einsiedeln" {{ old('krankenversicherung') == "Einsiedeln" ? 'selected' : '' }} >Einsiedeln</option>
                                <option value="Lumnezia" {{ old('krankenversicherung') == "Lumnezia" ? 'selected' : '' }} >Lumnezia</option>
                            </select>
                            @if ($errors->has('krankenversicherung'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('krankenversicherung') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vertrag_seit_wann">Vertrag Seit wann</label>
                            <input type="text" name="vertrag_seit_wann" class="form-control{{ $errors->has('vertrag_seit_wann') ? ' is-invalid' : '' }}" value="{{ old('vertrag_seit_wann') }}">
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
                            <input type="text" name="letzte_optimierung" class="form-control{{ $errors->has('letzte_optimierung') ? ' is-invalid' : '' }}" value="{{ old('letzte_optimierung') }}">
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
                            <input type="text" name="anzahl_personen" class="form-control{{ $errors->has('anzahl_personen') ? ' is-invalid' : '' }}" value="{{ old('anzahl_personen') }}">
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
                            <input type="text" name="anruf_erwunscht" id="timepicker" class="form-control{{ $errors->has('anruf_erwunscht') ? ' is-invalid' : '' }}" value="{{ old('anruf_erwunscht') }}">
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
                            <select required name="ereichbar" id="ereichbar" class="form-control{{ $errors->has('ereichbar') ? ' is-invalid' : '' }}">
                                <option value="">Select Ereichbar</option>
                                <option value="Vormittag" {{ old('ereichbar') == "Vormittag" ? 'selected' : '' }} >Vormittag</option>
                                <option value="Nachmittag" {{ old('ereichbar') == "Nachmittag" ? 'selected' : '' }} >Nachmittag</option>
                                <option value="Abend" {{ old('ereichbar') == "Abend" ? 'selected' : '' }} >Abend</option>
                            </select>
                            @if ($errors->has('ereichbar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('ereichbar') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comment">Bemerkung</label>
                            <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" name="comment" rows="5">{{ old('comment') }}</textarea>

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
     $(document).ready(function(){
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

        $('.mobile_number').mask('000 000 00 00');
        // $('.mobile_number').val('0');
        $('.phone_number').mask('000 000 00 00');
        // $('.phone_number').val('0');
        $('.post_code').mask('0000');

        $('.house_number').mask('AAAA', {'translation': {
                A: {pattern: /[A-Za-z0-9.\-\/]/},
            }
        });

        $("#country").select2( {
            placeholder: "Kanton auswählen",
            allowClear: true
        });
        $('#company_field').addClass('hidden-field')
        $('#kunden_type').change(function(){
            if($(this).val()=='Unternehmen'){
                $('#company_field').removeClass('hidden-field')
            }else {
                $('#company_field').addClass('hidden-field')
            }
        })
        $('#yearpicker').yearpicker();

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

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
@endsection
