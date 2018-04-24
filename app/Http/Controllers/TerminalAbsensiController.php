<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TerminalAbsensi;
use App\Http\Requests\TerminalAbsensiRequest;

class TerminalAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', TerminalAbsensi::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $terminalAbsensi = TerminalAbsensi::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $terminalAbsensi->perPage(),
                'total' => $terminalAbsensi->total(),
                'current' => $terminalAbsensi->currentPage(),
                'rows' => $terminalAbsensi->items(),
            ];
        }

        return view('terminalAbsensi.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'terminalAbsensi' => 'TerminalAbsensi'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerminalAbsensiRequest $request)
    {
        $this->authorize('create', TerminalAbsensi::class);
        return TerminalAbsensi::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TerminalAbsensi $terminalAbsensi)
    {
        $this->authorize('view', TerminalAbsensi::class);
        return $terminalAbsensi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TerminalAbsensiRequest $request, TerminalAbsensi $terminalAbsensi)
    {
        $this->authorize('update', TerminalAbsensi::class);
        $terminalAbsensi->update($request->all());
        return $terminalAbsensi;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TerminalAbsensi $terminalAbsensi)
    {
        $this->authorize('delete', TerminalAbsensi::class);
        return ['success' => $terminalAbsensi->delete()];
    }
}
