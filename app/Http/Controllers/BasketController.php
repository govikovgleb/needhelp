<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{

    /**
     * Add product to basket
     * 
     */
   public function addToBasket(Request $request)
   {   
       $user_id  = Auth::id();
       $basket = Basket::FirstOrCreate(
           ['product_id' => $request->id, 'user_id' => $user_id]           
       );    
        return response()->json(json_encode($basket)); 
   }

   /**
     * Delete product from basket
     * 
     */
   public function deleteFromBasket(Request $request)
   {
        $basket = Basket::where('id', $request->id)->delete();
        return response()->json(json_encode($basket)); 
   }

   /**
     * Display basket
     * 
     */
   public function basket()
   {          
        $data = $this->getBasket(Auth::id());

        if (Auth::id() === 1) $data['user_list'] = User::orderBy('name','asc')->get();
         
        return view('basket', $data);
   }

   public function getBasket($user_id)
   {
        $user = User::find($user_id);
        $data['user'] = $user;
        $data['basket'] = [];
        $data['total_cost'] = 0;

        $baskets = $user->baskets()->orderBy('product_id','asc')->get();        

        foreach($baskets as $basket)
        {   
            $product = $basket->product()->first();
            $data['basket'][$basket->id] = $product;
            $data['total_cost'] += $product->cost;                          
        }

        if ($data['basket']) {
            if (count($data['basket']) == 2) {
                $data['total_cost'] = $data['total_cost'] * 0.9;
            } elseif (count($data['basket']) == 3) {
                $data['total_cost'] = $data['total_cost'] * 0.85;
            } elseif (in_array(date("l"), ["Saturday", "Sunday"])) {
                $data['total_cost'] = $data['total_cost'] * 0.8;
            }            
        }
        return $data;
   }
   
   public function getUserBasket(Request $request)
   {
        $data = $this->getBasket($request->id);
        $html['basket'] = '';
        if ($data['total_cost']) $html['total_cost'] = 'Total cost: '. $data['total_cost'];
        foreach($data['basket'] as $basket_id => $product) {
            $html['basket'] .= '<tr>
            <td>' . $product->title . '</td>
            <td>' . $product->cost . '</td>
            <td><div class="to-basket btn btn-outline-success" data-id="' . $basket_id . '">Delete</div></td>
        </tr>';
        }

        return $html;
   }

}
