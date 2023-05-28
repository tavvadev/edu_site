<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

use App\Http\Requests;
class indexController extends Controller
{
    //
    public function index(Request $request){
      
        $data = [];
        $data['meta']['meta_title']="meta_title";
        $data['meta']['meta_description']="meta_description";
        $data['meta']['meta_keywords']="meta_keywords";
        $pageContent =  view('fe.home',compact(['data']));
        return $pageContent;
        
    }
}
