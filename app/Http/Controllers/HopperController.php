<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hopper;
use App\Jetty;

class HopperController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hopper $hopper)
    {
        $this->authorize('delete', Jetty::class);
        return ['success' => $hopper->delete()];
    }
}
