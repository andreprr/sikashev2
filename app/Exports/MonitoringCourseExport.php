<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Support\Facades\DB;

class MonitoringCourseExport implements FromQuery, WithHeadings,ShouldAutoSize
{
    use Exportable;

    public function __construct(string $from , string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        return Course::query()->select(
            DB::raw('EXTRACT(year from course_members.created_at) as year'),
            DB::raw('EXTRACT(month from course_members.created_at) as month'),
            'courses.title',
            DB::raw('COUNT(course_members.id) as total_students')
        )
        ->leftJoin('course_members', 'courses.id', '=', 'course_members.course_id')
        ->where('courses.status', 'publish')
        ->whereBetween('course_members.created_at', [$this->from, $this->to])
        ->orWhereNull('course_members.created_at') // Include courses without any members
        ->groupBy('courses.title', 'year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'asc');
    }

    public function headings(): array
    {
        return ['TAHUN','BULAN','NAMA MATERI','JUMLAH PESERTA'];
    }
}