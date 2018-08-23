<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DefaultMaterial;
use App\Exports\DefaultMaterialExport;
use App\Http\Requests\DefaultMaterialRequest;
use DB;
use Excel;

class DefaultMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', DefaultMaterial::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'customers.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $defaultMaterials = DefaultMaterial::selectRaw('
                    default_materials.*,
                    customers.name AS customer,
                    contractors.name AS contractor,
                    seams.name AS seam
                ')
                ->join('customers', 'customers.id', '=', 'default_materials.customer_id')
                ->join('contractors', 'contractors.id', '=', 'default_materials.contractor_id')
                ->join('seams', 'seams.id', '=', 'default_materials.seam_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('contractors.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $defaultMaterials->perPage(),
                'total' => $defaultMaterials->total(),
                'current' => $defaultMaterials->currentPage(),
                'rows' => $defaultMaterials->items(),
            ];
        }

        return view('defaultMaterial.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'defaultMaterial' => 'Default Materials'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DefaultMaterialRequest $request)
    {
        $this->authorize('create', DefaultMaterial::class);
        return DefaultMaterial::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DefaultMaterial $defaultMaterial)
    {
        $this->authorize('view', DefaultMaterial::class);
        return $defaultMaterial;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DefaultMaterialRequest $request, DefaultMaterial $defaultMaterial)
    {
        $this->authorize('update', DefaultMaterial::class);
        $defaultMaterial->update($request->all());
        return $defaultMaterial;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DefaultMaterial $defaultMaterial)
    {
        $this->authorize('delete', DefaultMaterial::class);
        return ['success' => $defaultMaterial->delete()];
    }
}
