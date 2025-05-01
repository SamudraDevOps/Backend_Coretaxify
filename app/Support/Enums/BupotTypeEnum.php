<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum BupotTypeEnum: string {
    use Arrayable;

    case BPPU = 'BPPU';
    case BPNR = 'BPNR';
    case PS = 'Penyetoran Sendiri';
    case PSD = 'Pemotongan Secara Digunggung';
    case BP21 = 'BP 21';
    case BP26 = 'BP 26';
    case BPA1 = 'BP A1';
    case BPA2 = 'BP A2';
    case BPBPT = 'Bukti Pemotongan Bulanan Pegawai Tetap';
    case DSBP = 'Dokumen Yang Dipersamakan Bupot';
}
