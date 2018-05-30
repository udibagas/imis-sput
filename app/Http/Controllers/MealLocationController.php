<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MealLocation;
use App\Http\Requests\MealLocationRequest;

class MealLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', MealLocation::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'meal_locations.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $mealLocation = MealLocation::selectRaw('meal_locations.*, users.name AS user')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('meal_locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('users.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })
                ->join('users', 'users.id', '=', 'meal_locations.user_id')
                ->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $mealLocation->perPage(),
                'total' => $mealLocation->total(),
                'current' => $mealLocation->currentPage(),
                'rows' => $mealLocation->items(),
            ];
        }

        return view('mealLocation.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                '#' => 'Master Data',
                'mealLocation' => 'Meal Location'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealLocationRequest $request)
    {
        $this->authorize('create', MealLocation::class);
        return MealLocation::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MealLocation $mealLocation)
    {
        $this->authorize('view', MealLocation::class);
        return $mealLocation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MealLocationRequest $request, MealLocation $mealLocation)
    {
        $this->authorize('update', MealLocation::class);
        $mealLocation->update($request->all());
        return $mealLocation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MealLocation $mealLocation)
    {
        $this->authorize('delete', MealLocation::class);
        return ['success' => $mealLocation->delete()];
    }
}
