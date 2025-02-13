<?php

namespace App\Support\Enums;

enum IntentEnum: string {

    case API_USER_CREATE_ADMIN = 'api.user.create.admin';

    case API_USER_IMPORT_DOSEN = 'api.user.import.dosen';

    case API_USER_CREATE_INSTRUCTOR = 'api.user.create.instructor';

    case API_USER_CREATE_GROUP = 'api.user.create.group';

    case API_USER_CREATE_ASSIGNMENT = 'api.user.create.assignment';

    case API_USER_JOIN_GROUP = 'api.user.join.group';

    case API_USER_ASSIGN_TASK = 'api.user.assign.task';

    case API_USER_GET_PSC = 'api.user.get.psc';

    case API_USER_GET_ADMIN = 'api.user.get.admin';

    case API_USER_GET_DOSEN = 'api.user.get.dosen';

    case API_USER_GET_MAHASISWA = 'api.user.get.mahasiswa';

    case API_USER_GET_INSTRUKTUR = 'api.user.get.instruktur';

    case API_USER_DOWNLOAD_SOAL = 'api.user.download.soal';
}
