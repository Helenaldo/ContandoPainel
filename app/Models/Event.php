<?php

namespace App\Models;

use App\Models\Traits\TenantTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, TenantTable;

    protected $guarded = ['id'];
}
