<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\MailJob;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|object
     */
    public function user()
    {
        return $this->successResponse(
            request()->user()->load(
                'notification',
                'role',
                'company.industry.proposal_template',
                'company.industry.invoice_template',
                'company.industry.need_template',
                'company.industry.key_word',
                'company.product',
                'company.country',
                'company.sale.lead',
                'company.lead.lead_stage.stage',
                'company.opportunity',
                'company.promotion.running_promotion',
                'company.sale_funnel.lead',
                'company.sale_funnel.social_insight',
                'company.sale_funnel.tip',
                'company.campaign.assigned_lead.lead.lead_stage.stage',
                'company.marketing.tool',
                'company.social_insight.sale_funnel',
                'company.todo',
                'companies'
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            User::query()
                ->with([
                    'notification',
                    'role',
                    'company.industry.proposal_template',
                    'company.industry.invoice_template',
                    'company.industry.need_template',
                    'company.industry.key_word',
                    'company.product',
                    'company.country',
                    'company.sale.lead',
                    'company.lead.lead_stage.stage',
                    'company.opportunity',
                    'company.promotion.running_promotion',
                    'company.sale_funnel.lead',
                    'company.sale_funnel.social_insight',
                    'company.sale_funnel.tip',
                    'company.campaign.assigned_lead.lead.lead_stage.stage',
                    'company.marketing.tool',
                    'company.social_insight.sale_funnel',
                    'company.todo',
                    'companies'
                ])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddUserRequest $request
     * @return JsonResponse|object|void
     */
    public function store(AddUserRequest $request)
    {
        $password = $request->password;
        if (!isset($request->password)) {
            $password = Str::random(8);
        }

        $user = User::query()->create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        // dispatch mail job
        dispatch((new MailJob(
            $user->email,
            'Account Password',
            $user->name,
            'Your account password is ' . $password . ' .Kindly use it to log in.'
        )))->onQueue('emails')->afterResponse();

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse|Response|object
     */
    public function show(User $user)
    {
        return $this->successResponse(
            $user->load(
                'notification',
                'role',
                'company.industry.proposal_template',
                'company.industry.invoice_template',
                'company.industry.need_template',
                'company.industry.key_word',
                'company.product',
                'company.country',
                'company.sale.lead',
                'company.lead.lead_stage.stage',
                'company.opportunity',
                'company.promotion.running_promotion',
                'company.sale_funnel.lead',
                'company.sale_funnel.social_insight',
                'company.sale_funnel.tip',
                'company.campaign.assigned_lead.lead.lead_stage.stage',
                'company.marketing.tool',
                'company.social_insight.sale_funnel',
                'company.todo',
                'companies'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse|Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!isset($request->password)) {
            // dispatch mail job
            dispatch((new MailJob(
                $user->email,
                'Account Password',
                $user->name,
                'Your account password is ' . $request->password . ' .Kindly use it to log in.'
            )))->onQueue('emails')->afterResponse();
        }

        $user->save();

        return $this->successResponse($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse($user);
    }
}
