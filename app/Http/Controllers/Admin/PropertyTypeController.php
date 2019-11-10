<?php

namespace App\Http\Controllers\Admin;

use App\PropertyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function add_record_validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100','unique:property_types'],
        ]);
    }
    public function index()
    {
        $propertytypes = PropertyType::all();
        return view("admin.propertytypes.index",compact('propertytypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.propertytypes.create');
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

        if(PropertyType::create([
            'name' => $request['name'],
        ]))
        {
            return \Response::json(['msg' => "true"]);
        }
    }

    protected function update_record_validator(array $data, $id)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100','unique:property_types,name,' . $id . ',id'],
        ]);
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
        $propertytype = PropertyType::findOrFail($id);
        return view('admin.propertytypes.edit',compact('propertytype'));
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

        $propertytype = PropertyType::findOrFail($id);

        $propertytype->name = $request->name;
        if($propertytype->save())
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
