<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = DB::select('SELECT bran.*,
                                    (SELECT sum(balance) 
                                        FROM customers
                                        WHERE branch_id = bran.id ) total_balance,
                                    (SELECT COUNT(id)
                                        FROM customers
                                        WHERE branch_id = bran.id ) total_customers
                                FROM branches AS bran');
        return view('branches.index')->with(['branches'=>$branches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
			'name' => 'required|max:32',
			'address' => 'required|max:128',
			'city' => 'required|max:64',
			'country' => 'required|max:64',
			'postcode' => 'required|max:16'
		];
        // I am just leaving this one as a sample customized message
		$messages = [
			'name.max' => 'The branch name is too long!',
			'name.required' => 'The branch needs AT LEAST a name!'
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		};

        // If it gets validated correcty
        DB::insert('INSERT INTO `branches` 
            (`name`, `address`, `city`, `country`, `postcode`)
            VALUES 
            (?, ?, ?, ?, ?)', [
            $request->name, $request->address, $request->city, $request->country, $request->postcode, 
        ]);

        return redirect()->back()->with('message', $request->name.' branch created successfully');
    }

    /**
     * Display the top branches
     *
     * @return \Illuminate\Http\Response
     */
    public function top()
    {
        // Ugh... I couldn't find a better way, I know...
        // It would be better to create an if statement than these subqueries... 
        // but still I think that there must be an efficcient way of doing it within mysql
        $branches = DB::select('SELECT bran.*,
                        (SELECT sum(balance) 
                            FROM customers
                            WHERE branch_id = bran.id ) total_balance,
                        (SELECT COUNT(id)
                            FROM customers
                            WHERE branch_id = bran.id ) total_customers
                    FROM branches AS bran
                    WHERE (SELECT sum(balance) 
                            FROM customers
                            WHERE branch_id = bran.id ) > 50000
                        AND (SELECT COUNT(id)
                                FROM customers
                                WHERE branch_id = bran.id ) > 2');
                return view('branches.index')->with(['branches'=>$branches]);

        return view('branches.top')->with(['branches'=>$branches]);;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $branch = DB::select('SELECT * FROM branches WHERE id = ?', [$id]);
        return view('branches.edit')->with('branch', $branch[0]);
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
        //
        $rules = [
			'name' => 'required|max:32',
			'address' => 'required|max:128',
			'city' => 'required|max:64',
			'country' => 'required|max:64',
			'postcode' => 'required|max:16'
		];
        // I am just leaving this one as a sample customized message
		$messages = [
			'name.max' => 'The branch name is too long!',
			'name.required' => 'The branch needs AT LEAST a name!'
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		};

        // If it gets validated correcty
        DB::update('UPDATE `branches` 
            SET
            `name` = ?,
            `address` = ?,
            `city` = ?,
            `country` = ?,
            `postcode` = ?
            WHERE `id` = ?', [
            $request->name,
            $request->address,
            $request->city,
            $request->country,
            $request->postcode,
            $id
        ]);

        return redirect()->back()->with('message', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $affected_lines = DB::delete('DELETE FROM `branches` WHERE id = ?', [$id]);
        return redirect()->back();
    }
}
