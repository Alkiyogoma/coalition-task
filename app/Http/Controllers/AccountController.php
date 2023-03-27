<?phpnamespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index()
    {
        $id = request()->segment(2);
        if($id == 'employee' || $id == 'employer'){
            $type = 'employer';
            $client = \App\Models\Account::orderBy('id');
        }else{
            $type = 'branch';
            $client = \App\Models\Account::orderBy('id');
        }
        return Inertia::render('Invoice/Account', [
            'users' => $client->filter(Request::only('search'))->paginate(10)->withQueryString()
                ->through(fn ($User) => [
                    'id' => $User->id,
                    'name' => $User->name,
                    'code' => $User->code,
                    'type' => $User->account_type->name,
                    'groups' =>   !empty($User->account_groups) ? $User->account_groups->count() : '0',
                    'edit_url' => url('users.edit', $User),
                ]),
                'filters' => Request::all('search', 'trashed'),
                'type' => $type
        ]);
    }

    
    public function addGroup()
    {
        return Inertia::render('Invoice/CreateAccount',
        [
            'categories' => DB::table('account_types')->get()
        ]);
    }

    public function saveGroup()
    {
            Request::validate([
                'name' => ['required', 'max:110'],
                'code' => ['required', 'max:50'],
                'type_id' => ['required', 'max:150'],
            ]);
        \App\Models\Account::create(request()->all());

        return redirect('accounts')->with('success', 'User updated.');
    }


       
    public function addChart()
    {
        return Inertia::render('Invoice/CreateGroup',
        [
            'categories' => DB::table('accounts')->get()
        ]);
    }

    public function saveChart()
    {
            Request::validate([
                'name' => ['required', 'max:110'],
                'code' => ['required', 'max:50'],
                'account_id' => ['required', 'max:150'],
            ]);
        \App\Models\AccountGroup::create(array_merge(request()->all(), ['user_id' => Auth::User()->id]));

        return redirect('groups')->with('success', 'User updated.');
    }

    public function groups($id = null)
    {
        if($id > 0){
            $client = \App\Models\AccountGroup::where('account_group_id', $id);
        }else{
            $client = \App\Models\AccountGroup::whereNotNull('id');
        }
        return Inertia::render('Invoice/Group', [
            'users' => $client->filter(Request::only('search'))->paginate(10)->withQueryString()
            ->through(fn ($User) => [
                'id' => $User->id,
                'name' => $User->name,
                'code' => $User->code,
                'type' => $User->account->name,
                'groups' =>   !empty($User->account) ? $User->expenses->sum('amount') : '0',
                'edit_url' => url('users.edit', $User),
            ]),
            'filters' => Request::all('search', 'trashed'),
        ]);
    }

    public function revenues($id = null)
    {

        $from_date =  date("Y-01-01");
        $to_date = date("Y-12-30");

        if ($_POST) {
            $from_date = date('Y-m-d', strtotime(request('from_date')));
            $to_date = date('Y-m-d', strtotime(request('to_date')));
        }
        $array = [];

        if ((int) $id > 0) {
            $revenue = \App\Models\Revenue::where('account_group_id', $id)->whereBetween('date', [$from_date, $to_date])->orderBy('id', 'DESC');
        } else {
            $revenue = \App\Models\Revenue::whereBetween('date', [$from_date, $to_date])->orderBy('id', 'DESC');
        }
        $array['revenues'] =  $revenue->filter(Request::only('search'))->paginate(10)->withQueryString()
        ->through(fn ($payment) => [
                    'id' => $payment->id,
                    'uuid' => $payment->uuid,
                    'date' => date('M d, Y', strtotime($payment->date)),
                    'created_at' => timeAgo($payment->created_at),
                    'reference' => $payment->reference,
                    'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                    'account' => !empty($payment->account_group) ? $payment->account_group->name : 'Revenue',
                    'payer' => $payment->name,
                    'phone' => $payment->phone,
                    'note' => $payment->note,
                    'name' => $payment->user->name,
                    'added' => $payment->addedBy->name,
                    'userrole' => $payment->user->role->name,
                    'amount' => money($payment->amount),
        ]);
        $array['filters'] = Request::all('search', 'trashed');
        $array['from_date'] = date('m/d/Y', strtotime($from_date));
        $array['to_date'] = date('m/d/Y', strtotime($to_date));
        return Inertia::render('Invoice/Revenue', $array);
    }

    

    public function revenueAdd()
    {
        if ($_POST) {
          
            $account_group_id = request('account_group_id');
            $transaction_id = request('reference');
           
                $transaction_id = DB::table('revenues')->where('reference', $transaction_id)->first();
                if (!empty($transaction) && $transaction->method_id != 1) {
                    return redirect(url("revenueadd"))->with('error', 'The Reference number already exist');
                }

                $payer_name = request('payer_name');
                $payer_phone = request('payer_phone');
                // user_id	account_group_id	amount	date	method_id	
                // note	reference	phone	name	type	status	added_by
                // 	created_at	updated_at	uuid
                $obj = [
                    'name' => $payer_name,
                    'reference' => $transaction_id != '' ? $transaction_id : date("YmdHis") . $account_group_id,
                    'amount' => request('amount'),
                    'method_id' => request('method_id'),
                    'user_id' => request('user_id'),
                    'note' => request('note'),
                    'date' => date("Y-m-d", strtotime(request('date'))),
                    'added_by' => Auth::User()->id,
                    'phone' => $payer_phone,
                    'uuid' => (string) Str::uuid(),
                    'account_group_id' => $account_group_id,
                ];
                $revenue = \App\Models\Revenue::create($obj);
         
            return  redirect(url("receipt/" . $revenue->uuid."/view"))->with('success', 'Action Excuted Successfuly');
        } else {
            $array["methods"] = \App\Models\PaymentMethod::get();
            $array["users"] = \App\Models\User::get();
            $array["categories"] = $this->getCategories(3);
            $array['_token'] = csrf_token();

         return   Inertia::render('Invoice/RevenueAdd', $array);
        }
    }


    public function revenueEdit($id)
    {

          
            if ($id != '') {
                $array['expense'] = \App\Models\Revenue::where('uuid', $id)->first();
    
                if ($array['expense']) {
                    $payment= \App\Models\Revenue::where('uuid', $id)->first();
                    $array['payment'] = [
                            'id' => $payment->id,
                            'uuid' => $payment->uuid,
                            'date' => date('Y-m-d', strtotime($payment->date)),
                            'created_at' => timeAgo($payment->created_at),
                            'reference' => $payment->reference,
                            'method_id' => $payment->method_id,
                            'account_group_id' => $payment->account_group_id,
                            'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                            'account' => !empty($payment->account_group) ? $payment->account_group->name : 'Revenue',
                            'payer' => $payment->name,
                            'phone' => $payment->phone,
                            'note' => $payment->note,
                            'user_id' => $payment->user_id,
                            'added' => $payment->addedBy->name,
                            'userrole' => $payment->user->role->name,
                            'amount' => $payment->amount,
                            'words' => number_to_words($payment->amount),
                        ];
                        $array["methods"] = \App\Models\PaymentMethod::get();
                        $array["users"] = \App\Models\User::get();
                        $array["categories"] = $this->getCategories(3);
                        $array['_token'] = csrf_token();
            
                    if ($_POST) {
                        $account_group_id = $array['expense']->account_group_id;
                        $amount = request("amount");
                            $array = array(
                                "date" => date("Y-m-d", strtotime(request("date"))),
                                "amount" => $amount,
                                "reference" => request("reference"),
                                "account_group_id" => request("account_group_id"),
                                "note" => request("note"),
                                "method_id" => request("method_id"),
                            );
                        \App\Models\Revenue::where('uuid', $id)->first();
    
                        \App\Models\Revenue::where('uuid', $id)->update($array);
                        return redirect(url("revenues/$account_group_id"))->with('success', 'Action Excuted Successfuly');
                    }
                   
                        return  Inertia::render("Invoice/RevenueEdit", $array);
                    } else {
                    return redirect()->back()->with('error', 'Something not well defined, Try Again');
                }  
            }else {
                return redirect()->back()->with('error', 'Something not well defined, Try Again');
            }
    }

    public function revenueDelete()
    {
        $id = request()->segment(2);
        if ($id != '') {
            $revenue = \App\Models\Revenue::where('uuid', $id)->first();
            $revenue->delete();
            return redirect()->back()->with('success', 'Action Excuted Successfuly');
        } else {
            return redirect(url("revenues"))->with('error', ('menu_error'));
        }
    }

    public function receipt()
    {
        $id = request()->segment(2);
        if ($id != '') {
            $payment= \App\Models\Revenue::where('uuid', $id)->first();
            $array['school'] = \App\Models\Setting::first();
            $array['payment'] = [
                    'id' => $payment->id,
                    'uuid' => $payment->uuid,
                    'date' => date('M d, Y', strtotime($payment->date)),
                    'created_at' => timeAgo($payment->created_at),
                    'reference' => $payment->reference,
                    'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                    'account' => !empty($payment->account_group) ? $payment->account_group->name : 'Revenue',
                    'payer' => $payment->name,
                    'phone' => $payment->phone,
                    'note' => $payment->note,
                    'name' => $payment->user->name,
                    'added' => $payment->addedBy->name,
                    'userrole' => $payment->user->role->name,
                    'amount' => money($payment->amount),
                    'words' => number_to_words($payment->amount),
                ];
            $array['title'] = 'STEAM Generation Receipt';
            return Inertia::render('Invoice/Receipt', $array);
        }
    }


    public function expenses($id = null)
    {
        $from_date =  date("Y-01-01");
        $to_date = date("Y-12-30");
        if ($_POST) {
            $from_date = date('Y-m-d', strtotime(request('from_date')));
            $to_date = date('Y-m-d', strtotime(request('to_date')));
        }
        $array = [];

        if ((int) $id > 0) {
            $expense = \App\Models\Expense::where('account_group_id', $id)->whereBetween('date', [$from_date, $to_date])->orderBy('id', 'DESC');
        } else {
            $expense = \App\Models\Expense::whereBetween('date', [$from_date, $to_date])->orderBy('id', 'DESC');
        }
        $array['expenses'] =  $expense->filter(Request::only('search'))->paginate(10)->withQueryString()
        ->through(fn ($payment) => [
                    'id' => $payment->id,
                    'uuid' => $payment->uuid,
                    'date' => date('M d, Y', strtotime($payment->date)),
                    'created_at' => timeAgo($payment->created_at),
                    'reference' => $payment->reference,
                    'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                    'account' => !empty($payment->account_group) ? $payment->account_group->name : 'Revenue',
                    'payer' => $payment->name,
                    'phone' => $payment->phone,
                    'note' => $payment->note,
                    'name' => $payment->user->name,
                    'added' => $payment->addedBy->name,
                    'userrole' => $payment->user->role->name,
                    'amount' => money($payment->amount),
        ]);
        $array['filters'] = Request::all('search', 'trashed');
        $array['from_date'] = date('m/d/Y', strtotime($from_date));
        $array['to_date'] = date('m/d/Y', strtotime($to_date));
        return Inertia::render('Invoice/Expense', $array);
    }

    protected function rules()
    {
        return $this->validate(request(), [
            'date' => 'required|max:20|date',
            'expense' => 'required|numeric|min:1',
            'amount' => 'required|numeric',
            'method_id' => 'required|min:1',
            'note' => 'required:max:600',
        ]);
    }

    protected function rules_asset()
    {
        return $this->validate(request(), [
            'date' => 'required|max:20|date',
            'account_group_id' => 'required|numeric|min:1',
            'payer_name' => 'required',
            'note' => 'required:max:600',
        ]);
    }

    public function expenseAdd()
    {
        if ($_POST) {
          
            $account_group_id = request('account_group_id');
            $transaction_id = request('reference');
           
                $transaction_id = DB::table('expenses')->where('reference', $transaction_id)->first();
                if (!empty($transaction) && $transaction->method_id != 1) {
                    return redirect(url("expenseadd"))->with('error', 'The Reference number already exist');
                }

                $payer_name = request('payer_name');
                $payer_phone = request('payer_phone');
                $obj = [
                    'name' => $payer_name,
                    'reference' => $transaction_id != '' ? $transaction_id : date("YmdHis") . $account_group_id,
                    'amount' => request('amount'),
                    'method_id' => request('method_id'),
                    'user_id' => request('user_id'),
                    'note' => request('note'),
                    'date' => date("Y-m-d", strtotime(request('date'))),
                    'added_by' => Auth::User()->id,
                    'phone' => $payer_phone,
                    'uuid' => (string) Str::uuid(),
                    'account_group_id' => $account_group_id,
                ];
                $revenue = \App\Models\Expense::create($obj);
         
            return  redirect(url("voucher/" . $revenue->uuid."/view"))->with('success', 'Action Excuted Successfuly');
        } else {
            $array["methods"] = \App\Models\PaymentMethod::get();
            $array["users"] = \App\Models\User::get();
            $array["categories"] = $this->getCategories(2);
            $array['_token'] = csrf_token();

            return  Inertia::render('Invoice/ExpenseAdd', $array);
        }
    }



    public function expenseEdit($id)
    {


        $array['banks'] = \App\Models\BankAccount::get();
        $array["payment_types"] = \App\Models\PaymentMethod::get();
  
        if ($id != '') {
            $array['expense'] = \App\Models\Expense::where('uuid', $id)->first();

            if ($array['expense']) {
                $payment= \App\Models\Expense::where('uuid', $id)->first();
                $array['payment'] = [
                        'id' => $payment->id,
                        'uuid' => $payment->uuid,
                        'date' => date('Y-m-d', strtotime($payment->date)),
                        'created_at' => timeAgo($payment->created_at),
                        'reference' => $payment->reference,
                        'method_id' => $payment->method_id,
                        'account_group_id' => $payment->account_group_id,
                        'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                        'account' => !empty($payment->account_group) ? $payment->account_group->name : 'Revenue',
                        'payer' => $payment->name,
                        'phone' => $payment->phone,
                        'note' => $payment->note,
                        'user_id' => $payment->user_id,
                        'added' => $payment->addedBy->name,
                        'userrole' => $payment->user->role->name,
                        'amount' => $payment->amount,
                        'words' => number_to_words($payment->amount),
                    ];
                    $array["methods"] = \App\Models\PaymentMethod::get();
                    $array["users"] = \App\Models\User::get();
                    $array["categories"] = $this->getCategories(2);
                    $array['_token'] = csrf_token();
        
                if ($_POST) {
                    $account_group_id = $array['expense']->account_group_id;
                    $amount = request("amount");
                        $array = array(
                            "date" => date("Y-m-d", strtotime(request("date"))),
                            "amount" => $amount,
                            "reference" => request("reference"),
                            "account_group_id" => request("account_group_id"),
                            "note" => request("note"),
                            "method_id" => request("method_id"),
                        );
                    \App\Models\Expense::where('uuid', $id)->first();

                    \App\Models\Expense::where('uuid', $id)->update($array);
                    return redirect(url("expenses/$account_group_id"))->with('success', 'Action Excuted Successfuly');
                }
               
                    return  Inertia::render("Invoice/ExpenseEdit", $array);
                } else {
                return redirect()->back()->with('error', 'Something not well defined, Try Again');
            }  
        }else {
            return redirect()->back()->with('error', 'Something not well defined, Try Again');
        }
    }

        
    public function expenseDelete($id)
    {
        if ($id != '') {
            $revenue = \App\Models\Expense::where('uuid', $id)->first();
            $revenue->delete();
            return redirect()->back()->with('success', 'Action Excuted Successfuly');
        } else {
            return redirect(url("expenses"))->with('error', ('menu_error'));
        }
    }

    public function voucher($id)
    {
        if ($id != '') {
            $payment= \App\Models\Expense::where('uuid', $id)->first();
            $array['school'] = \App\Models\Setting::first();
            $array['payment'] = [
                    'id' => $payment->id,
                    'uuid' => $payment->uuid,
                    'date' => date('M d, Y', strtotime($payment->date)),
                    'created_at' => timeAgo($payment->created_at),
                    'reference' => $payment->reference,
                    'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                    'account' => !empty($payment->account_group) ? $payment->account_group->name : 'Revenue',
                    'payer' => $payment->name,
                    'phone' => $payment->phone,
                    'note' => $payment->note,
                    'name' => $payment->user->name,
                    'added' => $payment->addedBy->name,
                    'userrole' => $payment->user->role->name,
                    'amount' => money($payment->amount),
                    'words' => number_to_words($payment->amount),
                ];
            $array['title'] = 'STEAM Generation Recoveries LTD Payment Voucher';
            return Inertia::render('Invoice/ExpenseVoucher', $array);
        }
    }

    public function getCategories($id)
    {
        switch ($id) {
            case 1:
                $result = \App\Models\AccountGroup::whereIn('account_id', \App\Models\Account::where('type_id', 1)->get(['id']))->get();
                break;
            case 2:
                $result = \App\Models\AccountGroup::whereIn('account_id', \App\Models\Account::where('type_id', 2)->get(['id']))->get();
                break;
            case 3:
                $result = \App\Models\AccountGroup::whereIn('account_id', \App\Models\Account::where('type_id', 3)->get(['id']))->get();
                break;
            default:
                $result = \App\Models\AccountGroup::get();
                break;
        }
        return $result;
    }

}
