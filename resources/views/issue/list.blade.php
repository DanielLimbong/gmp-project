@extends('template')

@section('header')
    <h1>List Issue {{ $area->area_name }}</h1>
@endsection

@section('content')
    <div class="mb-3 d-flex justify-content-end">
        <button class="btn btn-primary mr-2" id="toggleDataBtn">Show Close Data</button>
        <button class="btn btn-success" id="showAllDataBtn">Show All Data</button>
    </div>

    <div class="card p-2">
        <table class="table table-head-fixed text-nowrap" id="daily_Inspection_Summary_Table">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Submitter</th>
                    <th class="text-center">Question ID</th>
                    <th class="text-center">Daily Inspection ID</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Updated</th>
                    {{-- <th class="text-center">Updater</th> --}}
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issues->sortBy('questions.numbering') as $issue)
                    @php
                        if ($issue->updater_id !== null) {
                            $updater = \App\Models\User::find($issue->updater_id);
                        } else {
                            $updater = null;
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $issue->id }}</td>
                        <td class="text-center">{{ $issue->users->name }}</td>
                        <td class="text-center">{{ $issue->question_id }}</td>
                        <td class="text-center">
                            @php
                                $dailyInspectionSummary = \App\Models\DailyInspectionSummary::find($issue->daily_inspection_summary_id);
                            @endphp
                            <a href="{{ route('inspection.detail', $dailyInspectionSummary) }}">
                                {{ $issue->daily_inspection_summary_id }}
                            </a>
                        </td>
												<style>
														.badge-equal-size {
																font-size: 16px;
																width: 100px; /* Sesuaikan dengan ukuran yang Anda inginkan */
																height: 30px; /* Sesuaikan dengan ukuran yang Anda inginkan */
																line-height: 30px;
																display: flex; 
																text-align: center;/* Sesuaikan dengan ukuran yang Anda inginkan */
																align-items: center;
																justify-content: center;
														}
												</style>
													<td class="text-center">
															<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
																	<span class="badge badge-lg badge-pill badge-equal-size {{ $issue->status === 'Open' ? 'bg-warning' : ($issue->status === 'On Progress' ? 'bg-primary' : ($issue->status === 'Close' ? 'bg-success' : '')) }}">
																			{{ $issue->status }}
																	</span>
															</div>
													</td>

                        <td class="text-center">{{ $issue->created_at->formatLocalized('%d %B %Y') }}</td>
                        <td class="text-center">
                            {{ $issue->updated_at->formatLocalized('%d %B %Y') }} <br>
                            <div class="bg-lightblue color-palette d-inline-block rounded text-center pr-2 pl-2">
                                <span>{{ $updater ? $updater->name : '' }}</span>
                            </div>
                        </td>
                        {{-- <td>{{ $updater ? $updater->name : '' }}</td> --}}
                        <td class="text-center">
                            <a href="{{ route('issue.show', $issue) }}" class="btn btn-info view-area"> <i class="fas fa-eye"></i> Detail</a>
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
            if (buttonText === 'Show Close Data') {
                table.column(4).search('Close').draw();
                toggleDataBtn.textContent = 'Show Open Data';
            } else if (buttonText === 'Show Open Data') {
                table.column(4).search('Open').draw();
                toggleDataBtn.textContent = 'Show On Progress Data';
            } else {
                table.column(4).search('On Progress').draw();
                toggleDataBtn.textContent = 'Show Close Data';
            }
        });

        showAllDataBtn.addEventListener('click', function() {
            table.column(4).search('').draw();
        });
    });
</script>
@endsection
