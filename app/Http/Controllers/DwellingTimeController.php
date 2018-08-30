<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DwellingTime;
use App\Http\Requests\DwellingTimeRequest;

class DwellingTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', DwellingTime::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'dwelling_times.id';
            $dir = $request->sort ? $request->sort[$sort] : 'DESC';

            $dwellingTime = DwellingTime::selectRaw('
                    dwelling_times.*,
                    jetties.name AS jetty,
                    customers.name AS customer
                ')
                ->join('bargings', 'bargings.id', '=', 'dwelling_times.barging_id')
                ->join('jetties', 'jetties.id', '=', 'dwelling_times.jetty_id')
                ->join('customers', 'customers.id', '=', 'bargings.customer_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $dwellingTime->perPage(),
                'total' => $dwellingTime->total(),
                'current' => $dwellingTime->currentPage(),
                'rows' => $dwellingTime->items(),
            ];
        }

        return view('dwellingTime.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                'dwellingTime' => 'DwellingTime'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DwellingTimeRequest $request)
    {
        $this->authorize('create', DwellingTime::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $dwellingTime = DwellingTime::create($input);

        $dwellingTime->barging()->update([
            'status' => $request->status,
            'jetty_id' => $request->jetty_id
        ]);

        return $dwellingTime;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DwellingTime $dwellingTime)
    {
        $this->authorize('view', DwellingTime::class);
        return $dwellingTime;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DwellingTimeRequest $request, DwellingTime $dwellingTime)
    {
        $this->authorize('update', DwellingTime::class);
        $dwellingTime->update($request->all());
        return $dwellingTime;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DwellingTime $dwellingTime)
    {
        $this->authorize('delete', DwellingTime::class);
        return ['success' => $dwellingTime->delete()];
    }
}
