<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contractor;
use App\Http\Requests\ContractorRequest;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Contractor::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $contractor = Contractor::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('address', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('email', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('phone', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('fax', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $contractor->perPage(),
                'total' => $contractor->total(),
                'current' => $contractor->currentPage(),
                'rows' => $contractor->items(),
            ];
        }

        return view('contractor.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'contractor' => 'Contractor'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractorRequest $request)
    {
        $this->authorize('create', Contractor::class);
        return Contractor::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contractor $contractor)
    {
        $this->authorize('view', Contractor::class);
        return $contractor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractorRequest $request, Contractor $contractor)
    {
        $this->authorize('update', Contractor::class);
        $contractor->update($request->all());
        return $contractor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contractor $contractor)
    {
        $this->authorize('delete', Contractor::class);
        return ['success' => $contractor->delete()];
    }
}
