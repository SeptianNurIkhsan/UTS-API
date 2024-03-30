<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact; // Tambahkan namespace untuk model Contact
use App\Models\Address; // Tambahkan namespace untuk model Address
use App\Http\Resources\AddressResource; // Tambahkan namespace untuk resource Address

class AddressController extends Controller
{
    public function createAddress(Request $request, $idContact)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'street' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Membuat alamat baru
        $address = new Address([
            'street' => $request->street,
            'city' => $request->city,
            'province' => $request->province,
            'country' => $request->country,
            'postal_code' => $request->postal_code
        ]);

        // Menyimpan alamat pada kontak yang sesuai
        $contact = Contact::find($idContact);
        if (!$contact) {
            return response()->json(['errors' => 'Contact not found'], 404);
        }

        $contact->addresses()->save($address);

        // Mengembalikan respons sukses
        return new AddressResource($address); // Menggunakan AddressResource untuk mengubah response menjadi JSON
    }

    public function getAddressList($idContact)
    {
        // Mengambil daftar alamat untuk kontak tertentu
        $contact = Contact::find($idContact);
        if (!$contact) {
            return response()->json(['errors' => 'Contact not found'], 404);
        }

        $addresses = $contact->addresses;

        // Mengembalikan daftar alamat dalam respons
        return response()->json(['data' => $addresses], 200);
    }
}