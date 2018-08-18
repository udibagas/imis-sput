<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Customer::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'customers.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $customer = Customer::selectRaw('customers.*, seams.name AS default_seam')
                ->join('seams', 'seams.id', '=', 'customers.default_seam_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.address', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.email', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.phone', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.fax', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $customer->perPage(),
                'total' => $customer->total(),
                'current' => $customer->currentPage(),
                'rows' => $customer->items(),
            ];
        }

        return view('customer.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'customer' => 'Customer'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $this->authorize('create', Customer::class);
        return Customer::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $this->authorize('view', Customer::class);
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->authorize('update', Customer::class);
        $customer->update($request->all());
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('delete', Customer::class);
        return ['success' => $customer->delete()];
    }
}
