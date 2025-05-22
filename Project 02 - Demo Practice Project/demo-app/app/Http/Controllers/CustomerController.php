<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create(){

        $url = url('customer');
        $title = "Register Customer";
        $data = compact('url', 'title');
        return view('customer')->with($data);
    }

    public function store(Request $request){

        // echo "<pre>";
        // print_r($request->all());

        $customer = new Customer();
        $customer->name = $request['name'];
        $customer->email = $request['email'];
        $customer->gender = $request['gender'];
        $customer->address = $request['address'];
        $customer->country = $request['country'];
        $customer->state = $request['state'];
        $customer->dob = $request['dob'];
        $customer->password = md5($request['password']);
        $customer->save();

        return redirect('customer/view');
    }

    public function view(){

        $customers = Customer::all();
        // echo "<pre>";
        // print_r($customers);
        // die;

        $data = compact('customers');

        return view('customer-view')->with($data);
    }

    public function delete($id){
        $customer = Customer::find($id);

        if(!is_null($customer)){
            $customer->delete();
        }

        return redirect('customer');
    }

    public function edit($id){
        $customer = Customer::find($id);
        if(is_null($customer)){
            // not found
            return redirect('customer');
        }
        else{
            // found
            $url = url('customer/update/') . "/" . $id;
            $title = "Update Customer";
            $data = compact('customer', 'url', 'title');

            return view('customer')->with($data);
        }
    }

    public function update($id, Request $request){
        
        $customer = new Customer();
        $customer->name = $request['name'];
        $customer->email = $request['email'];
        $customer->gender = $request['gender'];
        $customer->address = $request['address'];
        $customer->country = $request['country'];
        $customer->state = $request['state'];
        $customer->dob = $request['dob'];
        $customer->password = md5($request['password']);
        $customer->save();

        return redirect('customer/view');
    }
}
