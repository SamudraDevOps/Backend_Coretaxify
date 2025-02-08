<?php

namespace App\Support\Enums;

enum IntentEnum: string {

    case API_USER_CREATE_INSTRUCTOR = 'api.user.create.instructor';

    case API_USER_CREATE_GROUP = 'api.user.create.group';

    case API_USER_JOIN_GROUP = 'api.user.join.group';

    case API_USER_ASSIGN_TASK = 'api.user.assign.task';
    case API_USER_GET_DOSEN = 'api.user.get.dosen';
    case API_USER_GET_MAHASISWA = 'api.user.get.mahasiswa';
    case API_USER_GET_INSTRUKTUR = 'api.user.get.instruktur';
}
