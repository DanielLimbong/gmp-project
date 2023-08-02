@extends('template')

@section('header')
    <h1>Detail Issue {{ $issue->id }}</h1>
@endsection

@section('content')
<div class="mb-3 d-flex justify-content-end">
<form action="{{ route('issue.close', $issue) }}" method="POST">
@csrf
<button type="submit" class="btn btn-success btn-lg mr-2"  @if($issue->status === 'Close') disabled @endif>Close Issue</button>
</form>
    <a href="{{ route('issue.detail', $dailyInspectionSummary) }}" class="btn btn-danger btn-lg">Back</a>
</div>

<style>
    .no-scrollbar {
        overflow-x: hidden;
    }

    @media (max-width: 768px) {
        /* Atur overflow-x untuk tampilan layar lebar, misalnya <= 768px */
        .no-scrollbar {
            overflow-x: auto; /* atau overflow-x: scroll; */
        }
    }
</style>
<div class="row no-scrollbar">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
        <i class="fas fa-text"></i>
        Detail Issue </h3>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-4">Daily Inspection</dt>
          <dd class="col-sm-8"> : {{ $issue->daily_inspection_summary_id }}</dd>
          <dt class="col-sm-4">Submitter</dt>
          <dd class="col-sm-8"> : {{ $issue->users->name }}</dd>
          <dt class="col-sm-4">Question</dt>
          <dd class="col-sm-8"> : {{ $issue->questions->question }}</dd>
          <dt class="col-sm-4">Issue</dt>
          <dd class="col-sm-8"> : {{ $issue->issue }}</dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
        <i class="fas fa-text"></i>
        File </h3>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-4">
              <img src="/images/download.png" alt="Daily Inspection Image">
          </dt>
        </dl>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.6/dist/sweetalert2.all.min.js"></script>


<script>
    document.getElementById('toggleDataBtn').addEventListener('click', function() {
        if ("{{ $issue->status }}" !== 'Close') {
            Swal({
                title: "Are you sure?",
                text: "You are about to close this issue!",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            })
            .then((willClose) => {
                if (willClose) {
                    // Jika tombol "Close" diklik dan status belum "Close", maka lakukan aksi berikut
                    // Ganti $issue->status menjadi "Close"
                    // Ganti $issue->updater_id menjadi ID user yang sedang login
                    // Lakukan pengiriman data melalui AJAX atau form submission sesuai kebutuhan
                    swal("Success! The issue has been closed.", {
                        icon: "success",
                    })
                    .then(() => {
                        window.location.reload(); // Memuat ulang halaman setelah issue ditutup
                    });
                } else {
                    // Jika pengguna memilih untuk membatalkan
                    swal("The issue was not closed.", {
                        icon: "info",
                    });
                }
            });
        } else {
            // Jika status sudah "Close", maka tombol akan dinonaktifkan
            swal("The issue is already closed.", {
                icon: "warning",
            });
        }
    });
</script>

@endsection