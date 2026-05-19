@extends('layouts.client')

@section('title', 'Profile Settings')
@section('page_title', 'Profile Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- General Info -->
    <div class="client-card">
        <h2 class="text-xl font-bold text-white mb-6">Personal Information</h2>
        
        <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-[#0f1424] border border-blue-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition">
                    @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Email Address</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full bg-[#0f1424]/50 border border-blue-900/20 rounded-xl px-4 py-3 text-slate-500 cursor-not-allowed">
                    <p class="text-xs text-slate-500 mt-1">Contact support to change email.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Company (Optional)</label>
                    <input type="text" name="company" value="{{ old('company', $user->company) }}" class="w-full bg-[#0f1424] border border-blue-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-[#0f1424] border border-blue-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-primary px-8">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Security -->
    <div class="client-card">
        <h2 class="text-xl font-bold text-white mb-6">Security Settings</h2>
        
        <form action="{{ route('client.profile.password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 max-w-md">
                    <label class="block text-sm font-medium text-slate-400 mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full bg-[#0f1424] border border-blue-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition">
                    @error('current_password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">New Password</label>
                    <input type="password" name="password" class="w-full bg-[#0f1424] border border-blue-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition">
                    @error('password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-[#0f1424] border border-blue-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-primary px-8 bg-gradient-to-r from-red-600 to-red-500 shadow-[0_0_20px_rgba(220,38,38,0.3)] hover:shadow-[0_0_30px_rgba(220,38,38,0.5)]">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
