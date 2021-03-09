<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KundenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client_sources')->insert([
            'name' => 'Eigene',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('client_sources')->insert([
            'name' => 'Stammkunden',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('client_sources')->insert([
            'name' => 'CCLeads',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('client_sources')->insert([
            'name' => 'Umfrage',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('types_of_contracts')->insert([
            'name' => 'KK',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('types_of_contracts')->insert([
            'name' => 'LV',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('types_of_contracts')->insert([
            'name' => 'SV',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('companies')->insert([
            'name' => 'Helsana',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Visana',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Concordia',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Sympany',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'CSS',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Sanitas',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Innova',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Groupe Mutuel',
            'types_of_contract_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Helvetia',
            'types_of_contract_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Zurich',
            'types_of_contract_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'PAX',
            'types_of_contract_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('companies')->insert([
            'name' => 'Generali',
            'types_of_contract_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('basic_insurance_models')->insert([
            'name' => 'BenefitPlus/Hausarzt',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Benefit',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Standard',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'HAM',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Tel Doc',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Med Direct',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'MedCall',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'HMO',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'MyDoc',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'OKP',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'HMO',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'CallMed 24',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Classic',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Hausarzt',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'MedCall',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Hausarztversicherung Profit',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Standard',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Gesundheitspraxisversicherung',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Basic',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'CareMed',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'NetMed',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'MedCall',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'BasicPlus',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Prima Tel',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Supra Care',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'RF Prima Care',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'Managed Care',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'RT Sana Tel',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'AH Traditionell',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('basic_insurance_models')->insert([
            'name' => 'None',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('franchises')->insert([
            'name' => 'Above 18',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchises')->insert([
            'name' => 'Below 18',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('franchise_details')->insert([
            'amount' => '300',
            'franchise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '500',
            'franchise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '1000',
            'franchise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '1500',
            'franchise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '2000',
            'franchise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '2500',
            'franchise_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '0',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '100',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '200',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '300',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '400',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '500',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('franchise_details')->insert([
            'amount' => '600',
            'franchise_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('hospitals')->insert([
            'name' => 'Hospital Eco',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Plus',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Comfort',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Flex 1',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Flex 2',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Comfort Bonus',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Flex 2/4',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Flex 4/8',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Halbprivat',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Privat Europa',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Privat Weltweit',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Allgemein',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Allgemein',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Halbprivat',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Privat',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'LIBERO',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Standard',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Flex 15%',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Flex 20%',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Flex 25%',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Halbprivat',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Privat',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Economy Variante 1',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Economy Variante 2',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Balance Variante 1',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Balance Variante 2',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Premium Variante 1',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Premium Variante 1',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Standard',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Extra Liberty',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Hospital Top Liberty',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Switch',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'Switch',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('hospitals')->insert([
            'name' => 'None',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('inpatients')->insert([
            'name' => 'Completa',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'TOP',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'SANA',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Primeo',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Ambulant I',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Ambulant II',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Ambulant III',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Diversa',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Diversa Plus',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Plus',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Premium',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Economy',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Balance',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Premium',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Family',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Classic',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Sanvita',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Activa',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global 1',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global 2',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global 3',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global 4',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global mi-privée',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global Privée',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global Classic Basis',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global Classic Plus',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'Global Flex',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('inpatients')->insert([
            'name' => 'None',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Komplimentär I',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Komplimentär II',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Komplimentär III',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Natura',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Natura Plus',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Economy',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Balance',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'Premium',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 1 Allgemein',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 2 halbprivat 1000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 2 halbprivat 3000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 3 Privat 1000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 3 Privat 3000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 4 Privat welt 1000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HC 4 Privat welt 3000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'HB Spital Bonus',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('alternative_medicals')->insert([
            'name' => 'None',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('dentals')->insert([
            'name' => 'DentaPLUS Light',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DentaPLUS Bronze',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DentaPLUS Silber',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DentaPLUS Gold',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DentaPLUS Combi',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '50% max. 600.-',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 750.-',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '50% max. 1200.-',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 1500.-',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 1800.-',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 3000.-',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '50% max. 500.-',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 1000.-',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 1500.-',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% max. 2000.-',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'Variante 1',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'Variante 2',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '50% bis max. 1000.- CHF',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% bis max. 2000.- CHF',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% bis max. 3000.- CHF',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => '75% bis max. 5000.- CHF',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'Ja',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'Denta 1',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'Denta 2',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'Denta 2',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DP 1 1000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DP 2 3000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'DP 3 15000',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('dentals')->insert([
            'name' => 'None',
            'company_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('product_types')->insert([
            'name' => 'None',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => 'Garantie Plan (3a)',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => 'Garantie Plan (3b)',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => 'Kinder Vorsoge',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => 'None',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => '3a (Gebundene Vorsorge)',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => '3b (Freiwillige Vorsorge)',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => 'None',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => '3a (Gebundene Vorsorge)',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => '3b (Freiwillige Vorsorge)',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => 'None',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => '3a (Gebundene Vorsorge)',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('product_types')->insert([
            'name' => '3b (Freiwillige Vorsorge)',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('options')->insert([
            'name' => 'Erwerbsunfähigkeitsrente',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Prämienbefreiung',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Erwebsunfähigkeitsrente infolge Krankheit o. Unfall',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Prämeinbefreiung infolge Todesfall',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'None',
            'company_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Im Erlebensfall',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Im Todesfall',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Erwebsunfähigkeitsrente infolge Krankheit o. Unfall',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'None',
            'company_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Im Erlebensfall',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Im Todesfall',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Prämienbefreiung',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'None',
            'company_id' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Erwerbsunfähigkeitsrente',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Prämienbefreiung',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Erwebsunfähigkeitsrente infolge Krankheit o. Unfall',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'Prämeinbefreiung infolge Todesfall',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('options')->insert([
            'name' => 'None',
            'company_id' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('payments')->insert([
            'name' => 'Monatlich',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payments')->insert([
            'name' => 'Halbjährlich',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payments')->insert([
            'name' => 'Jährlich',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payments')->insert([
            'name' => 'Quartalzahlung',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // =================================================================================================//
        DB::table('payment_type')->insert([
            'name' => 'LSV',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payment_type')->insert([
            'name' => 'DD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payment_type')->insert([
            'name' => 'ESR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payment_type')->insert([
            'name' => 'PD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('payment_type')->insert([
            'name' => 'PSD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
