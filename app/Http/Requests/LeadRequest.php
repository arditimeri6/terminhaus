<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'salutation' => 'required|in:Herr,Frau',
            'kunden_type' => 'required|in:Privatgelände,Unternehmen',
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'year' => 'max:191',
            'mobile_number' => 'max:191',
            'house_number' => 'max:191',
            'street' => 'required|max:191',
            'post_code' => 'required|numeric|max:9999',
            'place' => 'required|max:191',
            'canton' => 'required|in:Aargau,Appenzell Ausserrhoden,Appenzell Innerrhoden,Basel-Stadt,Basel-Landschaft,Bern,Fribourg,Geneva,Glarus,Graubünden,Jura,Lucerne,Neuchâtel,Nidwalden,Obwalden,Schaffhausen,Schwyz,Solothurn,St. Gallen,Thurgau,Ticino,Uri,Valais,Vaud,Zug,Zürich',
            'autoversicherung' => 'in:Keine,Alliany,AXA,Basler,Click2drive,Dextra,Mobiliar,ELVIA,Generali,Helvetia,Smile,Sympany,TCS,PostFinance,Vaudoise,Zurich',
            'hausrat_privathaftpflicht' => 'in:Keine,Allianz,AXA,CSS,ELVIA,Generali,Helvetia,Smile,Visana,Zurich',
            'lebensversicherung' => 'in:Andere,Allianz,AXA,Generali,Groupe Mutuel,Helvetia,Liechtenstein,Skandia,Swiss Life,PAX',
            'rechtsschutzversicherung' => 'in:Andere,AXA,Basler,CAP,CSS,Coop,DAS,Dextra,Fortuna,Groupe Mutuel,National Siusse,Justis,TCS,Orion,Protekta',
            'vertrag_seit_wann' => 'max:191',
            'letzte_optimierung' => 'max:191',
            'anzahl_personen' => 'max:191',
            'anruf_erwünscht' => 'max:5',
            'ereichbar' => 'in:Vormittag,Nachmittag,Abend',
            'comment' => 'max:500'
        ];
    }

    public function messages()
    {
        return[
            'salutation.required' => 'Bitte wählen Sie eine Option',
            'salutation.in' => 'Der Wert ist ungültig',
        ];
    }
}
