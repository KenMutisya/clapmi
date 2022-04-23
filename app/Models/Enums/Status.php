<?php
namespace App\Models\Enums;

enum Status: string
{
    case PUBLISHED = 'Published';
    case DRAFT = 'Draft';
    case ARCHIVED = 'Archived';
}