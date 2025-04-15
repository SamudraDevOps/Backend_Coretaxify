<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Sistem;
use App\Models\Pic;
use Symfony\Component\HttpFoundation\Response;

class CheckRepresentation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sistemId = $request->route('sistem');
        $sistem = Sistem::findOrFail($sistemId);

        // Company accounts can proceed directly
        if ($sistem->tipe_akun === 'Badan' || $sistem->tipe_akun === 'Badan Lawan Transaksi') {
            return $next($request);
        }

        // Personal accounts must represent a company account
        $companyId = $request->input('company_id');

        if (!$companyId) {
            return response()->json([
                'message' => 'You must represent a company to perform this action.'
            ], 400);
        }

        // Check if this personal account represents the company
        $representation = Pic::where('akun_op_id', $sistem->id)
            ->where('akun_badan_id', $companyId)
            ->where('assignment_user_id', $sistem->assignment_user_id)
            ->exists();

        if (!$representation) {
            return response()->json([
                'message' => 'You do not have permission to represent this company.'
            ], 403);
        }

        // Store the represented company ID for controller to use
        $request->attributes->add(['represented_company_id' => $companyId]);

        return $next($request);
    }
}
