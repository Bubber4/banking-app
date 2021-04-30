<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = DB::select('SELECT cust.*, bran.name
                                FROM customers AS cust
                                LEFT JOIN branches AS bran
                                ON cust.branch_id = bran.id');
        return view('customers.index')->with(['customers'=>$customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $branches = DB::select('SELECT id,name FROM branches');
        return view('customers.create')->with(['branches'=>$branches]);;
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
			'first_name' => 'required|max:64',
			'last_name' => 'required|max:64',
			'balance' => 'numeric',
			'birth' => 'required|date|before:tomorrow',
			'phone' => 'required|max:64',
			'email' => 'required|email:rfc,dns',
			'branch_id' => 'required|numeric',
			'gdpr_compliant' => 'required'
		];
        // I am just leaving this one as a sample customized message
		$messages = [
			'first_name.max' => 'You are called what!?',
			'first_name.required' => '... No ones got no name.'
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		};

        // If it gets validated correcty
        $new_user_id = DB::insert('INSERT INTO `customers` 
            (`first_name`, `last_name`, `balance`, `birth`, `phone`, `email`, `branch_id`)
            VALUES 
            (?, ?, ?, ?, ?, ?, ?)', [
            $request->first_name, $request->last_name, $request->balance, $request->birth, $request->phone, $request->email, $request->branch_id
        ]);

        return redirect()->back()->with('message', 'Customer created successfully');
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
        //
        $customer = DB::select('SELECT * FROM customers WHERE id = ?', [$id]);
        $branches = DB::select('SELECT id,name FROM branches');

        return view('customers.edit')->with(['branches'=>$branches, 'customer'=>$customer[0]]);
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
			'first_name' => 'required|max:64',
			'last_name' => 'required|max:64',
			'balance' => 'required|numeric',
			'birth' => 'required|date|before:tomorrow',
			'phone' => 'required|max:64',
			'email' => 'required|email:rfc,dns',
			'branch_id' => 'required|numeric'
		];
        // I am just leaving this one as a sample customized message
		$messages = [
			'first_name.max' => 'You are called what!?',
			'first_name.required' => '... No ones got no name.'
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		};

        // If it gets validated correcty
        DB::update('UPDATE `customers` 
            SET
            `first_name` = ?,
            `last_name` = ?,
            `balance` = ?,
            `birth` = ?,
            `phone` = ?,
            `email` = ?,
            `branch_id` = ?
            WHERE `id` = ?', [
            $request->first_name,
            $request->last_name,
            $request->balance,
            $request->birth,
            $request->phone,
            $request->email,
            $request->branch_id,
            $id
        ]);

        return redirect()->back()->with('message', 'Customer updated successfully.');
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
        $affected_lines = DB::delete('DELETE FROM `customers` WHERE id = ?', [$id]);
        return redirect()->back();
    }

    /**
     * Shows the transfer page.
     *
     * @param  int  $customer_sender_id
     * @return \Illuminate\Http\Response
     */
    public function transfer($customer_sender_id)
    {
        //
        $customer = DB::select('SELECT * FROM customers WHERE id = ?', [$customer_sender_id]);
        $all_customers = DB::select('SELECT * FROM customers WHERE id != ?', [$customer_sender_id]);

        return view('customers.transfer')->with(['customer'=>$customer[0], 'customers'=>$all_customers]);
    }

    /**
     * Transfers balance between two customers.
     *
     * @param  int  $customer_sender_id
     * @return \Illuminate\Http\Response
     */
    public function transfer_to(Request $request, $customer_sender_id)
    {

        $customer = DB::select('SELECT * FROM customers WHERE id = ?', [$customer_sender_id]);

        //
        $rules = [
			'amount' => 'required|numeric|max:'.$customer[0]->balance,
			'recipient_customer_id' => 'required|numeric'
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		};





        // If it gets validated correcty
        $transaction_id = DB::insert('INSERT INTO `transfers` 
            (`sender_id`, `receiver_id`, `amount`)
            VALUES 
            (?, ?, ?)', [
            $customer_sender_id, $request->recipient_customer_id, $request->amount
        ]);

        // if the transaction is successful
        if ($transaction_id > 0) {
            // SENDER gets amount SUBSTRACTED
            DB::update('UPDATE `customers` 
                        SET
                        `balance` = `balance`-?
                        WHERE `id` = ?', [
                        $request->amount,
                        $customer_sender_id
            ]);

            // RECIPIENT gets amount ADDED
            DB::update('UPDATE `customers` 
                        SET
                        `balance` = `balance`+?
                        WHERE `id` = ?', [
                        $request->amount,
                        $request->recipient_customer_id
            ]);
        }

        return redirect()->back()->with('message', 'Transaction finished successfully');
    }
}
