<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function payments($id = null, $group = null)
    {
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : date('Y-m-01');
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" : "'".date('Y-m-01')."'";
        $payments = DB::select('WITH alltasks as(SELECT c.id, c.name, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `clients` a on b.client_id=a.id join partners c on c.id=a.partner_id where b.created_at >='.$where_.' GROUP BY c.id, c.name), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM `clients` b JOIN `partners` a on b.partner_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        $staffs = DB::select('WITH alltasks as(SELECT a.id, a.name, a.sex, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `users` a on b.user_id=a.id where b.created_at >='.$where_.' GROUP BY a.id, a.name,a.sex), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM `clients` b JOIN `users` a on b.user_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.sex, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        $top = DB::select('SELECT a.id, a.name, a.code, count(b.id) as total, sum(b.amount) as amount, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `users` a on b.user_id=a.id WHERE date >='.$where_.' GROUP BY a.id, a.name, a.code ORDER BY sum(b.amount) desc');
        $limit = count($top)*2;
        return view('message.payments',
        [
            'partners' => $payments,
            'collections' => DB::select('SELECT b.uuid, a.name as collector, a.uuid as user_id, b.client_id, p.name, c.account, c.branch, c.phone, b.amount as amount, b.date FROM `payments` b JOIN `users` a on b.user_id=a.id join clients c on c.id=b.client_id  join partners p on p.id=c.partner_id ORDER BY a.id desc limit '.$limit),
            'payments' => $top,
            'staffs' => $staffs,
        ]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Create', [
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')->get()->map->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->contacts()->create(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('contacts')->with('success', 'Contact created.');
    }

}
