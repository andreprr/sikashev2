<?php

namespace App\Exports;

use App\Models\Viewreports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportsExport implements FromQuery, WithHeadings,ShouldAutoSize
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function query()
    {
        return Viewreports::query()->select('room_name','form_title','username','nama','tahun','general_name','group_name','total_corrects','total_questions','total_answered','nilai')->where('id', $this->id)->orderBy('nama');
    }

    public function headings(): array
    {
        return ['NAMA ROOM','NAMA SOAL','NIS','NAMA LENGKAP','TAHUN','TINGKAT','KELAS','JAWABAN BENAR','JUMLAH SOAL','JUMLAH TERJAWAB','NILAI'];
    }
}