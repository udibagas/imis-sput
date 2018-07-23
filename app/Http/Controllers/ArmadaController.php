<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Armada;
use App\Http\Requests\ArmadaRequest;

class ArmadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Armada::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $armada = Armada::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $armada->perPage(),
                'total' => $armada->total(),
                'current' => $armada->currentPage(),
                'rows' => $armada->items(),
            ];
        }

        return view('armada.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'armada' => 'Armada'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArmadaRequest $request)
    {
        $this->authorize('create', Armada::class);
        return Armada::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Armada $armada)
    {
        $this->authorize('view', Armada::class);
        return $armada;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArmadaRequest $request, Armada $armada)
    {
        $this->authorize('update', Armada::class);
        $armada->update($request->all());
        return $armada;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Armada $armada)
    {
        $this->authorize('delete', Armada::class);
        return ['success' => $armada->delete()];
    }
}
