<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketResponseRequest;
use App\Http\Requests\UpdateTicketResponseRequest;

class TicketResponseController extends Controller
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
            $ticket_responses = TicketResponse::latest()->paginate(5);
            if ($this->user->role !== 'admin') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }
            return response()->json([
                'status' => 'success',
                'data' => $ticket_responses
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve the list of ticket_responses. Please try again later.',
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
    public function store(StoreTicketResponseRequest $request)
    {
        try {
            $inputs = $request->only('ticket_id', 'response_body', 'parent_response_id');

            if ($this->user->role === 'admin') {
                $inputs['admin_id'] = $this->user->id;
                $inputs['status'] = 'answered';

                //for talbe ticket status is to answer by admin
                if (!$request->has('parent_response_id')) {
                    $idTicket = $inputs['ticket_id'];
                    $ticket = Ticket::find($idTicket);
                    $ticket->update([
                        'status' => 'answered'
                    ]);
                }
            } else {
                $inputs['user_id'] = $this->user->id;
            }

            $ticket_response = TicketResponse::create($inputs);

            return response()->json([
                'status' => 'success',
                'data' => $ticket_response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create the ticket_response. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketResponse $ticketResponse)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $ticketResponse
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
    public function edit(TicketResponse $ticketResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketResponseRequest $request, TicketResponse $ticketResponse)
    {
        try {
            $inputs = $request->only('status', 'response_body');

            if ($this->user->role !== 'admin') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }

            $ticketResponse->update($inputs);

            return response()->json([
                'status' => 'success',
                'data' => $ticketResponse
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
     * Remove the specified resource from storage.
     */
    public function destroy(TicketResponse $ticketResponse)
    {
        //
    }
}
