<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function getAll()
    {
        return $this->sendResponse('SUCCED', 200, 'Has entrado al metodo GetAll', null);
    }
    
    public function create(Request $request)
    {
        return $this->sendResponse('SUCCED', 200, 'Has entrado al metodo Create', null);
    }
    
    public function getById(string $id)
    {
        return $this->sendResponse('SUCCED', 200, 'Has entrado al metodo GetById', null);
    }

    public function update(Request $request, string $id)
    {
        return $this->sendResponse('SUCCED', 200, 'Has entrado al metodo Update', null);
    }
    
    
    public function delete(string $id)
    {
        return $this->sendResponse('SUCCED', 200, 'Has entrado al metodo Delete', null);
    }

    public function sendResponse($status, $cod, $mensaje, $data) {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}