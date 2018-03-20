<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{

    public function main(){
        $data['lists'] =Project::get();
        return view('manage.project.main',$data);
    }

}
