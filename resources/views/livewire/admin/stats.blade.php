<div>
    <div class="stat-grid">
        <div class="stat-card accent">
            <div class="stat-card-label">Total Voters</div>
            <div class="stat-card-value">{{ number_format($total) }}</div>
            <div class="stat-card-sub">Registered in database</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Branches</div>
            <div class="stat-card-value">{{ $branches }}</div>
            <div class="stat-card-sub">Distinct branches</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">With Mobile</div>
            <div class="stat-card-value">{{ number_format($withPhone) }}</div>
            <div class="stat-card-sub">{{ $total > 0 ? round($withPhone / $total * 100) : 0 }}% of total</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">No Mobile</div>
            <div class="stat-card-value">{{ number_format($noPhone) }}</div>
            <div class="stat-card-sub">Missing phone number</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Top 5 Branches by Voter Count</span>
            <a href="{{ route('admin.branches') }}" class="btn btn-ghost btn-sm">View All Branches →</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Branch</th>
                        <th>Voters</th>
                        <th>Share</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topBranches as $i => $b)
                        <tr>
                            <td style="color:var(--gray-300);font-weight:700">{{ $i + 1 }}</td>
                            <td class="td-name">{{ $b->branch }}</td>
                            <td>{{ number_format($b->total) }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.5rem">
                                    <div style="flex:1;height:6px;background:var(--gray-100);border-radius:3px;min-width:80px">
                                        <div style="height:100%;width:{{ $total > 0 ? round($b->total / $total * 100) : 0 }}%;background:var(--red-500);border-radius:3px"></div>
                                    </div>
                                    <span style="font-size:0.72rem;color:var(--gray-400);white-space:nowrap">{{ $total > 0 ? round($b->total / $total * 100) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
