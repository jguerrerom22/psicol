<?php

namespace App\Http\Controllers;

use App\Comprador;
use Illuminate\Http\Request;
use Validator;
use Ticket;

class CompradorController extends Controller
{
    
    public function getAll()
    {
        $compradores = \App\Comprador::all();
        return response()->json($compradores, 200);
    }

    public function getByDoc($id)
    {
        $comprador = Comprador::where('documento', $id)->first();
        if (is_null($comprador)){
            return response()->json(['message' => 'Comprador no encontrado'], 404);
        }
        return response()->json($comprador, 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'nombre' => 'required|min:3',
            'apellido' => 'required|min:3'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $comprador = Comprador::create($request->all());
        return response()->json($comprador, 201);
    }

    public function createTicket(Request $request, $documento)
    {
        $ticket = \App\Ticket::find($request->ticket);
        if (is_null($ticket)){
            return response()->json([message => 'Boleta no encontrada'], 404);
        }
        
        $comprador = Comprador::where('documento', $documento)->first();
        if (is_null($comprador)){
            return response()->json(['message' => 'Comprador no encontrado'], 404);
        }

        // Asigna el ticket al comprador
        $comprador->tickets()->attach($ticket);
        
        // Decrementa la cantidad disponible de tickets
        $ticket->disponible = $ticket->disponible - 1;
        $ticket->save();

        return response()->json($comprador, 201);
    }
}
