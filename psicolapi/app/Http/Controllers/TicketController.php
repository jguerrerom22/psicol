<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Validator;

class TicketController extends Controller
{
    public function getAll()
    {
        $tickets = Ticket::all();
        return response()->json($tickets, 200);
    }

    public function getById($id)
    {
        $ticket = Ticket::find($id);
        if (is_null($ticket)){
            return response()->json(['message' => 'Ticket no encontrado'], 404);
        }
        return response()->json($ticket, 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'nombre' => 'required|min:5',
            'disponible' => 'required|min:1',
            'fecha_evento' => 'required',
            'lugar' => 'required|min:3'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $tickets = Ticket::create($request->all());
        return response()->json($tickets, 201);
    }
}
