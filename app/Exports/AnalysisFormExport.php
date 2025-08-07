<?php

namespace App\Exports;

use App\Models\Reportdetails;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalysisFormExport implements FromQuery, ShouldAutoSize,WithHeadings
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function query()
    {
        return Reportdetails::query()->selectRaw("question_index,answer_key,
            SUM(case when answer_index = 1 then 1 else 0 end) as answer_1,

            SUM(case when answer_index = 2 then 1 else 0 end) as answer_2,

            SUM(case when answer_index = 3 then 1 else 0 end) as answer_3,

            SUM(case when answer_index = 4 then 1 else 0 end) as answer_4,

            SUM(case when answer_index = 5 then 1 else 0 end) as answer_5")
            ->where('form_id',$this->id)->groupBy('question_index','answer_key')->orderBy('question_index');
    }

    public function headings(): array
    {
        return ['NOMOR SOAL','KUNCI JAWABAN','JUMLAH JAWABAN 1','JUMLAH JAWABAN 2','JUMLAH JAWABAN 3','JUMLAH JAWABAN 4','JUMLAH JAWABAN 5'];
    }
}