<?php

namespace App\Imports;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;

class TicketsImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    private $processedRows = 0;
    private $skippedRows = 0;

    public function model(array $row)
    {
        try {
            // ======================
            // 1. VALIDASI WAJIB ADA
            // ======================

            $requiredFields = [
                'tickets',
                'complaint',
                'jam',
                'date_open',
                'source',
                'company',
                'branch',
                'kota_cabang',
                'priority',
                'applicationshardware',
                'categories',
                'subcategory',
                'status_qris',
                'info_kendala',
                'assigned',
                'jabatan',
                'help_desk',
            ];

            // ======================
            // 2. NORMALISASI DATA
            // ======================

            // Tanggal Excel → Carbon
            $tanggal = null;

            if (isset($row['date_open']) && $row['date_open'] != '') {
                try {
                    // Coba konversi dari Excel numeric date
                    if (is_numeric($row['date_open'])) {
                        $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_open'])
                            ->format('Y-m-d');
                    } else {
                        // fallback untuk teks format dd/mm/yyyy
                        $tanggal = Carbon::createFromFormat('d/m/Y', $row['date_open'])->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    try {
                        $tanggal = Carbon::parse($row['date_open'])->format('Y-m-d');
                    } catch (\Exception $e2) {
                        $tanggal = null;
                    }
                }
            }

            // Jam Excel (decimal) → "HH:MM:SS"
            $jam = null;
            if (isset($row['jam']) && $row['jam'] != '') {
                if (is_numeric($row['jam'])) {
                    $jam = Carbon::createFromTimestampUTC($row['jam'] * 86400)->format('H:i:s');
                } else {
                    try {
                        $jam = Carbon::parse($row['jam'])->format('H:i:s');
                    } catch (\Exception $e) {
                        $jam = null;
                    }
                }
            }

            $ticketNumber = isset($row['no']) && $row['no'] != ''
                ? preg_replace('/[^0-9]/', '', $row['no'])
                : null;

            if (!$ticketNumber) {
                $this->skippedRows++;
                return null;
            }

            // ======================
            // 3. CEK DUPLIKAT TICKET_NUMBER
            // ======================

            $existing = Ticket::where('ticket_number', $ticketNumber)->first();
            if ($existing) {
                $this->skippedRows++;
                return null;
            }

            // ======================
            // 4. MAPPING ENUM (sama seperti sebelumnya)
            // ======================

            $appRaw = strtolower(trim($row['applicationshardware'] ?? ''));
            $applicationMap = [
                'mobile dashboard'   => 'Aplikasi Mobile',
                'dashboard mobile'   => 'Aplikasi Mobile',
                'aplikasi mobile dashboard' => 'Aplikasi Mobile',
                'mobile'             => 'Aplikasi Mobile',
                'aplikasi mobile'    => 'Aplikasi Mobile',
                'hardware'           => 'Hardware',
                'aplikasi kasir'     => 'Aplikasi Kasir',
                'kasir'              => 'Aplikasi Kasir',
                'aplikasi web merchant' => 'Aplikasi Web Merchant',
                'aplikasi attendance' => 'Aplikasi Attendance',
                'aplikasi web internal' => 'Aplikasi Web Internal'
            ];
            $application = $applicationMap[$appRaw] ?? 'Aplikasi Mobile';

            $ticketRaw = strtolower(trim($row['tickets'] ?? ''));
            $ticketType = in_array($ticketRaw, ['open', 'close']) ? ucfirst($ticketRaw) : 'Close';

            $complaintRaw = strtolower(trim($row['complaint'] ?? ''));
            $complaintTypeMap = [
                'NORMAL' => 'Normal',
                'HARD' => 'Hard',
                'hardcase' => 'Hard',
                'hard case' => 'Hard',
                'close' => 'Normal',
                'closed' => 'Normal',
                'open' => 'Normal',
                'ticket close' => 'Normal',
            ];
            $complaintType = $complaintTypeMap[$complaintRaw] ?? 'Normal';

            $statusRaw = strtolower(trim($row['status_qris'] ?? ''));
            $statusQrisMap = [
                'sukses' => 'Sukses',
                'success' => 'Sukses',
                'pending' => 'Pending/Expired',
                'expired' => 'Pending/Expired',
                'pending/expired' => 'Pending/Expired',
                'gagal' => 'Gagal',
                'failed' => 'Gagal',
                'none' => 'None',
                '-' => 'None',
            ];
            $statusQris = $statusQrisMap[$statusRaw] ?? 'None';

            $priorityRaw = strtolower(trim($row['priority'] ?? ''));
            $priorityMap = [
                'premium' => 'Premium',
                'full service' => 'Full Service',
                'lainnya' => 'Lainnya',
                'corporate' => 'Corporate',
            ];
            $priority = $priorityMap[$priorityRaw] ?? 'Lainnya';

            $assignedRaw = strtolower(trim($row['assigned'] ?? ''));
            $assignedMap = [
                'helpdesk' => 'Helpdesk',
                'development' => 'Development',
                'marketing' => 'Marketing',
                'team support' => 'Team Support',
                'ts' => 'Team Support',
                'gudang' => 'Gudang',
                'team pac' => 'Team PAC',
            ];
            $assigned = $assignedMap[$assignedRaw] ?? 'Helpdesk';

            $category       = $row['categories'] ?? 'Assistances';
            $subCategory    = $row['subcategory'] ?? '-';

            // ======================
            // 5. INSERT DATA
            // ======================

            $this->processedRows++;

            return new Ticket([
                'user_id'        => auth()->id() ?? 1,
                'ticket_number'  => $ticketNumber,
                'ticket_type'    => $ticketType,
                'complaint_type' => $complaintType,
                'jam'            => $jam,
                'tanggal'        => $tanggal,
                'source'         => $row['source'] ?? 'Help Desk',
                'company'        => $row['company'] ?? '-',
                'branch'         => $row['branch'] ?? '-',
                'kota_cabang'    => $row['kota_cabang'] ?? 'Tidak Ada Cabang',
                'priority'       => $priority,
                'application'    => $application,
                'category'       => $category,
                'sub_category'   => $subCategory,
                'status_qris'    => $statusQris,
                'info_kendala'   => $row['info_kendala'] ?? '-',
                'pengecekan'     => $row['pengecekan'] ?? null,
                'root_cause'     => $row['rootcause'] ?? null,
                'solving'        => $row['solving'] ?? null,
                'assigned'       => $assigned,
                'pic_merchant'   => $row['pic_merchant'] ?? '-',
                'jabatan'        => $row['jabatan'] ?? '-',
                'nama_helpdesk'  => $row['help_desk'] ?? '-',
                'status'         => 'close',
            ]);
        } catch (\Exception $e) {
            Log::error("Error Importing Row: " . $e->getMessage(), $row);
            $this->skippedRows++;
            return null;
        }
    }

    public function chunkSize(): int
    {
        return 500; // Process 500 rows at a time
    }

    public function batchSize(): int
    {
        return 100; // Insert 100 records in batch
    }

    public function getProcessedRows(): int
    {
        return $this->processedRows;
    }

    public function getSkippedRows(): int
    {
        return $this->skippedRows;
    }
}
