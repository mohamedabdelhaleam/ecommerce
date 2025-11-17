<div class="userDatatable global-shadow border-light-0 w-100">
    <div class="table-responsive">
        <table class="table mb-0 table-borderless">
            <thead>
                <tr class="userDatatable-header">
                    <th>{{ __('dashboard.name') }}</th>
                    <th>{{ __('dashboard.email') }}</th>
                    <th>{{ __('dashboard.phone') }}</th>
                    <th>{{ __('dashboard.orders_count') }}</th>
                    <th>{{ __('dashboard.email_verified') }}</th>
                    <th>{{ __('dashboard.date') }}</th>
                    <th>{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="userDatatable-content">
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ $user->email }}
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ $user->phone ?? __('dashboard.na') }}
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                <span class="badge bg-primary">{{ $user->orders_count }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                @if ($user->email_verified_at)
                                    <span class="badge bg-success">{{ __('dashboard.verified') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ __('dashboard.not_verified') }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ $user->created_at->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $user->created_at->format('h:i A') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-flex align-items-center">
                                <a href="{{ route('dashboard.users.show', $user) }}" class="btn btn-sm">
                                    <i class="uil uil-eye"></i> {{ __('dashboard.view') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">{{ __('dashboard.no_users_found') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
