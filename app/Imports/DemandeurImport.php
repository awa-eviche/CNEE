<?php
namespace App\Imports;

use App\Models\Demandeur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DemandeurImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Demandeur([
            'nom'            => $row['nom'],
            'prenom'         => $row['prenom'],
            'email'          => $row['email'],
            'sexe'           => $row['sexe'],
            'datenaissance' => $row['datenaissance'],
            'lieunaissance' => $row['lieunaissance'],
            'region'          => $row['region'],
            'departement'          => $row['departement'],
            'cni'          => $row['cni'],
            'tel' => $row['tel'],
            'adresse'        => $row['adresse'],
         
         
        ]);
    }
}
