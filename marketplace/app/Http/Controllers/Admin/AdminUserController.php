<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    protected array $roles = ['customer', 'vendor', 'admin'];

    public function index()
    {
        $users = User::latest()->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', ['roles' => $this->roles]);
    }

    public function store(Request $request)
    {
        $data = $this->validateUser($request);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validateUser($request, $user->id);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted.');
    }

    protected function validateUser(Request $request, ?int $userId = null): array
    {
        $emailRule = Rule::unique('users', 'email');
        if ($userId) {
            $emailRule->ignore($userId);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', $emailRule],
            'role' => ['required', Rule::in($this->roles)],
            'password' => [$userId ? 'nullable' : 'required', 'confirmed', 'min:6'],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}