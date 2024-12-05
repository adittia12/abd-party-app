<?php

namespace App\Imports;

use App\Models\Employes;
use App\Models\Groupss;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $existingEmploye = Employes::where('name', $row['name'])->first();

        if ($existingEmploye) {
            $existingEmploye->update([
                'id_group' => $row['group']
            ]);
        }else {
            $employe = new Employes([
                'name' => $row['name'],
                'id_group' => $this->getGroupId($row['group'])
            ]);
            $employe->save();
        }
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }

    private function getGroupId($group)
    {
        $groupModel = Groupss::where('name_group', $group)->first();

        if (!$groupModel) {
            $groupModel = new Groupss();
            $groupModel->name_group = $group;
            $groupModel->save();
        }
        return $groupModel->id;
    }
}
