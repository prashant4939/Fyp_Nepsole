<div class="table-container">
    @if($rows->count())
        <table class="table">
            <thead><tr>
                <th>Name</th><th>Email</th><th>Phone</th>
                <th>Shop Name</th><th>Submitted</th><th>Status</th><th>Actions</th>
            </tr></thead>
            <tbody>
            @foreach($rows as $req)
            <tr>
                <td>{{ $req->name }}</td>
                <td>{{ $req->email }}</td>
                <td>{{ $req->phone }}</td>
                <td>{{ $req->shop_name }}</td>
                <td>{{ $req->created_at->format('M d, Y') }}</td>
                <td><span class="badge badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span></td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.vendor-requests.show', $req) }}" class="btn btn-view">View</a>
                        @if($req->status === 'pending')
                            <form method="POST" action="{{ route('admin.vendor-requests.approve', $req) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-approve"
                                    onclick="return confirm('Approve this vendor and send login credentials?')">Approve</button>
                            </form>
                            <button class="btn btn-reject"
                                onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->name) }}')">Reject</button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <h3>No records found</h3>
            <p>No vendor requests in this category.</p>
        </div>
    @endif
</div>
