<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        return Inertia::render('Contacts/Index', [
            'filters' => Request::all('search', 'trashed'),
            'contacts' => Auth::user()->account->contacts()
                ->with('organization')
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($contact) => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'phone' => $contact->phone,
                    'city' => $contact->city,
                    'deleted_at' => $contact->deleted_at,
                    'organization' => $contact->organization ? $contact->organization->only('name') : null,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Create', [
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
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

    public function edit(Invoice $contact)
    {
        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'organization_id' => $contact->organization_id,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'city' => $contact->city,
                'region' => $contact->region,
                'country' => $contact->country,
                'postal_code' => $contact->postal_code,
                'deleted_at' => $contact->deleted_at,
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Invoice $contact)
    {
        $contact->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => [
                    'nullable',
                    Rule::exists('organizations', 'id')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id)),
                ],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Contact updated.');
    }

    public function destroy(Invoice $contact)
    {
        $contact->delete();

        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore(Invoice $contact)
    {
        $contact->restore();

        return Redirect::back()->with('success', 'Contact restored.');
    }



// Stores


public function dashboard(){
    $students = DB::select('SELECT b.uuid, b.name, sum(d.quantity) as used, sum(f.quantity) as purchased, sum(f.quantity) - sum(d.quantity) as remained   from  item_groups b join items g on (g.item_group_id=b.id and b.school_id=g.school_id) left join  item_purchase_lists f on (f.item_id=g.id and g.school_id=f.school_id)   left join  item_usage_lists d on (d.item_id=g.id and g.school_id=d.school_id) where g.school_id = '.Auth::User()->school_id.' group by b.uuid, b.name having sum(d.quantity) > 1 order by used desc limit 6');
    $stores = DB::select('SELECT b.name, g.name as item, sum(d.quantity) as used, sum(f.quantity) as purchased, sum(f.quantity) - sum(d.quantity) as remained   from  item_groups b join items g on (g.item_group_id=b.id and b.school_id=g.school_id) left join  item_purchase_lists f on (f.item_id=g.id and g.school_id=f.school_id)   left join  item_usage_lists d on (d.item_id=g.id and g.school_id=d.school_id) where g.school_id = '.Auth::User()->school_id.'  group by b.name, g.name having sum(d.quantity) > 1 order by used desc limit 6');
    //dd(json_encode($students));
    return Inertia::render('Store/Index', 
        [
            'students' => $students, 
            'item_groups' => DB::select('select name from item_groups where school_id ='. Auth::User()->school_id),
            'stores' => [
                'items' => DB::table('items')->where('school_id', Auth::User()->school_id)->count(),
                'groups' => DB::table('item_groups')->where('school_id', Auth::User()->school_id)->count(),
                'purchases' => DB::table('item_purchases')->where('school_id', Auth::User()->school_id)->count('amount'),
                ]
        ]);
}


public function group()
{
    return Inertia::render('Store/Group', [
        'filters' => Request::all('search', 'trashed'),
        'items' => \App\Models\Account::orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($client) => [
                'id' => $client->id,
                'uuid' => $client->uuid,
                'name' => $client->name,
                'warehouse' => $client->warehouse,
                'note' => $client->note,
                'item' => $client->items()->count(),
                'organization' => null,
            ]),
    ]);
}

public function items()
{
    $item = request()->segment(2);
    if(strlen($item)>20){
        $group = \App\Models\Account::where('uuid', $item)->first();
        $items = !empty($group) ? \App\Models\Item::where('item_group_id', $group->id)->orderBy('id', 'desc') : [];
    }else{
        $items = \App\Models\Item::orderBy('id', 'desc');
    }
    return Inertia::render('Store/Items', [
        'filters' => Request::all('search', 'trashed'),
        'items' => empty($items) ? [] : $items->filter(Request::only('search', 'trashed'))
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($client) => [
                'id' => $client->id,
                'uuid' => $client->uuid,
                'name' => $client->name,
                'code' => $client->code,
                'group' => $client->itemGroup->name,
                'measure' => $client->metric->name,
                'added' => $client->purchases()->sum('quantity'),
                'used' => $client->usages()->sum('quantity'),
                'balance' => $client->purchases()->sum('quantity') - $client->usages()->sum('quantity'),
            ]),
    ]);
}

