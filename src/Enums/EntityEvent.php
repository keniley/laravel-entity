<?php

namespace Keniley\LaravelEntity\Enums;

enum EntityEvent: string
{
    case RETRIEVED = 'retrieved';
    case SAVING = 'saving';
    case SAVED = 'saved';
    case DELETING = 'deleting';
    case DELETED = 'deleted';
}
