<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BargingMaterial;
use App\Barging;

class BargingMaterialController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view', Barging::class);

        return BargingMaterial::selectRaw('
                barging_materials.*,
                contractors.name AS contractor,
                seams.name AS seam
            ')
            ->join('bargings', 'bargings.id', '=', 'barging_materials.barging_id')
            ->join('contractors', 'contractors.id', '=', 'barging_materials.contractor_id')
            ->join('seams', 'seams.id', '=', 'barging_materials.seam_id', 'LEFT')
            ->where('bargings.id', $request->barging_id)->get();
    }

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
