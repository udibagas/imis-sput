<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubArea;
use App\Area;
use App\Http\Requests\SubAreaRequest;

class SubAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', SubArea::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'sub_areas.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $subArea = SubArea::selectRaw('sub_areas.*, areas.name AS area')
                ->join('areas', 'areas.id', '=', 'sub_areas.area_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('sub_areas.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('areas.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('sub_areas.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $subArea->perPage(),
                'total' => $subArea->total(),
                'current' => $subArea->currentPage(),
                'rows' => $subArea->items(),
            ];
        }

        return view('subArea.index', [
            'breadcrumbs' => [
                '0' => 'Operation',
                '#' => 'Master Data',
                'subArea' => 'Sub Area'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubArea $subArea)
    {
        $this->authorize('delete', Area::class);
        return ['success' => $subArea->delete()];
    }
}
