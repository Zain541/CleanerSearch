<?php

namespace App\Http\Controllers\Admin;

use App\ContractType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function add_record_validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100','unique:contract_types'],
        ]);
    }

     protected function update_record_validator(array $data, $id)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100','unique:contract_types,name,' . $id . ',id'],
        ]);
    }

    public function index()
    {
        $contracttypes = ContractType::all();
        return view("admin.contracttypes.index",compact('contracttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.contracttypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->add_record_validator($request->all())->validate();

        if(ContractType::create([
            'name' => $request['name'],
        ]))
        {
            return \Response::json(['msg' => "true"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contracttype = ContractType::findOrFail($id);
        return view('admin.contracttypes.edit',compact('contracttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->update_record_validator($request->all(), $id)->validate();

        $contracttype = ContractType::findOrFail($id);

        $contracttype->name = $request->name;
        if($contracttype->save())
        {
            return \Response::json(['msg' => "true"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
