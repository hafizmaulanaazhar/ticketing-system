<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'ticket_type',
        'complaint_type',
        'jam',
        'tanggal',
        'source',
        'company',
        'branch',
        'kota_cabang',
        'priority',
        'application',
        'category',
        'sub_category',
        'status_qris',
        'assigned',
        'info_kendala',
        'pengecekan',
        'root_cause',
        'solving',
        'pic_merchant',
        'jabatan',
        'nama_helpdesk',
        'status',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime:H:i'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate ticket number automatically
    public static function generateTicketNumber()
    {
        $prefix = 'TICK';
        $date = now()->format('Ymd');
        $lastTicket = self::whereDate('created_at', today())->latest()->first();

        $sequence = $lastTicket ? intval(substr($lastTicket->ticket_number, -4)) + 1 : 1;

        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
