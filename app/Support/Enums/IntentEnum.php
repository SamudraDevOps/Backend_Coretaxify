<?php

namespace App\Support\Enums;

enum IntentEnum: string {

    case API_USER_CREATE_ADMIN = 'api.user.create.admin';

    case API_USER_CREATE_PSC = 'api.user.create.psc';

    case API_USER_CREATE_MAHASISWA_PSC = 'api.user.create.mahasiswa.psc';

    case API_USER_CREATE_INSTRUKTUR = 'api.user.create.instruktur';

    case API_USER_GET_PSC = 'api.user.get.psc';

    case API_USER_GET_ADMIN = 'api.user.get.admin';

    case API_USER_GET_DOSEN = 'api.user.get.dosen';

    case API_USER_GET_MAHASISWA = 'api.user.get.mahasiswa';

    case API_USER_GET_MAHASISWA_PSC = 'api.user.get.mahasiswa.psc';

    case API_USER_GET_INSTRUKTUR = 'api.user.get.instruktur';

    case API_USER_IMPORT_DOSEN = 'api.user.import.dosen';

    case API_USER_IMPORT_MAHASISWA_PSC = 'api.user.import.mahasiswa.psc';

    case API_USER_IMPORT_INSTRUKTUR = 'api.user.import.instruktur';

    case API_USER_CREATE_GROUP = 'api.user.create.group';

    case API_USER_JOIN_GROUP = 'api.user.join.group';

    case API_USER_CREATE_ASSIGNMENT = 'api.user.create.assignment';

    case API_USER_JOIN_ASSIGNMENT = 'api.user.join.assignment';

    case API_USER_CREATE_EXAM = 'api.user.create.exam';

    case API_USER_JOIN_EXAM = 'api.user.join.exam';

    case API_GET_GROUP_ALL = 'api.get.group.all';

    case API_GET_ASSIGNMENT_ALL = 'api.get.assignment.all';

    case API_GET_GROUP_WITH_ASSIGNMENTS = 'api.get.group.with.assignments';

    case API_GET_GROUP_WITH_MEMBERS = 'api.get.group.with.members';

    case API_GET_GROUP_BY_ROLES = 'api.get.group.by.roles';

    case API_GET_EXAM_BY_ROLES = 'api.get.exam.by.roles';

    case API_USER_DOWNLOAD_SOAL = 'api.user.download.soal';

    case API_USER_DOWNLOAD_FILE = 'api.user.download.file';

    case API_USER_UPDATE_KUASA_WAJIB = 'api.user.update.kuasa.wajib';

    case API_SISTEM_GET_AKUN_ORANG_PIBADI = 'api.sistem.get.akun.orang.pibadi';

    case API_GET_SISTEM_ALAMAT = 'api.get.sistem.alamat';

    case API_SISTEM_GET_PROFIL_SAYA = 'api.sistem.get.profil.saya';

    case API_GET_KUASA_WAJIB_SAYA = 'api.get.kuasa.wajib.saya';

    case API_GET_ASSIGNMENT_USER_PIC = 'api.get.assignment.user.pic';

    case API_GET_SISTEM_FIRST_ACCOUNT = 'api.get.sistem.first.account';

    case API_GET_SISTEM_INFORMASI_UMUM = 'api.get.sistem.informasi.umum';

    case API_GET_SISTEM_IKHTISAR_PROFIL = 'api.get.sistem.ikhtisar.profil';

    case API_GET_SISTEM_INFORMASI_UMUM_ORANG_PRIBADI = 'api.get.sistem.informasi.umum.orang.pribadi';

    case API_GET_SISTEM_INFORMASI_UMUM_BADAN = 'api.get.sistem.informasi.umum.badan';

    case API_UPDATE_SISTEM_INFORMASI_UMUM_BADAN = 'api.update.sistem.informasi.umum.badan';

    case API_UPDATE_SISTEM_INFORMASI_UMUM_ORANG_PRIBADI = 'api.update.sistem.informasi.umum.orang.pribadi';

    case API_GET_SISTEM_DATA_EKONOMI_ORANG_PRIBADI = 'api.get.sistem.data.ekonomi.orang.pribadi';

