@extends('template')
@section('content')
      <div class="container-fluid">
        {{-- <div class="row justify-content-center">
          <div class="col-md-2">
            <a href="#" class="btn btn-block btn-info btn-lg">Front Loading OB</a>
          </div>
          <div class="col-md-2">
            <a href="#" class="btn btn-block btn-info btn-lg">Front Loading Coal</a>
          </div>
          <div class="col-md-2">
            <a href="#" class="btn btn-block btn-info btn-lg">Dewatering</a>
          </div>
          <div class="col-md-2">
            <a href="#" class="btn btn-block btn-info btn-lg">Disposal</a>
          </div>
          <div class="col-md-2">
            <a href="#" class="btn btn-block btn-info btn-lg">Haul Road</a>
          </div>
        </div> --}}

<br>
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Daily Inspection</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <div class="chart">
      <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
  </div>
  <!-- /.card-body -->
</div>

            <!-- /.card -->

            <!-- DONUT CHART -->
 
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Issue</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus">
                    </i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">User</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


            <!-- /.card -->

          </div> 
          <!-- /.col (RIGHT) -->
        </div>


        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabel</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
        <table class="table table-head-fixed text-nowrap" id="daily_Inspection_Summary_Table">
            <thead>
                <tr>
                    {{-- <th class="text-center">ID</th> --}}
                    <th class="text-center">Status</th>
                    <th class="text-center">Submitter</th>
                    <th class="text-center">Question ID</th>
                    <th class="text-center">Daily Inspection ID</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Updated</th>
                    {{-- <th class="text-center">Updater</th> --}}
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
              @php
            // $areas = \App\Models\Area::all();
            // foreach($areas as $area)
            $issues = \App\Models\Issue::
            // where('area_id', $area->id)
            where('status', "Close")
            ->get();
            // dd($issues)

            // $dailyInspectionSummaries = $issues->map(function ($issue) {
            // return DailyInspectionSummary::find($issue->daily_inspection_summary_id);
            // })->filter();
              @endphp
                @foreach ($issues->sortBy('questions.numbering') as $issue)
                @php
                        if ($issue->updater_id !== null) {
                            $updater = \App\Models\User::find($issue->updater_id);
                        } else {
                            $updater = null;
                        }
                        @endphp
                         @if (auth()->user()->role == 'Administrator' || (auth()->user()->role == 'Operational Team' && auth()->user()->company_code == $issue->users->company_code))
                    <tr>
                        <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                        <span class="badge badge-lg badge-pill badge-equal-size {{ $issue->status === 'Open' ? 'bg-warning' : ($issue->status === 'On Progress' ? 'bg-primary' : ($issue->status === 'Close' ? 'bg-success' : '')) }}">
                                                {{ $issue->status }}
                                        </span>
                                </div>
                        </td>
                        {{-- <td class="text-center">{{ $issue->id }}</td> --}}
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
                    @endif
                @endforeach
            </tbody>
        </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
  // Mengambil data dari server (Anda perlu mengganti URL dengan URL yang benar)
  fetch('/get-area-chart-data')
    .then(response => response.json())
    .then(data => {
      // Mengambil areaChart canvas
      var ctx = document.getElementById('areaChart').getContext('2d');

      // Menggambar grafik area dengan data yang diterima dari server
      new Chart(ctx, {
        type: 'bar', // Ganti dengan 'bar' jika ingin grafik batang
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Jumlah Daily Inspection Summary',
            data: data.dataset,
            borderColor: 'rgba(0, 123, 255, 0.9)',
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            fill: true,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        }
      });
    });
  fetch('/get-issue-chart-data')
    .then(response => response.json())
    .then(data => {
      // Mengambil areaChart canvas
      var ctx = document.getElementById('lineChart').getContext('2d');

      // Menggambar grafik area dengan data yang diterima dari server
      new Chart(ctx, {
        type: 'bar', // Ganti dengan 'bar' jika ingin grafik batang
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Jumlah Issue',
            data: data.dataset,
            borderColor: 'rgba(0, 123, 255, 0.9)',
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            fill: true,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        }
      });
    });
fetch('/get-user-chart-data')
    .then(response => response.json())
    .then(data => {
      // Mengambil pieChart canvas
      var ctx = document.getElementById('pieChart').getContext('2d');

      // Menggambar grafik pie dengan data yang diterima dari server
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Jumlah User',
            data: data.dataset,
            backgroundColor: [
              'rgba(255, 99, 132, 0.5)',
              'rgba(54, 162, 235, 0.5)',
              'rgba(255, 206, 86, 0.5)',
              'rgba(75, 192, 192, 0.5)',
              'rgba(153, 102, 255, 0.5)',
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        }
      });
    });
</script>

@endsection