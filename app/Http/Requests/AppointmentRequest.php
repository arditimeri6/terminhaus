<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\PhoneServiceProvider;

class AppointmentRequest extends FormRequest
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
            'first_name' => 'required|string|max:191|regex:/[a-z]/|regex:/[A-Z]/',
            'last_name' => 'required|string|max:191|regex:/[a-z]/|regex:/[A-Z]/',
            'street' => 'required|max:191',
            'lat' => 'required',
            'lng' => 'required',
            'post_code' => 'required|numeric|max:9999',
            'canton' => 'required|in:Aargau,Appenzell Ausserrhoden,Appenzell Innerrhoden,Basel-Stadt,Basel-Landschaft,Bern,Fribourg,Geneva,Glarus,Graubünden,Jura,Lucerne,Neuchâtel,Nidwalden,Obwalden,Schaffhausen,Schwyz,Solothurn,St. Gallen,Thurgau,Ticino,Uri,Valais,Vaud,Zug,Zürich',
            'language' => 'required|in:DE,FR,IT,AL,ESP,SRB,TR,Other',
            'date' => 'required|date_format:d/m/Y|after:yesterday',
            'file.*' => 'mimes:jpeg,png,jpg,mpga|max:20000',
            'comment' => 'max:500',
            'mobile_number' =>  'nullable|max:191',
            'phone_number' =>  'nullable|max:191',
            'house_number' =>  'required',
            'member-salutation.*' => 'required|in:Herr,Frau,Kind,Schwiegertochter,Neffe',
            'member-first-name.*' => 'required|max:191',
            'member-birth-year.*' => 'required|max:191',
            'member-contract-duration.*' => 'required|max:191',
            'member-behandlung.*' => 'required|in:Gesund,Behandlung',
        ];
    }

    public function messages()
    {
        return[
            'salutation.required' => 'Bitte wählen Sie eine Option',
            'salutation.in' => 'Der Wert ist ungültig',
            'first_name.required' => 'Bitte geben deinen Namen an',
            'first_name.max' => 'Der Name muss kürzer sein',
            'first_name.regex' => 'Der Name darf nur aus Buchstaben bestehen',
            'street.required' => 'Bitte schreiben Sie Ihre Adresse',
            'street.max' => 'Die Adresse muss kürzer sein',
            'post_code.required' => 'Bitte geben Sie Ihre Postleitzahl ein',
            'post_code.numeric' => 'Postleitzahl darf nur Zahlen haben',
            'post_code.max' => 'Postleitzahl muss kürzer sein',
            'canton.required' => 'Bitte wählen Sie Ihren Kanton aus',
            'canton.in' => 'Der Wert ist ungültig',
            'language.required' => 'Sprachauswahl',
            'language.in' => 'Der Wert ist ungültig',
            'date.required' => 'Bitte wählen Sie das Datum aus',
            'date.date_format' => 'Bitte wähle ein gültiges Datum aus',
            'date.after' => 'Bitte wählen Sie ein Datum, das nicht vergangen ist',
            'comment.max' => 'Der Kommentar kürzer sein',
            'file.*.mimes' => 'Nur Bilder oder Audio erlaubt',
            'file.*.max' => 'Bitte wählen Sie kleinere Fotos',
            'mobile_number.phone' => 'Ungültige Nummer',
            'phone_number.phone' => 'Ungültige Nummer',
            'house_number.required' => 'Bitte geben deinen Hausnummer an',
            'member-first-name.required.*' => 'Dieses Feld ist erforderlich',
            'member-last-name.required.*' => 'Dieses Feld ist erforderlich',
            'member-birth-year.required.*' => 'Dieses Feld ist erforderlich',
            'member-contract-duration.required.*' => 'Dieses Feld ist erforderlich',
        ];
    }
}
