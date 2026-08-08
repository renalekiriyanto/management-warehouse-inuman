
<div class="proj-table-wrapper" style="margin: 0; border-radius: 0 0 14px 14px; border: none; border-top: 2px solid var(--color-black); box-shadow: none;">
    <table class="proj-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Station</th>
                <th>Projection Inbound</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            {{-- ===================================================
                 REAL DATA — Gunakan ini jika data dari controller ada
                 (ganti $dummyProjections → $projections)
            =================================================== --}}
            @foreach($projections as $index => $item)
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>

                    <td class="date-val">
                        <i class="fas fa-calendar-day mr-1" style="color: var(--color-gray-600); font-size: 0.78rem;"></i>
                        {{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}
                    </td>

                    <td>
                        <span class="station-badge">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $item->station->name ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <span class="inbound-val">
                            {{ number_format($item['qty_projected'], 0, ',', '.') }}
                        </span>
                        <small class="meta-val ml-1">orders</small>
                    </td>


                    {{-- <td class="td-actions">
                        <div style="display: inline-flex; gap: 8px; align-items: center;">

                            <button
                                type="button"
                                class="btn-proj btn-proj-outline btn-proj-sm"
                                title="Edit Projection"
                                onclick="alert('Edit fungsi belum tersedia — hubungkan ke controller.')"
                            >
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </button>

                            <form
                                method="POST"
                                action="{{ route('inbound.projection.index') }}"
                                style="display: inline;"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn-proj btn-proj-danger btn-proj-sm btn-delete-projection"
                                    title="Hapus Projection"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- --- Pagination --- --}}
@if($projections instanceof \Illuminate\Pagination\LengthAwarePaginator && $projections->hasPages())
    <div class="proj-pagination" style="padding: 16px 24px;">
        {{ $projections->appends(request()->query())->links() }}
    </div>
@else
    {{-- Dummy pagination for preview --}}
    <div class="proj-pagination" style="padding: 16px 24px;">
        <nav>
            <ul class="pagination mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
        </nav>
    </div>
@endif
