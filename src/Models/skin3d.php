<?php

namespace Azuriom\Plugin\Skin3d\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skin3d extends Model
{
    use HasFactory;

    protected $table = 'skin3d';
    protected $fillable = [
        'service', 'phrase', 'background', 'backgroundMode', 'showPhrase', 'showButtons', 'activeCapes', 'custom_capes_api',
    ];
}
