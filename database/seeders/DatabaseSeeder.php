<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo archivist
        $user = User::create([
            'name'     => 'Grand Archivist',
            'username' => 'archivist',
            'email'    => 'archivist@imperial-library.local',
            'password' => Hash::make('password'),
        ]);

        // Seed sample series
        $seriesData = [
            [
                'title'              => 'Shadow of the Dynasty',
                'author'             => 'Hiroaki Samura',
                'synopsis'           => 'A sweeping historical epic set in feudal Japan, following a disgraced swordsman who seeks redemption by protecting a crumbling dynasty from within.',
                'cover_image'        => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1BMSTTb3ikv1S8hdl2lH0QxVfsvjTOMYuLaym-LQo6yRqJUxLnlPvKWL8lVXYRhq5_xSSX7IUK5ZLZVpTpldnywfhImuarG24f0BFE_U9Frh8oWGJGgXzxgqEnhV_6LtBL8SqzTi7GiVFZe5nZAxsVxCM1fYEaIwL2kLTeDAzr6YF8W99eFuUDWyYJdKO-9Nk_Uv7j9XUQ3JCJPsGi2_WhJb5a2yHxVKvGScEu2Z6xCnfHToj6peECBRM7gdtZQTwzky_CtZ71Gw',
                'format_origin'      => 'Digital Scan',
                'induction_date'     => '2024-01-15',
                'chapters_completed' => 142,
                'chapters_total'     => 180,
                'rating'             => 4.9,
                'status'             => 'Currently Reading',
                'type'               => 'MANGA',
                'tags'               => ['Seinen', 'Historical', 'Samurai'],
            ],
            [
                'title'              => 'The Silent Scroll',
                'author'             => 'Chen Wei',
                'synopsis'           => 'A celestial scholar discovers an ancient library hidden between dimensions, its scrolls containing the forgotten histories of fallen civilizations.',
                'cover_image'        => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCSp3Q8QegDnpwZa8VgHIOP1cLcqOyFYM-9pvllJRTsNWiOa5HsHVbHy_yszfgH7KLz6HhZEaV4sMTiTvucoQnnrqY_JK5PUhk_Iz_uMzx9z3M3XhZu_lPVze7qwbety4mtzbuX9eu9agCNCbyaHc-rXcwnxRZ3B1xGzckRyU3Eq-K76wdSeGPnamnnc7g9XPFzFDP4-_Au0s_9ToP_0_YNiVvRmu9JOaK9el9hgpDUTSpWow2gUZ3v3GjRBa1Rx_FJ1BCng7XT1e4',
                'format_origin'      => 'Serialization',
                'induction_date'     => '2024-02-10',
                'chapters_completed' => 56,
                'chapters_total'     => 60,
                'rating'             => 4.7,
                'status'             => 'Currently Reading',
                'type'               => 'MANHUA',
                'tags'               => ['Fantasy', 'Xianxia', 'Mystery'],
            ],
            [
                'title'              => 'Oracle of Ink',
                'author'             => 'Kim Jisoo',
                'synopsis'           => 'A blind oracle who reads fate through the brushstrokes of ink must navigate a court of shadows to prevent a prophecy of total destruction.',
                'cover_image'        => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDOPFbxccYdWe_9f2Grevi4qTyo8RDPck5mOTBnh1YvSINEwyrrkmsZy9Ebq0n1For0lREERhgSEHNmplAdBhd1pblZ_GJnkgf6PY3dju431l7IgEV9DYDQxeV4i353MTuH9BzbdU0k0TOfEKOA2_f3PGSTqPDiYEmb4A4tKXGUddcdW4uDZURWRQR4_ogt97Nk1j3HEXHh2ZSFHoVejiSonGjO92oiKzSM0Hooxw4d2TTxFF7Qw-kc7I9m9OLa0oVmlg0R48OjAX4',
                'format_origin'      => 'Digital Scan',
                'induction_date'     => '2024-03-05',
                'chapters_completed' => 12,
                'chapters_total'     => 120,
                'rating'             => 5.0,
                'status'             => 'Currently Reading',
                'type'               => 'MANHWA',
                'tags'               => ['Fantasy', 'Political', 'Supernatural'],
            ],
            [
                'title'              => 'Whispers in the Garden',
                'author'             => 'Tanaka Ryu',
                'synopsis'           => 'Set in a sprawling imperial garden where spirits and mortals coexist, a young attendant must unravel the mystery of disappearing memories.',
                'cover_image'        => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBgatD113dtp9TBLQFFTdRH81p2qf17UT6YHwnmWAJNmbORXVvJkR4Q9yWuPy3ZY0ohvRyc3f93fSmVg0Q8vt5RyjmvFpnF4ZCw4ILZwg9MgGSltCjY48qbUFjC5RucXCLfYg06q8wRlf8BdQP7ulb641FhymNMxGQByYeL9dXNVduA-mAPNztnHafKtSXN4z03UujHZw4Cxx_chsC_qY24iIuCV4aLYoplfKW9wHdGEcgJLlPW9XqerBp9P8yJ-p8D_0expTsepOs',
                'format_origin'      => 'Tankobon Physical',
                'induction_date'     => '2023-11-20',
                'chapters_completed' => 204,
                'chapters_total'     => 300,
                'rating'             => 4.2,
                'status'             => 'Currently Reading',
                'type'               => 'MANGA',
                'tags'               => ['Josei', 'Supernatural', 'Romance'],
            ],
            [
                'title'              => "The Master's Brush",
                'author'             => 'Liu Fang',
                'synopsis'           => 'A legendary calligraphist discovers that every character he writes manifests in reality — a gift that makes him both savior and destroyer.',
                'cover_image'        => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC7d9zdhBf6vAEnqARJD53BAIEU99y0Gk6viJnfz2PRlxTlenfduZJHwD1WlqW9yMO91l7J_QeqUl_AkoVTCNRdoyUgl3Wh8UkvGKu0dtG2sy-CDOLiHFAKm8zL3wdoAmlNwaLizpXXrUhyViF9vyKryDZtoK40-jIILK4LNs8SOjRkXOR4v1URxHRehXSBEUe9uT4JRaYtIBak91YkinVYkpIC78xgOB7oAUyQzVzHT8k9Gy89FwdR9ye1QeMndFMhzRd2leIDGFc',
                'format_origin'      => 'Serialization',
                'induction_date'     => '2024-04-01',
                'chapters_completed' => 45,
                'chapters_total'     => 90,
                'rating'             => 4.8,
                'status'             => 'Currently Reading',
                'type'               => 'MANHUA',
                'tags'               => ['Action', 'Fantasy', 'Arts'],
            ],
        ];

        foreach ($seriesData as $data) {
            $data['user_id'] = $user->id;
            Series::create($data);
        }

        // Seed some manual activity log entries
        $series = Series::all();
        ActivityLog::create([
            'user_id'     => $user->id,
            'series_id'   => $series[0]->id,
            'action'      => 'edited',
            'description' => "Changed reading status from 'Plan to Read' to 'Currently Reading'. Added personal rating of 4.9.",
            'metadata'    => ['changed_fields' => ['status', 'rating']],
        ]);
        ActivityLog::create([
            'user_id'     => $user->id,
            'series_id'   => $series[1]->id,
            'action'      => 'added',
            'description' => 'Imported metadata for chapters 1-56. Synchronized with imperial archives successfully.',
            'metadata'    => ['title' => $series[1]->title],
        ]);
    }
}
