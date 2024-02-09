<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email not found']);
        }
        if (! password_verify($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Wrong password']);
        }
        Auth::login($user);

        return redirect('/dashboard');
    }

    public function index(Request $request)
    {
        return view('UI.users', [
            'page_title' => 'Users',
        ]);
    }

    public function indexApi(Request $request)
    {
        $data = User::where('type', User::USER);

        if ($request->has('search')) {
            $search = '%'.$request->search.'%';
            $data = $data->where(function ($query) use ($search) {
                $query = $query->where('name', 'like', $search)
                    ->orWhere('phone_number', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        if ($request->has('sort_field')) {
            $sort_field = $request->sort_field;
            $sort_order = $request->input('sort_order', 'asc');
            if (! in_array($sort_field, Schema::getColumnListing((new User())->table))) {
                return response()->json([
                    'message' => __('messages.invalid_field_for_sorting'),
                    'status' => '0',
                ]);
            }
            $data = $data->orderBy($sort_field, $sort_order);
        }

        $data = $data->paginate($request->has('per_page') ? $request->per_page : 10);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
            'message' => __('post_messages.post_comment_list_returned'),
            'status' => '1',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
