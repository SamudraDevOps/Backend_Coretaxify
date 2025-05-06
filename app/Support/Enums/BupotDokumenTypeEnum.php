<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum BupotDokumenTypeEnum: string {
    use Arrayable;

    case AKTA_PERJANJIAN = 'Akta Perjanjian';
    case RUPS = 'Rapat Umum Pemegang Saham';
    case BUKTI_PEMBAYARAN = 'Bukti Pembayaran';
    case DKPP = 'Dokumen Ketentuan Peraturan Perpajakan';
    case DOKUMEN_LAINNYA = 'Dokumen Lainnya';
    case DPF_LAINNYA = 'Dokumen Pemberi Fasilitas Lainnya';
    case FAKTUR_PAJAK = 'Faktur Pajak';
    case JASA_GIRO = 'Jasa Giro';
    case KONTRAK = 'Kontrak';
    case PENGUMUMAN = 'Pengumuman';
    case SK = 'Surat Keputusan';
    case SP = 'Surat Pernyataan';
    case ST = 'Surat Tagihan';
    case TC = 'Trade Confirmation';
}
