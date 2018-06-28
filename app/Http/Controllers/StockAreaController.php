<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockArea;
use App\Jetty;

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
        $this->authorize('delete', Jetty::class);
        return ['success' => $stockArea->delete()];
    }
}
