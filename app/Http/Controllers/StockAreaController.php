<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockArea;
use App\Area;

class StockAreaController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockArea $stockArea)
    {
        $this->authorize('delete', Area::class);
        return ['success' => $stockArea->delete()];
    }
}
