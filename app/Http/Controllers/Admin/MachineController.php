<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreMachineRequest;
use App\Http\Requests\UpdateMachineRequest;
use App\Machine;
use  App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Show all machines
     *
     * @return void
     */
    public function index()
    {
        $machines = Machine::all();

        return view('backend.machines.index', compact('machines'));

    }

    /**
     * Store a machine
     *
     * @return void
     */
    public function store(StoreMachineRequest $request)
    {   
        Machine::create($request->all());

        return redirect()->route('admin.machine.index');

    }

    /**
     * Update a machine
     *
     * @return void
     */
    public function update(UpdateMachineRequest $request, Machine $machine)
    {
        $machine->update($request->all());

        return redirect()->route('admin.machine.index');
    }



}