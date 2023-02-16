<?php

namespace App\Http\Controllers;

use App\Services\SawahService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(
        public SawahService $sawahService
    ) {
    }

    public function index(Request $request)
    {
        $all_sawah = $this->sawahService->getAll();
        return view('admin.index', compact('all_sawah'));
    }

    public function list(Request $request)
    {
        $all_sawah = $this->sawahService->getAll();
        return view('admin.list', compact('all_sawah'));
    }
}
