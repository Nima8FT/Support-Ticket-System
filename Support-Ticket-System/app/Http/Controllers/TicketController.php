<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TicketResource;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tickets = Ticket::latest()->paginate(5);
            $ticket_resource = TicketResource::collection($tickets);
            if ($this->user->role !== 'admin') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }
            return response()->json([
                'status' => 'success',
                'data' => $ticket_resource
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve the list of tickets. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['user_id'] = $this->user->id;

            $ticket = Ticket::create($inputs);

            return response()->json([
                'status' => 'success',
                'message' => 'Ticket created successfully.',
                'data' => $ticket
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create the ticket. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        try {
            $ticket->load('user');
            $ticket_resource = new TicketResource($ticket);
            return response()->json([
                'status' => 'success',
                'data' => $ticket_resource
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve the ticket details. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        try {
            $inputs = $request->only('status');

            if ($this->user->role !== 'admin') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }

            $ticket->update($inputs);

            return response()->json([
                'status' => 'success',
                'data' => $ticket
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update the ticket. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
