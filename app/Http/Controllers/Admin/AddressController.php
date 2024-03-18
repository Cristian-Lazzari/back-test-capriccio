<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    private $validations = [
        'comune'   => 'required|string|max:50',
        'provincia'   => 'required',
    ];

    public function index()
    {
        $addresses = Address::paginate(30);

        return view('admin.addresses.index', compact('addresses'));
    }


    public function create()
    {
        return view('admin.addresses.create');
    }


    public function store(Request $request)
    {
        $request->validate($this->validations);

        $data = $request->all();

        $newAddress = new Address();

        $newAddress->comune          = $data['comune'];
        $newAddress->provincia       = $data['provincia'];

        $newAddress->save();


        return redirect()->route('admin.addresses.index');
    }



    public function edit(Address $address)
    {
        return view('admin.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        $request->validate($this->validations);

        $data = $request->all();


        $address->comune          = $data['comune'];
        $address->provincia       = $data['provincia'];


        $address->update();


        return to_route('admin.addresses.index', ['address' => $address]);
    }

    public function destroy( $id)
    {
        $address = Address::where('id', $id)->firstOrFail();
        $address->delete();
        return to_route('admin.addresses.index')->with('delete_success', $address);
    }
}
