<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;

class DashBoardController extends Controller
{
    /**
     * fetch the latest leads here
     * @return JsonResponse|object
     */
    public function leads()
    {
        return $this->successResponse(
            Lead::query()
                ->with([
                    'lead_stage.stage',
                    'company',
                    'assigned_lead.campaign',
                    'country',
                    'lead_type',
                    'sale',
                    'sale_funnel'
                ])
                ->latest()
                ->whereDate('created_at', '>=', today())
                ->where('company_id', request()->user()->company_id)
                ->where('is_lead', true)
                ->take(5)
                ->get()
        );
    }

    /**
     * get closed cases
     * @return JsonResponse|object
     */
    public function closed()
    {
        return $this->successResponse(
            Sale::query()
                ->with([
                    'lead',
                    'company'
                ])
                ->latest()
                ->where('is_closed', true)
                ->get()
        );
    }

    /**
     * get closed cases
     * @return JsonResponse|object
     */
    public function open()
    {
        return $this->successResponse(
            Sale::query()
                ->with([
                    'lead',
                    'company'
                ])
                ->latest()
                ->where('is_closed', false)
                ->get()
        );
    }
}
