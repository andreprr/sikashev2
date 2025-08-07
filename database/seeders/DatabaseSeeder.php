<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Job;
use App\Models\Event;
use App\Models\EventStep;
use App\Models\StepField;
use App\Models\ApplicantsJob;
use App\Models\ResearchField;
use App\Models\InstitutionCategory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //roles
        $adminRole = Role::create(['name' => 'admin']);
        $memberRole = Role::create(['name' => 'member']);
        $opdRole = Role::create(['name' => 'opd']);
        $verifikator1Role = Role::create(['name' => 'verifikator1']);
        

        //permissions
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'user']);
        Permission::create(['name' => 'userprofile']); 
        Permission::create(['name' => 'master']);
        Permission::create(['name' => 'job']);
        Permission::create(['name' => 'forminput']);
        Permission::create(['name' => 'api.public']);
        Permission::create(['name' => 'api.private']);
        
        $adminRole->syncPermissions(['dashboard','user','job','api.public','api.private','master','forminput']);
        $memberRole->syncPermissions(['dashboard','userprofile','job','api.public','api.private','forminput']);
        $opdRole->syncPermissions(['dashboard','userprofile','job','api.public','api.private','forminput']);
        $verifikator1Role->syncPermissions(['dashboard','userprofile','api.public','api.private','forminput']);
        

        //admin
        $user = User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'status' => 'active',
            'password' => bcrypt('admin')
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'img_url' => 'userdefault.png'
        ]);

        $user->assignRole('admin');

        //member
        $user = User::factory()->create([
            'name' => 'Sample Member',
            'username' => 'member',
            'email' => 'member@mail.com',
            'status' => 'active',
            'password' => bcrypt('member')
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'phone' => '081234567',
            'img_url' => 'userdefault.png',
            'nip' => '1234'
        ]);

        $user->assignRole('member');

        //verifikator
        $user = User::factory()->create([
            'name' => 'Verifikator 1',
            'username' => 'verifikator1',
            'email' => 'verifikator1@mail.com',
            'status' => 'active',
            'password' => bcrypt('verifikator1')
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'phone' => '081234567',
            'img_url' => 'userdefault.png',
            'nip' => '1234'
        ]);

        $user->assignRole('admin');

        //verifikator
        $user = User::factory()->create([
            'name' => 'Dinas Sample',
            'username' => 'dinassample',
            'email' => 'dinassample@mail.com',
            'status' => 'active',
            'password' => bcrypt('dinassample')
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'phone' => '081234567',
            'img_url' => 'userdefault.png',
            'nip' => '1234'
        ]);

        $user->assignRole('opd');
        
        
        ApplicantsJob::create(['name' => 'Peserta Didik']);
        ApplicantsJob::create(['name' => 'Mahasiswa']);

        ResearchField::create(['name' => 'Sosial']);
        ResearchField::create(['name' => 'Pendidikan']);
        ResearchField::create(['name' => 'Kesehatan']);
        ResearchField::create(['name' => 'Agama']);
        ResearchField::create(['name' => 'Hukum']);
        ResearchField::create(['name' => 'Politik']);
        ResearchField::create(['name' => 'Ekonomi']);
        ResearchField::create(['name' => 'Teknologi Informasi']);
        ResearchField::create(['name' => 'Kebudayaan']);

        InstitutionCategory::create(['name' => 'Perguruan Tinggi']);
        InstitutionCategory::create(['name' => 'Lembaga Survey']);
        InstitutionCategory::create(['name' => 'Organisasi Profesi']);

        //Event
        $event =  Event::create([
            'event' => 'FORMULIR BAKESBANGPOL INTERNSHIP SERVICE (KASHEV)',
            'description' => 'Penerbitan Surat Keterangan Bakesbangpol Internship Service dibutuhkan 2 hari kerja setelah semua persyaratan terpenuhi.  Formulir ini resmi dikeluarkan oleh Badan Kesatuan Bangsa dan Politik (Bakesbangpol) Kota Cimahi. '
        ]);

        $event_step = EventStep::create([
            'event_id' => $event->id,
            'event_step' => 'Pendaftaran Usulan',
            'step_owner' => 'member',
            'step_order' => '1',
            'step_description' => 'Tahap pendaftaran isi formulir usulan'
        ]);
        
        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'name',
            'field_label' => 'Nama Pemohon',
            'field_description' => 'Masukkan Nama Lengkap',
            'field_type' => 'text',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 1
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'id_card_number',
            'field_label' => 'KTP / NIS / NIM',
            'field_description' => 'Masukkan Nomor KTP atau NIS atau NIM',
            'field_type' => 'text',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 2
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'applicant_job',
            'field_label' => 'Pekerjaan Pemohon',
            'field_description' => 'Pilih Pekerjaan Pemohon',
            'field_type' => 'select',
            'model_referer' => 'App\Models\ApplicantsJob',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 3
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'institution',
            'field_label' => 'Nama Asal lembaga / instansi pemohon',
            'field_description' => 'Silahkan diisi dengan asal lembaga atau instansi dimana anda bertugas. Misalnya Universitas Padjajaran, Lembaga Survey Indonesia, dan lain-lain',
            'field_type' => 'text',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 4
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'start_at',
            'field_label' => 'Waktu MEMULAI Penelitian',
            'field_description' => 'silahkan diisi dengan rencana kapan MULAI dilaksanakan',
            'field_type' => 'date',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 5
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'finish_at',
            'field_label' => 'Waktu SELESAI Penelitian',
            'field_description' => 'silahkan diisi dengan rencana kapan Penelitian BERAKHIR',
            'field_type' => 'date',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 6
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'applicants_photo',
            'field_label' => 'Pas Photo 3 x4 berwarna',
            'field_description' => 'Upload 1 file yang didukung: drawing atau image. Maks 10 MB.',
            'field_type' => 'file',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 7
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'applicants_idcard',
            'field_label' => 'KTP/KTM/Kartu Pelajar',
            'field_description' => 'Upload 1 file yang didukung: PDF, drawing, atau image. Maks 10 MB.',
            'field_type' => 'file',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 8
        ]);

        
        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'applicants_research_letter',
            'field_label' => 'Surat Permohonan / Reomendasi dari instansi pemohon',
            'field_description' => 'Upload 1 file yang didukung: PDF, document, drawing, atau image. Maks 10 MB.',
            'field_type' => 'file',
            'need_verif' => 1,
            'is_required' => 1,
            'field_order' => 9
        ]);

        $event_step = EventStep::create([
            'event_id' => $event->id,
            'event_step' => 'Verifikasi Berkas',
            'step_owner' => 'admin',
            'step_order' => '2',
            'step_description' => 'Tahap verifikasi Berkas Pendaftaran'
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'verif_message',
            'field_label' => 'Keterangan Verifikasi',
            'field_description' => '',
            'field_type' => 'textarea',
            'need_verif' => 0,
            'is_required' => 1,
            'field_order' => 1
        ]);

        $event_step = EventStep::create([
            'event_id' => $event->id,
            'event_step' => 'Verifikasi Wasnas',
            'step_owner' => 'admin',
            'step_order' => '3',
            'step_description' => 'Tahap verifikasi wasnas'
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'verif_message_wasnas',
            'field_label' => 'Keterangan Verifikasi',
            'field_description' => '',
            'field_type' => 'textarea',
            'need_verif' => 0,
            'is_required' => 1,
            'field_order' => 1
        ]);

        $event_step = EventStep::create([
            'event_id' => $event->id,
            'event_step' => 'Penerbitan Surat Keterangan PKL',
            'step_owner' => 'admin',
            'step_order' => '4',
            'step_description' => 'Tahap Penerbitan Surat Keterangan PKL'
        ]);

        StepField::create([
            'step_id' => $event_step->id,
            'field_name' => 'pkl_letter',
            'field_label' => 'Surat Keterangan PKL',
            'field_description' => 'Upload File Surat Keterangan Penelitian dalam bentuk pdf',
            'field_type' => 'file',
            'need_verif' => 0,
            'is_required' => 1,
            'field_order' => 1
        ]);

        Job::create([
            'job' => 'Magang PKL',
            'opd' => 'Dinas Sample',
            'description' => 'Minimal Kelas XI dan dapat mengoperasikan komputer',
            'type' => 'sekolah',
            'status' => 'publish',
            'start_at' => Carbon::now()->toDateTimeString(),
            'finish_at' => Carbon::createFromFormat('Y-m-d', '2024-12-31')->toDateTimeString(),
            'published_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
