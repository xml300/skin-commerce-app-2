<?php

namespace App\Http\Middleware;

use App\Models\CartItem;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $queuedChanges = $request->query("update-cart");
        if ($queuedChanges != null) {
            $array = json_decode($queuedChanges);
           
            $removeIDs = [];
            foreach ($array->remove as $remove) {
                $removeIDs[] = $remove->productId;
            }

            if (count($removeIDs) > 0) {
                CartItem::where('user_id', '=', Auth::id())
                    ->whereIn('product_id', $removeIDs)
                    ->delete();
            }

            foreach ($array->update as $update) {
                CartItem::where('user_id', '=', Auth::id())
                    ->where(
                        'product_id',
                        '=',
                        $update->productId
                    )->increment('quantity', $update->quantity);
            }
        }


        return $next($request);
    }
}