    case API_GET_SISTEM_DATA_EKONOMI_BADAN = 'api.get.sistem.data.ekonomi.badan';

    case API_GET_SISTEM_EDIT_INFORMASI_UMUM = 'api.get.sistem.edit.informasi.umum';

    case API_CREATE_FAKTUR_DRAFT = 'api.create.faktur.draft';

    case API_CREATE_FAKTUR_FIX = 'api.create.faktur.fix';

    case API_GET_FAKTUR_PENGIRIM = 'api.get.faktur.pengirim';

    case API_GET_FAKTUR_PENERIMA = 'api.get.faktur.penerima';

    case API_UPDATE_FAKTUR_FIX = 'api.update.faktur.fix';

    case API_UPDATE_SPT_PPN_BAYAR_KODE_BILLING = 'api.update.spt.ppn.bayar.kode.billing';

    case API_UPDATE_SPT_PPN_BAYAR_DEPOSIT = 'api.update.spt.ppn.bayar.deposit';

    case API_UPDATE_SPT_PPH_BAYAR_KODE_BILLING = 'api.update.spt.pph.bayar.kode.billing';

    case API_UPDATE_SPT_PPH_BAYAR_DEPOSIT = 'api.update.spt.pph.bayar.deposit';

    case API_UPDATE_SPT_PPH_KONSEP = 'api.update.spt.pph.konsep';

    case API_UPDATE_SPT_PPH_BAYAR_LANGSUNG = 'api.update.spt.pph.bayar.langsung';

    case API_UPDATE_SPT_PPH_UNIFIKASI_BAYAR_DEPOSIT = 'api.update.spt.pph.unifikasi.bayar.deposit';

    case API_UPDATE_SPT_PPH_UNIFIKASI_KODE_BILLING = 'api.update.spt.pph.unifikasi.kode.billing';

    case API_BUPOT_BPPU = 'api.bupot.bppu';

    case API_BUPOT_BPNR = 'api.bupot.bpnr';

    case API_BUPOT_PS = 'api.bupot.ps';

    case API_BUPOT_PSD = 'api.bupot.psd';

    case API_BUPOT_BP21 = 'api.bupot.bp21';

    case API_BUPOT_BP26 = 'api.bupot.bp26';

    case API_BUPOT_BPA1 = 'api.bupot.bpa1';

    case API_BUPOT_BPA2 = 'api.bupot.bpa2';

    case API_BUPOT_BPBPT = 'api.bupot.bpbpt';

    case API_BUPOT_BPPU_SHOW = 'api.bupot.bppu.show';

    case API_BUPOT_BPNR_SHOW = 'api.bupot.bpnr.show';

    case API_BUPOT_PS_SHOW = 'api.bupot.ps.show';

    case API_BUPOT_PSD_SHOW = 'api.bupot.psd.show';

    case API_BUPOT_BP21_SHOW = 'api.bupot.bp21.show';

    case API_BUPOT_BP26_SHOW = 'api.bupot.bp26.show';

    case API_BUPOT_BPA1_SHOW = 'api.bupot.bpa1.show';

    case API_BUPOT_BPA2_SHOW = 'api.bupot.bpa2.show';

    case API_BUPOT_BPBPT_SHOW = 'api.bupot.bpbpt.show';

    // case API_BUPOT_DSBP = 'api.bupot.dsbp';
    case API_SHOW_DETAIL_SPT = 'api.show.detail.spt';

    case API_GET_SUDAH_PEMBAYARAN = 'api.get.sudah.pembayaran';

    case API_UPDATE_FAKTUR_KREDITKAN = 'api.update.faktur.kreditkan';

    case API_UPDATE_FAKTUR_TIDAK_KREDITKAN = 'api.update.faktur.tidak.kreditkan';

    case API_UPDATE_FAKTUR_RETUR = 'api.update.faktur.retur';

    case API_GET_FAKTUR_RETUR_KELUARAN = 'api.get.faktur.retur.keluaran';

    case API_GET_FAKTUR_RETUR_MASUKAN = 'api.get.faktur.retur.masukan';
}