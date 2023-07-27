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
					<tr>
						<td>{{ $dailyInspectionSummary->id }}</td>
						<td>{{ $dailyInspectionSummary->users->name }}</td>
						<td>{{ $dailyInspectionSummary->created_at->formatLocalized('%d %B %Y') }}</td>
						<td>{{ $dailyInspectionSummary->updated_at->formatLocalized('%d %B %Y') }}</td>
						<td>{{ $dailyInspectionSummary->users->companies->name }}</td>
						<td>{{ $dailyInspectionSummary->status }}</td>
						<td>
							<a href="{{ route('inspection.detail', $dailyInspectionSummary) }}" class="btn btn-info view-area ml-4"> <i class="fas fa-eye"></i> Detail</a>
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
