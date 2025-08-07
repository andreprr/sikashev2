<?php

namespace App\Exports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RoomExport implements FromQuery, WithHeadings,ShouldAutoSize
{
    use Exportable;

    public function __construct(array $array_listid)
    {
        $this->array_listid = $array_listid;
    }

    public function query()
    {
        return $results = Room::selectRaw('rooms.name,rooms.key,rooms.duration,forms.title as form_title, concat(group_classes.tahun," - ",general_groups.name," - ", group_classes.name) as kelas,rooms.description,rooms.event_time,rooms.status')
        ->join('forms','forms.id','=','rooms.form_id')
        ->join('group_classes','group_classes.id','=','rooms.group_id')
        ->join('general_groups','general_groups.id','=','group_classes.general_id')
        ->whereIn('rooms.id',$this->array_listid)
        ->orderBy('rooms.name', 'desc');
    }

    public function headings(): array
    {
        return ['NAMA ROOM','KEY','DURASI (menit)','NAMA FORMULIR','KELAS','DESKRIPSI','WAKTU PELAKSANAAN','STATUS'];
    }
}