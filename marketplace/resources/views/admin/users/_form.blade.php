<label class="text-sm font-semibold text-gray-700">
    Ad Soyad
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    E-posta
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Rol
    <select name="role" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
        @foreach($roles as $role)
            <option value="{{ $role }}" @selected(old('role', $user->role ?? 'customer') === $role)>{{ ucfirst($role) }}</option>
        @endforeach
    </select>
</label>
<label class="text-sm font-semibold text-gray-700">
    Şifre @if(isset($user)) <span class="text-xs text-gray-500">(opsiyonel)</span> @endif
    <input type="password" name="password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Şifre Tekrar
    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
