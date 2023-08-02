@extends('template')

@section('header')
    <h1>List Issue {{ $dailyInspectionSummary->id }}</h1>
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
					<th>Submitter</th>
					<th>Question ID</th>
					<th>Daily Inspection ID</th>
					<th>Status</th>
					<th>Created</th>
					<th>Updated</th>
					<th>Updater</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($issues->sortBy('questions.numbering') as $issue)
@php
    if ($issue->updater_id !== null) {
        $updater = \App\Models\User::where('id', $issue->updater_id)->first();
    } else {
        $updater = null;
    }
@endphp
					<tr>
						<td>{{ $issue->id }}</td>
						<td>{{ $issue->users->name }}</td>
						<td>{{ $issue->question_id }}</td>
						<td>{{ $issue->daily_inspection_summary_id }}</td>
						<td>{{ $issue->status }}</td>
						<td>{{ $issue->created_at->formatLocalized('%d %B %Y') }}</td>
						<td>{{ $issue->updated_at->formatLocalized('%d %B %Y') }}</td>
						<td>{{ $updater ? $updater->name : '' }}</td>

						<td>
							<a href="{{ route('issue.show', $issue) }}" class="btn btn-info view-area ml-4"> <i class="fas fa-eye"></i> Detail</a>
						</td>
					</tr>
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
                table.column(5).search('NA').draw(); // Search pada kolom indeks 3 (status) dengan kata kunci 'NA'
                toggleDataBtn.textContent = 'Show Approved Data';
            } else {
                table.column(5).search('Approved').draw(); // Search pada kolom indeks 3 (status) dengan kata kunci 'Approved'
                toggleDataBtn.textContent = 'Show NA Data';
            }
        });

        showAllDataBtn.addEventListener('click', function() {
            // table.search('').draw();
						table.column(5).search('').draw(); // Mencari di seluruh kolom (menghapus filter pencarian)
        });
    });
</script>


@endsection
