@extends('layouts.admin')
@section('title', app()->getLocale() === 'ar' ? 'العملاء' : 'Clients')
@section('page-title', app()->getLocale() === 'ar' ? 'إدارة <span>العملاء</span>' : 'Client <span>Management</span>')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp

<div class="admin-card">
    <div class="section-heading">
        <div class="accent-line"></div>
        {{ $isAr ? 'قائمة العملاء' : 'All Clients' }}
        <span style="margin-{{ $isAr ? 'right' : 'left' }}:auto;font-size:12px;color:var(--text-muted);">{{ $clients->total() }} {{ $isAr ? 'عميل' : 'clients' }}</span>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>{{ $isAr ? 'العميل' : 'Client' }}</th>
                <th>{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</th>
                <th>{{ $isAr ? 'رقم الهاتف' : 'Phone' }}</th>
                <th>{{ $isAr ? 'المشاريع' : 'Projects' }}</th>
                <th>{{ $isAr ? 'تاريخ الانضمام' : 'Joined' }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($client->name,0,1)) }}
                        </div>
                        <div style="font-weight:600;color:#e2e8f0;">{{ $client->name }}</div>
                    </div>
                </td>
                <td style="color:var(--text-muted);">{{ $client->email }}</td>
                <td style="color:var(--text-muted);">{{ $client->phone ?? '—' }}</td>
                <td>
                    <span style="background:rgba(37,99,235,0.12);color:#60a5fa;padding:3px 10px;border-radius:100px;font-size:12px;font-weight:600;">
                        {{ $client->projects_count }} {{ $isAr ? 'مشاريع' : 'projects' }}
                    </span>
                </td>
                <td style="color:var(--text-muted);font-size:12.5px;">{{ $client->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.clients.show', $client) }}" class="btn-ghost" style="padding:5px 12px;font-size:12px;">
                        <i class="fas fa-eye"></i> {{ $isAr ? 'عرض' : 'View' }}
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px;">
                <i class="fas fa-users" style="font-size:28px;display:block;margin-bottom:10px;opacity:0.3;"></i>
                {{ $isAr ? 'لا يوجد عملاء بعد.' : 'No clients yet.' }}
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">{{ $clients->links() }}</div>
</div>
@endsection
