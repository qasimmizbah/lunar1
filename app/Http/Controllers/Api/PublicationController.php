<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Production;

class PublicationController extends Controller
{
    public function index()
    {
        return response()->json(Production::all());
    }
}



?>