public function purchases()
{
    $item = request()->segment(2);
    
    $title = 'All Items Used';
    $items = \App\Models\Invoice::orderBy('id', 'desc');

    return Inertia::render('Store/Purchase', [
        'filters' => Request::all('search', 'trashed'),
        'product' => $title,
        'task_type' => $item,
        'items' => empty($items) ? [] : $items->filter(Request::only('search', 'trashed'))
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($client) => [
                'id' => $client->id,
                'reference' => $client->reference,
                'uuid' => $client->uuid,
                'name' => $client->user->name,
                'amount' => $client->amount,
                'vendor' => $client->vendor,
                'date' => date('F d, Y', strtotime($client->date)),
                'total' => $client->items->count(),
                'used' => $client->items()->sum('quantity'),
            ]),
    ]);
}

public function usages()
{
    $type = request()->segment(2);
    $group = request()->segment(3);
    $item = request()->segment(4);
   
    if(strlen($group)>20 && $item == 'view'){
        $group = \App\Models\Item::where('uuid', $group)->first();
        $item = $group->name;
        $items = !empty($group) ? \App\Models\InvoiceItem::where('item_id', $group->id) : [];
    }elseif(strlen($item)>20){
        $group = \App\Models\Account::where('uuid', $group)->first();
        $item = $group->name;
        $items = !empty($group) ? \App\Models\InvoiceItem::whereIn('item_id', \App\Models\Item::where('item_group_id', $group->id)->get(['id']))->orderBy('id', 'desc') : [];
    }else{
        $item = 'All Items';
        $items =  \App\Models\InvoiceItem::orderBy('id', 'desc');         
    }

    return Inertia::render('Store/Usage', [
        'filters' => Request::all('search', 'trashed'),
        'product' => $item,
        'task_type' => $type,
        'items' => empty($items) ? [] : $items->filter(Request::only('search', 'trashed'))
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($client) => [
                'id' => $client->id,
                'uuid' => $client->usage->uuid,
                'reference' => $client->usage->reference,
                'name' => $client->usage->user->name,
                'vendor' => $client->usage->vendor,
                'date' => date('F d, Y', strtotime($client->usage->date)),
                'item' => !empty($client->item) ? $client->item->name : $client->name,
                'code' => !empty($client->item) ? $client->item->code : $client->name,
                'quantity' => $client->quantity,
                'amount' => money($client->amount),
            ]),
    ]);
}


public function addstore()
{
    return Inertia::render('Store/Create', ['school_id' => Auth::User()->school_id]);
}


public function editstore()
{
    $id = request()->segment(2);
    return Inertia::render('Store/Edit', ['item' => DB::table('item_groups')->where('uuid', $id)->first()]);
}
 
public function deletestore(){
    $id = request()->segment(2);
    \App\Models\Account::where('uuid', $id)->delete();
    return redirect('itemgroups')->with('error', 'Seems Class Techer Subject not well defined');
}
public function save()
{
    Request::validate([
            'name' => ['required', 'max:250'],
            'warehouse' => ['required', 'max:150'],
            'note' => ['required', 'max:250'],
        ]);
    \App\Models\Account::create(array_merge(request()->all(),['school_id' => Auth::User()->school_id]));
    return redirect('itemgroups')->with('success', 'client created.');
}

public function updatestore()
{
    $id = request()->segment(2);
    Request::validate([
            'name' => ['required', 'max:250'],
            'warehouse' => ['required', 'max:150'],
            'note' => ['required', 'max:250'],
        ]);
    \App\Models\Account::where('uuid', $id)->update(array_merge(request()->all(),['school_id' => Auth::User()->school_id]));
    return redirect('itemgroups')->with('success', 'client created.');
}

    
public function additem()
{
    return Inertia::render('Store/Add', [
        'groups' => DB::table('item_groups')->where('school_id', Auth::User()->school_id)->get(), 'metrics' => DB::table('constant.metrics')->get()]);
}
 


