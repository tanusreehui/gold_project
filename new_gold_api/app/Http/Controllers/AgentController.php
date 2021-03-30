<?php

namespace App\Http\Controllers;

use App\Models\CustomerToAgents;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\UserType;

class AgentController extends Controller
{
    public function index()
    {
//        $agents = UserType::find(7)->people;
//        $agents = Person::select()->where('user_type_id',7)->get();
        $agents = Person::select('people.id',
            'user_name',
            'user_type_id',
            'email',
            'mobile1',
            'mobile2',
            'customer_category_id',
            'address1',
            'address2',
            'state',
            'city',
            'po',
            'area',
            'pin',
            'opening_balance_LC',
            'opening_balance_Gold',
            'mv',
            'discount')
            ->leftJoin('users', 'users.person_id', '=', 'people.id')
//            ->join('user_types', 'user_types.id', '=', 'users.user_type_id')
//            ->where('user_type_id', '!=', 10)
            ->where('user_type_id', '=', 7)
            ->get();

        return response()->json(['success'=>1,'data'=>$agents], 200,[],JSON_NUMERIC_CHECK);

    }

    public function saveAgent(Request $request){
//        $newData = (object)($request->json()->all());
        $agent = new Person();
        $agent->user_name = $request->input('user_name');
        $agent->billing_name = ' ';
//        $agent->email = $request->input('email');
//        $agent->password = "81dc9bdb52d04dc20036dbd8313ed055";
//        $agent->user_type_id = 7;
        $agent->user_type_id = $request->input('user_type_id');
        $agent->customer_category_id = 5;
        $agent->mobile1 = $request->input('mobile1');
        $agent->mobile2 = $request->input('mobile2');
        $agent->address1 = $request->input('address1');
        $agent->address2 = $request->input('address2');
//        $agent->state = $request->input('state');
        $agent->state ='West Bengal';
        $agent->po = $request->input('po');
        $agent->area = $request->input('area');
        $agent->city = $request->input('city');
        $agent->pin = $request->input('pin');
        $agent->opening_balance_LC = 0;
        $agent->mv = 0;
        $agent->discount = 0;
        $agent->opening_balance_Gold = 0;
        $agent->save();

        if($request->input('email') && $agent){
//            $user = new User();
//            $user->person_id = $customer->id;
//            $user->email = $request->input('email');
//            $user->password = $request->input('password') | md5('1234');
//            $user->save();
//            return response()->json(['success'=>1, 'data'=>$request->input('password')], 200,[],JSON_NUMERIC_CHECK);
            $user = User::create([
                'email'    => $request->input('email'),
                'password' => $request->input('password'),
                'person_id' => $agent->id,
            ]);
            $agent->email = $user->email;
            if(!$user){
                return response()->json(['success'=>0, 'data'=>$user, 'message'=> 'Failed to save data in user'], 200,[],JSON_NUMERIC_CHECK);
            }
//            $token = $user->createToken('my-app-token')->plainTextToken;
        }
        return response()->json(['success' => 1, 'data' => $agent], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateAgent($id,Request $request){
        $agent = Person::find($id);
        if ($request->input('user_name')) {
            $agent->user_name = $request->input('user_name');
        }
//        if ($request->input('email')) {
//            $agent->email = $request->input('email');
//        }
//        if ($request->input('password')) {
//            $agent->password = $request->input('password');
//        }

        if ($request->input('user_type_id')) {
            $agent->user_type_id = $request->input('user_type_id');
        }

        if ($request->input('customer_category_id')) {
            $agent->customer_category_id = $request->input('customer_category_id');
        }

        if ($request->input('mobile1')) {
            $agent->mobile1 = $request->input('mobile1');
        }

        if ($request->input('mobile2')) {
            $agent->mobile2 = $request->input('mobile2');
        }

        if ($request->input('address1')) {
            $agent->address1 = $request->input('address1');
        }

        if ($request->input('address2')) {
            $agent->address2 = $request->input('address2');
        }

        if ($request->input('state')) {
            $agent->state = $request->input('state');
        }

        if ($request->input('po')) {
            $agent->po = $request->input('po');
        }

        if ($request->input('area')) {
            $agent->area = $request->input('area');
        }

        if ($request->input('city')) {
            $agent->city = $request->input('city');
        }

        if ($request->input('pin')) {
            $agent->pin = $request->input('pin');
        }
        $agent->save();

        if($agent){
            $user = User::select()->where('person_id', $agent->id)->first();
            if($user && $request->input('email')){
                $user->email = $request->input('email');
            }
            if($user && $request->input('password')){
                $user->password = $request->input('password');
            }
            $user->update();
        }
        return response()->json(['success' => 1, 'data' => $agent], 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteAgent($id){
        $data = Person::find($id);
        $data->delete();
        return response()->json(['success' => 1, 'data' => $data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getDueByAgent(){

//        $data = CustomerToAgent::select('customer_to_agents.agent_id','users.user_name',DB::raw("sum(get_LC_due_by_customer_id(customer_to_agents.customer_id)) as LCdueByAgent, sum(get_gold_due_by_customer_id(customer_to_agents.customer_id))  as goldDueByAgent"))
//            -> leftJoin('bill_masters', function ($join) {
//                    $join->on('customer_to_agents.customer_id', '=', 'bill_masters.customer_id');
//                        $join->on('customer_to_agents.agent_id', '=', 'bill_masters.agent_id');
//                    })
//            ->join('users','users.id','=','customer_to_agents.agent_id')
//                ->GroupBy('customer_to_agents.agent_id')
//                ->get();

//        $data = CustomerToAgent::select(DB::raw('sum(get_LC_due_by_customer_id_and_by_agent_id_for_customer(customer_id, agent_id)) as LCdueByAgent'),DB::raw('sum(get_gold_due_by_customer_id_by_agent_id_for_customer(customer_id, agent_id)) as goldDueByAgent'),'users.user_name','customer_to_agents.agent_id')
//                    ->join('users','users.id','=','customer_to_agents.agent_id')
//                    ->groupBy('customer_to_agents.agent_id')
//                    ->get();


        $data = CustomerToAgents::select(DB::raw('sum(get_LC_due_by_customer_id(customer_id)) as LCdueByAgent'),DB::raw('sum(get_gold_due_by_customer_id(customer_id)) as goldDueByAgent'),'people.user_name','customer_to_agents.agent_id')
            ->join('people','people.id','=','customer_to_agents.agent_id')
            ->groupBy('customer_to_agents.agent_id')
            ->get();


//        $data = CustomerToAgent::select(DB::raw('sum(get_billed_LC_by_bill_master_id(customer_to_agents.id)) as LCdueByAgent'),DB::raw('sum(get_billed_gold_by_bill_master_id(customer_to_agents.id))'), 'agent_id', 'users.user_name')
//            ->join('users','customer_to_agents.id','=','users.id')
//            ->GroupBy('agent_id','user_name')
//            ->get();

        return response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);

    }

    public function getCustomerUnderAgent($id){
//        $data = CustomerToAgent::select('users.id','users.user_name')
//                ->join('users','customer_to_agents.customer_id','=','users.id')
//                ->where('customer_to_agents.agent_id',$id)
//                ->get();

//        $data = CustomerToAgent::select(DB::raw('get_LC_due_by_customer_id_and_by_agent_id_for_customer(customer_id, agent_id) as LC_Due'), DB::raw('get_gold_due_by_customer_id_by_agent_id_for_customer(customer_id, agent_id) as gold_due'),'users.user_name')
//                ->join('users','customer_to_agents.customer_id','=','users.id')
//                ->where('customer_to_agents.agent_id',$id)
//                ->get();

        $data = CustomerToAgents::select(DB::raw('get_LC_due_by_customer_id(customer_id) as LC_Due'), DB::raw('get_gold_due_by_customer_id(customer_id) as gold_due'),'people.user_name','people.id')
            ->join('people','customer_to_agents.customer_id','=','people.id')
            ->where('customer_to_agents.agent_id',$id)
            ->get();

        return response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);
    }
}
