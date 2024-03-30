<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact; // Tambahkan namespace untuk model Contact
use App\Http\Resources\ContactResource; // Tambahkan namespace untuk resource Contact

class ContactController extends Controller
{
    public function create(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Membuat kontak baru
        $contact = new Contact([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $contact->save();

        // Mengembalikan respons sukses
        return new ContactResource($contact); // Menggunakan ContactResource untuk mengubah response menjadi JSON
    }

    public function search(Request $request)
    {
        // Implementasi pencarian kontak berdasarkan parameter yang diberikan
        // Anda dapat menyesuaikan implementasi ini sesuai dengan kebutuhan Anda

        // Contoh implementasi sederhana
        $contacts = Contact::query();

        if ($request->has('name')) {
            $contacts->where('first_name', 'like', '%' . $request->name . '%')
                     ->orWhere('last_name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('phone')) {
            $contacts->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->has('email')) {
            $contacts->where('email', 'like', '%' . $request->email . '%');
        }

        // Implementasi paginasi
        $pageSize = $request->input('size', 10);
        $contacts = $contacts->paginate($pageSize);

        return response()->json(['data' => $contacts->items(), 'meta' => [
            'current_page' => $contacts->currentPage(),
            'per_page' => $contacts->perPage(),
            'total' => $contacts->total(),
        ]]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Perbarui kontak yang ada
        $contact = Contact::findOrFail($id);
        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return new ContactResource($contact); // Menggunakan ContactResource untuk mengubah response menjadi JSON
    }

    public function get($id)
    {
        // Dapatkan kontak berdasarkan ID
        $contact = Contact::findOrFail($id);

        return new ContactResource($contact); // Menggunakan ContactResource untuk mengubah response menjadi JSON
    }

    public function delete($id)
    {
        // Hapus kontak berdasarkan ID
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['data' => true], 200);
    }
}