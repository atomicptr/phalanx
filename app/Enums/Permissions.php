<?php

namespace App\Enums;

enum Permissions: string
{
    case CAN_PUBLISH = 'can-publish';
    case CAN_ACCESS_CONFIDENTIAL = 'can-access-confidential';
    case CAN_ACCESS_PATCHES = 'can-access-patches';
    case CAN_EDIT_BUILDS = 'can-edit-builds';
    case CAN_EDIT_DATA = 'can-edit-data';
    case CAN_DELETE_ENTRIES = 'can-delete';
}
