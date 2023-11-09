<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\CreateCompanyRequest;
use App\Http\Requests\Companies\DestroyCompanyRequest;
use App\Http\Requests\Companies\DuplicateCompanyRequest;
use App\Http\Requests\Companies\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Companies/Index');
    }



    public function search(Request $request)
    {
        $query = Company::query();
        
        // START: Search
        if ($request->search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('name', $request->search)
                ->orWhereFuzzy('description', $request->search)
                ->orWhereFuzzy('notes', $request->search);
            });
        }
        // END: Search



        // START: Filter
        if ($request->legal_form)
        {
            $query->whereIn('legal_form', $request->legal_form);
        }
        // END: Filter



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';
        
        $query->orderBy($field, $order);
        // END: Sort



        // START: Identifiers
        $ids = $query->pluck('companies.id')->toArray();
        // END: Identifiers



        // START: Pagination
        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);
        
        $query->limit($limit)->offset($offset);
        // END: Pagination

        return response()->json([
            'data' => CompanyResource::collection($query->get()),
            'item_ids' => $ids,
            'total' => $total,
        ]);
    }



    public function create(Company $company)
    {
        return Inertia::render('Admin/Companies/Create', [
            'item' => CompanyResource::make($company),
        ]);
    }



    public function store(CreateCompanyRequest $request)
    {
        // Create the user
        $company = Company::create($request->only([
            'name',
            'legal_form',
            'description',
            'notes',
        ]));
        


        // Set the user's addresses
        collect($request->addresses)->each(function ($i) use ($company) { $company->addresses()->create($i); });

        // Set the user's legal details
        collect($request->legal_details)->each(function ($i) use ($company) { $company->legal_details()->create($i); });

        // Set the user's bank details
        collect($request->bank_details)->each(function ($i) use ($company) { $company->bank_details()->create($i); });

        // Set the user's emails
        collect($request->emails)->each(function ($i) use ($company) { $company->emails()->create($i); });

        // Set the user's phone numbers
        collect($request->phone_numbers)->each(function ($i) use ($company) { $company->phone_numbers()->create($i); });

        // Set the user's significant dates
        collect($request->significant_dates)->each(function ($i) use ($company) { $company->significant_dates()->create($i); });

        // Set the user's website links
        collect($request->website_links)->each(function ($i) use ($company) { $company->website_links()->create($i); });



        return redirect()->route('admin.companies.editor', $company->id);
    }



    public function duplicate(DuplicateCompanyRequest $request, Company $company)
    {
        $company->duplicate();

        return back();
    }



    public function update(UpdateCompanyRequest $request, Company $company)
    {
        // Update the company
        $company->update($request->only([
            'name',
            'legal_form',
            'description',
            'notes',
        ]));



        // Remove the company's addresses
        $company->addresses()->whereIn('id', $request->removed_addresses)->delete();

        // Set the company's addresses
        foreach ($request->addresses as $address) {
            $company->addresses()->updateOrCreate(['id' => $address['id']], $address);
        }



        // Remove the company's legal details
        $company->legal_details()->whereIn('id', $request->removed_legal_details)->delete();

        // Set the company's legal details
        foreach ($request->legal_details as $legal_detail) {
            $company->legal_details()->updateOrCreate(['id' => $legal_detail['id']], $legal_detail);
        }



        // Remove the company's bank details
        $company->bank_details()->whereIn('id', $request->removed_bank_details)->delete();

        // Set the company's bank details
        foreach ($request->bank_details as $bank_details) {
            $company->bank_details()->updateOrCreate(['id' => $bank_details['id']], $bank_details);
        }



        // Remove the company's emails
        $company->emails()->whereIn('id', $request->removed_emails)->delete();

        // Set the company's emails
        foreach ($request->emails as $email) {
            $company->emails()->updateOrCreate(['id' => $email['id']], $email);
        }



        // Remove the company's phone numbers
        $company->phone_numbers()->whereIn('id', $request->removed_phone_numbers)->delete();

        // Set the company's phone numbers
        foreach ($request->phone_numbers as $phone_number) {
            $company->phone_numbers()->updateOrCreate(['id' => $phone_number['id']], $phone_number);
        }



        // Remove the company's significant dates
        $company->significant_dates()->whereIn('id', $request->removed_significant_dates)->delete();

        // Set the company's significant dates
        foreach ($request->significant_dates as $significant_date) {
            $company->significant_dates()->updateOrCreate(['id' => $significant_date['id']], $significant_date);
        }



        // Remove the company's website links
        $company->website_links()->whereIn('id', $request->removed_website_links)->delete();

        // Set the company's website links
        foreach ($request->website_links as $website_link) {
            $company->website_links()->updateOrCreate(['id' => $website_link['id']], $website_link);
        }

        return back();
    }



    public function delete(DestroyCompanyRequest $request)
    {
        Company::whereIn('id', $request->ids)->delete();

        return back();
    }



    public function export(Request $request)
    {
    }
}
