<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barging;
use App\BargingMaterial;
use App\DwellingTime;
use App\Http\Requests\BargingRequest;

class BargingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Barging::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'bargings.start';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $barging = Barging::selectRaw('
                    bargings.*,
                    jetties.name AS jetty,
                    buyers.name AS buyer,
                    barges.name AS barge,
                    tugboats.name AS tugboat,
                    customers.name AS customer
                ')
                ->join('jetties', 'jetties.id', '=', 'bargings.jetty_id')
                ->join('buyers', 'buyers.id', '=', 'bargings.buyer_id')
                ->join('barges', 'barges.id', '=', 'bargings.barge_id')
                ->join('customers', 'customers.id', '=', 'bargings.customer_id')
                ->join('tugboats', 'tugboats.id', '=', 'bargings.tugboat_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('buyers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('jetties.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('barges.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('bargings.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $barging->perPage(),
                'total' => $barging->total(),
                'current' => $barging->currentPage(),
                'rows' => $barging->items(),
            ];
        }

        return view('barging.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                'barging' => 'Barging'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BargingRequest $request)
    {
        $this->authorize('create', Barging::class);
        $barging = Barging::create($request->all());

        $barging->bargingMaterial()->createMany($request->barging_material);

        $dwellingTime = [
            ['status' => 0, 'time' => $request->start, 'jetty_id' => $request->jetty_id, 'user_id' => auth()->user()->id], // start
            ['status' => 1, 'time' => $request->start, 'jetty_id' => $request->jetty_id, 'user_id' => auth()->user()->id], // loading
        ];

        $barging->dwellingTime()->createMany($dwellingTime);

        return $barging;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Barging $barging)
    {
        $this->authorize('view', Barging::class);
        return $barging;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BargingRequest $request, Barging $barging)
    {
        $this->authorize('update', Barging::class);
        $barging->update($request->all());

        foreach ($request->barging_material as $r)
        {
            if (isset($r['id'])) {
                BargingMaterial::find($r['id'])->update($r);
            }

            else {
                $barging->bargingMaterial()->create($r);
            }
        }

        return $barging;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barging $barging)
    {
        $this->authorize('delete', Barging::class);
        $barging->bargingMaterial()->delete();
        $barging->dwellingTime()->delete();
        return ['success' => $barging->delete()];
    }

}
