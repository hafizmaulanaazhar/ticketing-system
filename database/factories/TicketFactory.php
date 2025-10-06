<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'ticket_number' => Ticket::generateTicketNumber(),
            'ticket_type' => $this->faker->randomElement(['open', 'close']),
            'complaint_type' => $this->faker->randomElement(['normal', 'hard']),
            'jam' => $this->faker->time('H:i'),
            'tanggal' => $this->faker->date(),
            'source' => $this->faker->randomElement(['helpdesk', 'Tim Support', 'Tim Dev']),
            'company' => $this->faker->company,
            'branch' => $this->faker->city,
            'kota_cabang' => $this->faker->city,
            'priority' => $this->faker->randomElement(['Premium', 'full service', 'lainnya']),
            'application' => $this->faker->randomElement([
                'aplikasi kasir',
                'aplikasi web merchant',
                'hardware',
                'Aplikasi web internal',
                'Aplikasi Attendance'
            ]),
            'category' => $this->faker->randomElement([
                'assistance',
                'General Question',
                'application bugs'
            ]),
            'sub_category' => $this->faker->word,
            'info_kendala' => $this->faker->paragraph,
            'pengecekan' => $this->faker->optional()->paragraph,
            'root_cause' => $this->faker->optional()->paragraph,
            'solving' => $this->faker->optional()->paragraph,
            'pic_merchant' => $this->faker->name,
            'jabatan' => $this->faker->jobTitle,
            'nama_helpdesk' => $this->faker->name,
            'status' => $this->faker->randomElement(['open', 'progress', 'close']),
            'user_id' => User::where('role', 'karyawan')->first()->id,
        ];
    }
}