public function addusage()
{
    $type = request()->segment(2);
    return view('accounts.inventory.usage', ['type' => $type, 
    'groups' => DB::table('items')->where('school_id', Auth::User()->school_id)->get(),
    'users' => DB::table('users')->where('account_type_id', [1,2])->where('school_id', Auth::User()->school_id)->get(),
]);
}
 
public function saveitem()
{
        Request::validate([
            'name' => ['required', 'max:250'],
            'balance' => ['required', 'min:0'],
            'quantity' => ['required'],
            'metric_id' => ['required'],
            'item_group_id' => ['required'],
        ]);
   $item = \App\Models\Item::create(array_merge(request()->all(),['school_id' => Auth::User()->school_id, 'note' => request('name')]));
    return redirect('itemgroups')->with('success', 'client created.');
}

public function edititem()
{
    $id = request()->segment(2);
    return Inertia::render('Store/Update', ['groups' => DB::table('item_groups')->where('school_id', Auth::User()->school_id)->get(), 'metrics' => DB::table('constant.metrics')->get()]);
}

public function addPurchase($quantiy, $item, $vendor, $contact, $expense, $note, $date, $amount, $user){

}

public function saveusage()
{
    $id = request()->segment(2);
    //dd(request()->all());
    Request::validate([
            'contact' => ['required', 'max:250'],
            'vendor' => ['required', 'min:0'],
            'status' => ['required'],
            'staff_id' => ['required'],
            'note' => ['required'],
            'date' => ['required'],
        ]);
      
    if($id == 'usage'){
        $purchase = \App\Models\Invoice::create(['user_id' => Auth::User()->id, 'amount' => 0, 'vendor' => request('vendor'), 'contact' => request('contact'), 'note' => request('note'), 'expense_id' => 0, 'date' => request('date'), 'status' => request('status'),  'school_id' => Auth::User()->school_id]);
        $products = request('item_id');
        foreach ($products as $key => $product) {
            $item = \App\Models\Item::where(['id' => (int)request('item_id')[$key]])->first();
            $obj = [
                'name' => $item->name,'item_id' => $item->id, 'usage_id' => $purchase->id, 
                'quantity' => (float)request('quantity')[$key], 
                'amount' => (float)request('quantity')[$key] * (float)request('amount')[$key],
                'school_id' => Auth::User()->school_id
            ];
            \App\Models\InvoiceItem::create($obj);
        }
        $purchase = \App\Models\Invoice::where('id', $purchase->id)->first();
    }
    return redirect('viewstore/'.$purchase->uuid.'/'.$id)->with('success', 'client created.');
}

public function receipts() {
    $uuid = request()->segment(2);
    $type = request()->segment(3);
    
    $title = 'School Items Usage Voucher';
    $payment = \App\Models\Invoice::where('school_id', Auth::User()->school_id)->where('uuid', $uuid)->first();
   
    return Inertia::render('Store/Receipt', [
        'payment' => [
                'id' => $payment->id,
                'uuid' => $payment->uuid,
                'date' => date('F d, Y', strtotime($payment->date)),
                'add_date' => date('F d, Y', strtotime($payment->created_at)),
                'name' => $payment->vendor,
                'comment' => $payment->note,
                'reference' => $payment->reference,
                'contact' => $payment->contact,
                'user' =>  !empty($payment->user) ? $payment->user->name : 'Uploading',
                'userrole' =>  !empty($payment->user) ? $payment->user->usertype : '',
                'staff' =>  !empty($payment->staff) ? $payment->staff->name : '',
                'staffrole' =>  !empty($payment->staff) ? $payment->staff->usertype : '',
                'amount' => money($payment->amount),
                'words' => number_to_words($payment->amount),
                'total' =>  $payment->items()->sum('quantity'),
                'items' => count($payment->items) ? $payment->items()->get()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => !empty($item->item) ? $item->item->name : $item->name,
                        'code' => !empty($item->item) ? $item->item->code : $item->name,
                        'quantity' => $item->quantity,
                        'amount' => money($item->amount),
                    ];
                }) : null,
                'receipt_type' => $type,


            ],
            'title' => $title,
            'school' => DB::table('setting')->where('school_id', Auth::User()->school_id)->first(),

    ]);
}



}
