<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BargingMaterial;
use App\Barging;

class BargingMaterialController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BargingMaterial $bargingMaterial)
    {
        $this->authorize('delete', Barging::class);
        return ['success' => $bargingMaterial->delete()];
    }
}
