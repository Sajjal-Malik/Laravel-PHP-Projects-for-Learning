<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create(){
        $url = url("/customer");
        $title = "Customer Registration";
        $data = compact('url', 'title');
        return view('customer_form')->with($data);
    }

    public function store(Request $request){

        $customer = new Customer;
        $customer->name = $request['name'];
        $customer->email = $request['email'];
        $customer->address = $request['address'];
        $customer->country = $request['country'];
        $customer->state = $request['state'];
        $customer->gender = $request['gender'];
        $customer->dob = $request['dob'];
        $customer->password = md5($request['password']);
        $customer->save();

        return redirect('/customer');
    }

    public function view(){
        
        $customers = Customer::all();
        $data = compact('customers');
        return view('customer_view')->with($data);
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
            return redirect('customer');
        }
        else{
            $title = "Update Customer";
            $url = url("/customer/update") . "/" . $id;
            $data = compact('customer', 'url', 'title');
            return view('customer_form')->with($data);
        }
    }

    public function update($id, Request $request){

        $customer = Customer::find($id);
        $customer->name = $request['name'];
        $customer->email = $request['email'];
        $customer->address = $request['address'];
        $customer->country = $request['country'];
        $customer->state = $request['state'];
        $customer->gender = $request['gender'];
        $customer->dob = $request['dob'];
        $customer->save();

        return redirect('customer');
    }
}
