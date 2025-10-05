<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        if($clients->isEmpty()){
            return response()->json(['message' => 'No clients found'], 404);
        }

        return response()->json($clients, 200);
    }
    public function show($id)
    {
        $client = Client::find($id);

        if(!$client){
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('clients', 'email')],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::create($validator->validated());

        return response()->json($client, 201);
    }
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if(!$client){
            return response()->json(['message' => 'Client not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->ignore($client->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client->update($validator->validated());

        return response()->json($client, 200);
    }
    public function destroy($id)
    {
        $client = Client::find($id);

        if(!$client){
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted successfully'], 200);
    }
}
