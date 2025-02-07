<?php

namespace App\Support\Enums;

enum IntentEnum: string {

    case API_USER_CREATE_DOSEN = 'api.user.create.dosen';

    case API_USER_CREATE_GROUP = 'api.user.create.group';

    case API_USER_JOIN_GROUP = 'api.user.join.group';

    case API_USER_ASSIGN_TASK = 'api.user.assign.task';
}