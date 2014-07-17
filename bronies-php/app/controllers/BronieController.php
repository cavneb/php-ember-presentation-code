<?php

class BronieController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bronies = Bronie::all();
  	return Response::json(array('bronies' => $bronies));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
	    'name'       => 'required',
	    'email'      => 'required|email',
	    'pony_name'  => 'required'
	  );

	  $validator = Validator::make(Input::all(), $rules);

	  if ($validator->fails()) {
	    return Response::json(array('errors' => $validator->messages()));

	  } else {
	    $bronie = new Bronie;
	    $bronie->name       = Input::get('name');
	    $bronie->email      = Input::get('email');
	    $bronie->pony_name  = Input::get('pony_name');
	    $bronie->save();

	    return Response::json(array('bronie' => $bronie));
	  }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bronie = Bronie::find($id);

	  if ($bronie) {
	    return Response::json(array('bronie' => $bronie));

	  } else {
	    return Response::make(NULL, 404);
	  }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
	    'name'       => 'required',
	    'email'      => 'required|email',
	    'pony_name'  => 'required'
	  );

	  $validator = Validator::make(Input::all(), $rules);

	  if ($validator->fails()) {
	    return Response::json(array('errors' => $validator->messages()));

	  } else {
	    $bronie = Bronie::find($id);

	    if ($bronie) {
	      $bronie->name       = Input::get('name');
	      $bronie->email      = Input::get('email');
	      $bronie->pony_name  = Input::get('pony_name');
	      $bronie->save();
	      return Response::json(array('bronie' => $bronie));

	    } else {
	      return Response::make(NULL, 404);
	    }
	  }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$bronie = Bronie::find($id);
	  if ($bronie) {
	    $bronie->delete();
	    return Response::make(NULL, 202);
	  } else {
	    return Response::make(NULL, 404);
	  }
	}


}
