<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrawlRequest;
use App\Http\Requests\LeadGenerationRequest;
use App\Http\Requests\PortalRequest;
use App\Jobs\MailJob;
use App\Models\Campaign;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\LeadType;
use App\Models\Portal;
use App\Models\Sale;
use App\Models\SaleFunnel;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Note\Note;
use RealRashid\SweetAlert\Facades\Alert;
use World\Countries\Model\Country;

class DealController extends Controller
{
    /**
     * handle the proceed with deal
     * hear
     * @param string $id
     * @return Application|Factory|View
     */
    public function confirmDeal(string $id)
    {
        try {
            $sale = Sale::query()
                ->with(['product', 'lead'])
                ->findOrFail($id);

            // notify the user who made the deal
            Note::createSystemNotification(
                User::class,
                $sale->product->name . ' Deal Confirmation',
                'Lead ' . $sale->lead->email . ' has just confirmed the deal, proceed and close the deal'
            );

            // update sale status
            $sale->update([
                'is_confirmed' => true
            ]);

            return view('deals.page', [
                'sale' => $sale,
                'message' => 'You have confirmed your deal successfully. Thank you for interest.'
            ]);
        } catch (Exception $exception) {
            return view('deals.page', [
                'sale' => null,
                'message' => 'Failed to confirm the deal.'
            ]);
        }
    }

    /**
     * handle the proceed with deal
     * hear
     * @param string $id
     * @return Application|Factory|View
     */
    public function cancelDeal(string $id)
    {
        try {
            $sale = Sale::query()
                ->with(['product', 'lead'])
                ->findOrFail($id);

            // notify the user who made the deal
            Note::createSystemNotification(
                User::class,
                $sale->product->name . ' Deal Cancellation',
                'Lead ' . $sale->lead->email . ' has just cancelled the deal.'
            );

            // update sale status
            $sale->update([
                'is_cancelled' => true
            ]);

            return view('deals.page', [
                'sale' => $sale,
                'message' => 'You have confirmed your deal successfully. Thank you for interest.'
            ]);
        } catch (Exception $exception) {
            return view('deals.page', [
                'sale' => null,
                'message' => 'Failed to confirm the deal.'
            ]);
        }
    }

    /**
     * get the page to get a lead
     * @param string $slug
     * @return Application|Factory|View
     */
    public function leadGenerationPage(string $slug)
    {
        if (!request()->hasValidSignature()) {
            Alert::error('Wrong Link', 'Sorry! The link you are using is wrong. Kindly check and try again.');
        }

        return view('leads.generation', [
            'types' => LeadType::query()->get(),
            'campaign' => Campaign::query()->firstWhere('slug', $slug)
        ]);
    }

    /**
     * Generate lead
     * @param LeadGenerationRequest $request
     * @return RedirectResponse
     */
    public function leadGeneration(LeadGenerationRequest $request)
    {
        if ($request->filled(['email', 'phone_number'])) {
            // fetch the campaign again
            $campaign = Campaign::query()->findOrFail($request->campaign_id);

            // get the user details from the network
            $global = geoip(request()->getClientIp());

            // fetch the country here
            $country = Country::query()
                ->where('name', 'like', '%' . $global['country'] . '%')
                ->first();

            // create a new lead here
            Lead::query()->updateOrCreate([
                'sale_funnel_id' => SaleFunnel::query()->oldest()->first()->id,
                'country_id' => $country->id,
                'company_id' => $campaign->company_id,
                'lead_type_id' => $request->category,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'location' => $global['city']
            ]);

            // dispatch email
            if ($request->has('email'))
                dispatch(new MailJob(
                    $request->email,
                    $campaign->name . ' Confirmation',
                    $request->name,
                    'Thank you for the info. We will be in contact with you very soon.'
                ))->onQueue('emails')->delay(2);


            toast('Thank you for the info. We will be in contact with you very soon.', 'success');

            return redirect()->to('/');
        }
        toast('Kindly give your email or phone number.', 'error');

        return redirect()->back();
    }

    /**
     * get portal page
     * @return Application|Factory|View
     */
    public function portalPage()
    {
        return view('leads.portal', [
            'industries' => Industry::query()->orderBy('name')->get()
        ]);
    }

    /**
     * add portal
     * @param PortalRequest $request
     * @return RedirectResponse
     */
    public function portal(PortalRequest $request)
    {
        // model query
        $query = new Portal();

        // query the industry here
        $portal = $query
            ->newQuery()
            ->where('industry_id', $request->industry_id)
            ->first();

        // continue
        if ($portal) {
            // define variables and assign
            $funnels = $portal->funnels;
            $urls = $portal->urls;

            // push new items to the arrays
            array_push($funnels, ucfirst(Str::lower($request->funnel)));
            array_push($urls, $request->url);

            // do an update
            $portal->update([
                'funnels' => $funnels,
                'urls' => $urls
            ]);
            toast('Successfully added new portal details.', 'success');

            return redirect()->back();
        }

        // create the new one here
        $query->newQuery()->create([
            'industry_id' => $request->industry_id,
            'funnels' => array(ucfirst(Str::lower($request->funnel))),
            'urls' => array($request->url),
        ]);
        toast('Successfully added new portal details.', 'success');

        return redirect()->back();
    }
}
