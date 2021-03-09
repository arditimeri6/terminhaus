<?php

namespace App\Http\Controllers;

use App\User;
use App\Kunden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;
use Yajra\DataTables\QueryDataTable;
use Illuminate\Support\Facades\Auth;

class KundensController extends Controller
{
    public function index()
    {
        return view('kunden.index');
    }
    public function getKunden()
    {
        $query = DB::table('kundens')
            ->leftJoin('users', 'kundens.berater_id', '=', 'users.id')
            ->leftJoin('client_sources', 'kundens.client_source_id', '=', 'client_sources.id')
            ->leftJoin('types_of_contracts', 'kundens.types_of_contract_id', '=', 'types_of_contracts.id')
            ->select('kundens.*','users.first_name as berater', 'client_sources.name as client_source', 'types_of_contracts.name as types_of_contract');
            return (new QueryDataTable($query))
            ->addColumn('status', ' ')
            ->addColumn('actions', '
                <a title="Bearbeiten" href="{{ route("edit.kunden", $id) }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></a>
                <!-- <a title="Upload" href="" class="btn btn-sm btn-outline-secondary"><i class="fas fa-upload"></i></a>
                <a title="Status of documents" href="" class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-alt"></i></a> -->
                ')
            ->setRowId('{{$id}}')
            ->rawColumns(['actions'])
            ->toJson();
    }
    public function create()
    {
        $beraters = User::role('Broker Direktor')->get();
        $types_of_contracts = DB::table('types_of_contracts')->get();
        $client_sources = DB::table('client_sources')->get();
        $franchises = DB::table('franchises')->get();
        $payments = DB::table('payments')->get();
        $payment_types = DB::table('payment_type')->get();
        // dd($companies);
        return view('kunden.create', [
            'beraters' => $beraters, 'types_of_contracts' => $types_of_contracts,
            'client_sources' => $client_sources, 'franchises' => $franchises,
            'payments' => $payments, 'payment_types' => $payment_types,
        ]);
    }

    public function store(Request $request)
    {
        if ($request['franchise_details']) {
            $franchise_detail = $request['franchise_details'];
        } else {
            $franchise_detail = null;
        }
        if ($request['hospitals']) {
            $hospital = $request['hospitals'];
        } else {
            $hospital = null;
        }
        if ($request['inpatient']) {
            $inpatients = $request['inpatient'];
        } else {
            $inpatients = null;
        }
        if ($request['alternative_medicals']) {
            $alternative_medicals = $request['alternative_medicals'];
        } else {
            $alternative_medicals = null;
        }
        if ($request['dentals']) {
            $dental = $request['dentals'];
        } else {
            $dental = null;
        }
        if ($request['legal']) {
            $legal = 1;
        } else {
            $legal = null;
        }
        if ($request['accident_cover']) {
            $accident_cover = 1;
        } else {
            $accident_cover = null;
        }
        if ($request['product_type']) {
            $product_type_id = $request['product_type'];
        } else {
            $product_type_id = null;
        }
        if ($request['occupation']) {
            $occupation = $request['occupation'];
        } else {
            $occupation = null;
        }
        if ($request['smoker']) {
            $smoker = $request['smoker'];
        } else {
            $smoker = null;
        }
        if ($request['options']) {
            $options_id = $request['options'];
        } else {
            $options_id = null;
        }

        // dd($request->all());
        $kunden = Kunden::create([
            'user_id' => Auth::user()->id,
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'plz' => $request['plz'],
            'ort' => $request['ort'],
            'address' => $request['adresse'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'telefon' => $request['telefon'],
            'berater_id' => $request['berater'],
            'client_source_id' => $request['client_source'],
            'types_of_contract_id' => $request['types_of_contract'],
            'company_id' => $request['company'],
            'basic_insurance_model_id' => $request['basic_insurance_model'],
            'accident_cover' => $accident_cover,
            'franchise_id' => $request['franchise'],
            'franchise_details_id' => $franchise_detail,
            'basic_insurance_start_date' => $request['basic_insurance_start_date'],
            'hospital_id' => $hospital,
            'inpatients_id' => $inpatients,
            'alternative_medical_id' => $alternative_medicals,
            'dental_id' => $dental,
            'combi' => $request['combi'],
            'accident' => $request['accident'],
            'death' => $request['death'],
            'taggeld' => $request['taggeld'],
            'other' => $request['other'],
            'legal' => $legal,
            'product_type_id' => $product_type_id,
            'insurance_commencement_date' => $request['insurance_commencement_date'],
            'duration' => $request['duration'],
            'yearly_premium' => $request['yearly_premium'],
            'monthly_premium' => $request['monthly_premium'],
            'redeemable' => $request['redeemable'],
            'occupation' => $occupation,
            'smoker' => $smoker,
            'value' => $request['value'],
            'options_id' => $options_id,
            'payment_id' => $request['payment'],
            'payment_type_id' => $request['payment_type'],
            'contract_signed_on' => $request['contract_signed_on'],
        ]);
        if ($kunden) {
            return redirect()->route('kunden.index')->with('successKunden', 'Kunden added successfully');
        }
        return redirect()->route('create.kunden')->with('errorKunden', 'Kunden was not added');
    }

    public function searchCompanies(Request $request)
    {
        $value = $request['value'];
        $data = DB::table('companies')
            ->where('types_of_contract_id', $value)
            ->get();
        $output = '<option value="">Select Company</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    public function searchfranchises(Request $request)
    {
        $value = $request['value'];
        $data = DB::table('franchise_details')
            ->where('franchise_id', $value)
            ->get();
        $output = '<option value="">Select Franchise Details</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->amount.'</option>';
        }
        echo $output;
    }

    public function searchFromCompanies(Request $request)
    {
        $value = $request['value'];
        $basic_insurance_models = DB::table('basic_insurance_models')
            ->where('company_id', $value)
            ->get();
        $basic_insurance_models_output = '<option value="">Select Basic Insurance Model</option>';
        foreach($basic_insurance_models as $row)
        {
            $basic_insurance_models_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }

        $hospitals = DB::table('hospitals')
            ->where('company_id', $value)
            ->get();
        $hospitals_output = '<option value="">Select Hospitals</option>';
        foreach($hospitals as $row)
        {
            $hospitals_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }

        $alternative_medicals = DB::table('alternative_medicals')
            ->where('company_id', $value)
            ->get();
        $alternative_medicals_output = '<option value="">Select Alternative Medicals</option>';
        foreach($alternative_medicals as $row)
        {
            $alternative_medicals_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }

        $inpatients = DB::table('inpatients')
            ->where('company_id', $value)
            ->get();
        $inpatients_output = '<option value="">Select Inpatient</option>';
        foreach($inpatients as $row)
        {
            $inpatients_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }

        $dentals = DB::table('dentals')
            ->where('company_id', $value)
            ->get();
        $dentals_output = '<option value="">Select Dentals</option>';
        foreach($dentals as $row)
        {
            $dentals_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }

        $product_types = DB::table('product_types')
            ->where('company_id', $value)
            ->get();
        $product_types_output = '<option value="">Select Product Type</option>';
        foreach($product_types as $row)
        {
            $product_types_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }

        $options = DB::table('options')
            ->where('company_id', $value)
            ->get();
        $options_output = '<option value="">Select Option</option>';
        foreach($options as $row)
        {
            $options_output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo json_encode(array($basic_insurance_models_output, $hospitals_output, $alternative_medicals_output, $inpatients_output, $dentals_output, $product_types_output, $options_output));
    }

    public function edit(Request $request, Kunden $kunden)
    {
        // dd($kunden);
        $beraters = User::role('Broker Direktor')->get();
        $types_of_contracts = DB::table('types_of_contracts')->get();
        $client_sources = DB::table('client_sources')->get();
        $franchises = DB::table('franchises')->get();
        $payments = DB::table('payments')->get();
        $payment_types = DB::table('payment_type')->get();
        $companies = DB::table('companies')->get();
        $basic_insurance_models = DB::table('basic_insurance_models')->get();
        $hospitals = DB::table('hospitals')->get();
        $alternative_medicals = DB::table('alternative_medicals')->get();
        $franchise_details = DB::table('franchise_details')->get();
        $inpatients = DB::table('inpatients')->get();
        $dentals = DB::table('dentals')->get();
        $product_types = DB::table('product_types')->get();
        $options = DB::table('options')->get();

        // dd($franchise_details);

        return view('kunden.edit', [
            'beraters' => $beraters, 'types_of_contracts' => $types_of_contracts,
            'client_sources' => $client_sources, 'franchises' => $franchises,
            'payments' => $payments, 'payment_types' => $payment_types,
            'kunden' => $kunden, 'companies' => $companies, 'basic_insurance_models' => $basic_insurance_models,
            'hospitals' => $hospitals, 'alternative_medicals' => $alternative_medicals,
            'franchise_details' => $franchise_details, 'inpatients' => $inpatients, 'dentals' => $dentals,
            'product_types' => $product_types, 'options' => $options,
        ]);
    }

    public function update(Request $request, Kunden $kunden)
    {
        // dd($request->all());
        if ($request['franchise_details']) {
            $franchise_detail = $request['franchise_details'];
        } else {
            $franchise_detail = null;
        }
        if ($request['hospitals']) {
            $hospital = $request['hospitals'];
        } else {
            $hospital = null;
        }
        if ($request['inpatient']) {
            $inpatients = $request['inpatient'];
        } else {
            $inpatients = null;
        }
        if ($request['alternative_medicals']) {
            $alternative_medicals = $request['alternative_medicals'];
        } else {
            $alternative_medicals = null;
        }
        if ($request['dentals']) {
            $dental = $request['dentals'];
        } else {
            $dental = null;
        }
        if ($request['legal']) {
            $legal = 1;
        } else {
            $legal = null;
        }
        if ($request['accident_cover']) {
            $accident_cover = 1;
        } else {
            $accident_cover = null;
        }
        if ($request['product_type']) {
            $product_type_id = $request['product_type'];
        } else {
            $product_type_id = null;
        }
        if ($request['occupation']) {
            $occupation = $request['occupation'];
        } else {
            $occupation = null;
        }
        if ($request['smoker']) {
            $smoker = $request['smoker'];
        } else {
            $smoker = null;
        }
        if ($request['options']) {
            $options_id = $request['options'];
        } else {
            $options_id = null;
        }

        // dd($request->all());
        $kunden->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'plz' => $request['plz'],
            'ort' => $request['ort'],
            'address' => $request['adresse'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'telefon' => $request['telefon'],
            'berater_id' => $request['berater'],
            'client_source_id' => $request['client_source'],
            'types_of_contract_id' => $request['types_of_contract'],
            'company_id' => $request['company'],
            'basic_insurance_model_id' => $request['basic_insurance_model'],
            'accident_cover' => $accident_cover,
            'franchise_id' => $request['franchise'],
            'franchise_details_id' => $franchise_detail,
            'basic_insurance_start_date' => $request['basic_insurance_start_date'],
            'hospital_id' => $hospital,
            'inpatients_id' => $inpatients,
            'alternative_medical_id' => $alternative_medicals,
            'dental_id' => $dental,
            'combi' => $request['combi'],
            'accident' => $request['accident'],
            'death' => $request['death'],
            'taggeld' => $request['taggeld'],
            'other' => $request['other'],
            'legal' => $legal,
            'product_type_id' => $product_type_id,
            'insurance_commencement_date' => $request['insurance_commencement_date'],
            'duration' => $request['duration'],
            'yearly_premium' => $request['yearly_premium'],
            'monthly_premium' => $request['monthly_premium'],
            'redeemable' => $request['redeemable'],
            'occupation' => $occupation,
            'smoker' => $smoker,
            'value' => $request['value'],
            'options_id' => $options_id,
            'payment_id' => $request['payment'],
            'payment_type_id' => $request['payment_type'],
            'contract_signed_on' => $request['contract_signed_on'],
        ]);

        return redirect()->route('kunden.index')->with('successUpdate', 'Kunden updated successfully');
    }
}
