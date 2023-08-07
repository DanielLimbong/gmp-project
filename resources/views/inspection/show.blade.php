@extends('template')

@section('header')
    <h1>List Inspection : {{ $area->area_name }}</h1>
@endsection

@section('content')
    <div class="mb-3 d-flex justify-content-end">
        <button class="btn btn-primary mr-2" id="toggleDataBtn">Show NA Data</button>
        <button class="btn btn-success" id="showAllDataBtn">Show All Data</button>
    </div>

    <div class="card p-2">
        <table class="table table-head-fixed text-nowrap" id="daily_Inspection_Summary_Table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailyInspectionSummaries->sortBy('questions.numbering') as $dailyInspectionSummary)
                    @php
                        // Check if the current user is a "Reviewer as Contractor" and the company matches
                        $user = auth()->user();
                        $isReviewerAsContractor = $user->role === 'Reviewer as Contractor';
                        $companyMatches = $isReviewerAsContractor && $dailyInspectionSummary->users->companies->name === $user->companies->name;
                    @endphp

                    {{-- Show the row only if the user is not a "Reviewer as Contractor" or if the company matches --}}
                    @if (!$isReviewerAsContractor || $companyMatches)
                        <tr>
                            <td>{{ $dailyInspectionSummary->id }}</td>
                            <td>{{ $dailyInspectionSummary->users->name }}</td>
                            <td>{{ $dailyInspectionSummary->created_at->formatLocalized('%d %B %Y') }}</td>
                            <td>{{ $dailyInspectionSummary->updated_at->formatLocalized('%d %B %Y') }}</td>
                            <td>{{ $dailyInspectionSummary->users->companies->name }}</td>
                            <td>{{ $dailyInspectionSummary->status }}</td>
                            <td>
                                <a href="{{ route('inspection.detail', $dailyInspectionSummary) }}" class="btn btn-info view-area ml-4">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        let table = $('#daily_Inspection_Summary_Table').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });

        let showAllDataBtn = document.getElementById('showAllDataBtn');
        let toggleDataBtn = document.getElementById('toggleDataBtn');

        toggleDataBtn.addEventListener('click', function() {
            let buttonText = toggleDataBtn.textContent;
            if (buttonText === 'Show NA Data') {
                table.column(5).search('NA').draw();
                toggleDataBtn.textContent = 'Show Approved Data';
            } else {
                table.column(5).search('Approved').draw();
                toggleDataBtn.textContent = 'Show NA Data';
            }
        });

        showAllDataBtn.addEventListener('click', function() {
            table.column(5).search('').draw();
        });
    });
</script>
@endsection
