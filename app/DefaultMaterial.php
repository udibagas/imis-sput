<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultMaterial extends Model
{
    protected $fillable = ['customer_id', 'contractor_id', 'material_type', 'seam_id'];
}
