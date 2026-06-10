<?php
namespace App\Services;

use App\Models\Lawsuit;

class LawsuitService
{
    public function getFilteredLawsuits($request)
    {
        $sortOrder = $request->get('sortorder') ?? 'id_desc';
        list($sort, $order) = explode('_', $sortOrder);

        $lawsuits = Lawsuit::with('client', 'car')
            ->when(auth()->user()->isClient(), function ($query) {
                $query->where('client_id', auth()->id());
            })
            ->when(auth()->user()->isAgent(), function ($query) {
                $query->where('agent_id', auth()->id());
            })
            ->when($sort == 'name', function ($query) use ($order) {
                $query->join('users', 'users.id', '=', 'lawsuits.client_id')
                    ->orderBy('users.name', $order);
            }, function ($query) use ($sort, $order) {
                $query->orderBy($sort, $order);
            });

        if ($request->get('search')) {
            $lawsuits->where(function ($query) use ($request) {
                $searchTerm = '%' . $request->get('search') . '%';

                $query->where('lawsuit_no', 'like', $searchTerm)
                ->orWhere('invoice_no', 'like', $searchTerm)
                    ->orWhere('payment_date', 'like', $searchTerm)
                    ->orWhereHas('client', function ($query) use ($searchTerm) {
                        $query->where('mobile', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('car', function ($query) use ($searchTerm) {
                        $query->where('license_plate', 'like', $searchTerm);
                    })
                    ->orWhereHas('inc_company', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('appraiser_data', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('comments', function ($query) use ($searchTerm) {
                        $query->where('message', 'like', $searchTerm);
                    })->orWhereHas('agent', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    })
                    ;
            });
        }

        if ($request->get('status') == 'all') {
        } elseif ($request->get('status') != '') {
            $lawsuits->where('lawsuits.status', $request->get('status'));
        } else {
            $lawsuits->where('lawsuits.status', '!=', 0);
        }

        // Date range filter based on created_at column
        if ($request->get('start_date')) {
            $lawsuits->whereDate('lawsuits.created_at', '>=', $request->get('start_date'));
        }

        if ($request->get('end_date')) {
            $lawsuits->whereDate('lawsuits.created_at', '<=', $request->get('end_date'));
        }

        return $lawsuits->paginate(30)->withQueryString();
    }
}
