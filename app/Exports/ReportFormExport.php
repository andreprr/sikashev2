<?php

namespace App\Exports;

use App\Models\Viewreports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportFormExport implements FromQuery, WithHeadings,ShouldAutoSize
{
    use Exportable;

    public function __construct(int $form_id)
    {
        $this->form_id = $form_id;
    }

    public function query()
    {
        return Viewreports::query()->select('room_name','form_title','tahun','general_name','group_name','nama','username','total_corrects','total_questions','total_answered','nilai')->where('form_id', $this->form_id)->orderBy('tahun','asc')->orderBy('general_name','asc')->orderBy('group_name','asc')->orderBy('nama','asc');
    }

    public function headings(): array
    {
        return ['NAMA ROOM','NAMA SOAL','TAHUN','TINGKAT','KELAS','NAMA LENGKAP','NIS','JAWABAN BENAR','JUMLAH SOAL','JUMLAH TERJAWAB','NILAI'];
    }
}