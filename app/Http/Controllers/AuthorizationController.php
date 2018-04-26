<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Authorization;
use App\Http\Requests\AuthorizationRequest;

class AuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Authorization::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'users.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $authorization = Authorization::selectRaw('authorizations.*, users.name AS user')
                ->join('users', 'users.id', '=', 'authorizations.user_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('controller', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('users.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $authorization->perPage(),
                'total' => $authorization->total(),
                'current' => $authorization->currentPage(),
                'rows' => $authorization->items(),
            ];
        }

        return view('authorization.index', [
            'breadcrumbs' => [
                '#' => 'Administration',
                'authorization' => 'Authorization'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationRequest $request)
    {
        $this->authorize('create', Authorization::class);
        return Authorization::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Authorization $authorization)
    {
        $this->authorize('view', Authorization::class);
        return $authorization;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorizationRequest $request, Authorization $authorization)
    {
        $this->authorize('update', Authorization::class);
        $authorization->update($request->all());
        return $authorization;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authorization $authorization)
    {
        $this->authorize('delete', Authorization::class);
        return ['success' => $authorization->delete()];
    }
}
