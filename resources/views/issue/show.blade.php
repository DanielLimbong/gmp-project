@extends('template')

@section('header')
    <h1>Detail Issue {{ $issue->id }}</h1>
@endsection

@section('content')
<div class="mb-3 d-flex justify-content-end">
<form action="{{ route('issue.onprogress', $issue) }}" method="POST">
@csrf
<button type="button" class="btn btn-primary btn-lg mr-2"  @if($issue->status === 'On Progress' || $issue->status === 'Close') disabled @endif data-toggle='modal' data-target="#onProgressIssueModal">On Progress Issue</button>
</form>
<form action="{{ route('issue.close', $issue) }}" method="POST">
    @csrf
    <!-- Tombol untuk memunculkan modal -->
    <button type="button" class="btn btn-success btn-lg mr-2" @if($issue->status === 'Close') disabled @endif data-toggle="modal" data-target="#closeIssueModal">
        Close Issue
    </button>
</form>

@php
    $area = \App\Models\Area::where('id', $issue->area_id)->first();  
@endphp
    <a href="{{ route('issue.list', $area) }}" class="btn btn-danger btn-lg">Back</a>
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
          <dt class="col-sm-4">Status</dt>
          <dd class="col-sm-8"> : {{ $issue->status }}</dd>
          @if($issue->status !== "Open")
          <dt class="col-sm-4">Reason for {{ $issue->status }}</dt>
          <dd class="col-sm-8"> : {{$issue->closed_reason  }}</dd>
          @endif
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
@if($issue->status === 'Close')
<div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text"></i>
                    Image for Close Issue
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">
                        <img src="{{ asset($issue->image_closed) }}" alt="Close Issue Image">
                    </dt>
                </dl>
            </div>
        </div>
    </div>
</div>



@endif
<!-- Modal untuk mengisi reasong close -->
<div class="modal fade" id="closeIssueModal" tabindex="-1" role="dialog" aria-labelledby="closeIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeIssueModalLabel">Close Issue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk mengisi reason close -->
                <form action="{{ route('issue.close', $issue) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <textarea class="form-control" id="closed_reason" name="closed_reason" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo">Upload Photo:</label>
                        <input type="file" class="form-control-file" id="photo" name="closed_photo">
                    </div>
                    <button type="submit" class="btn btn-success">Close Issue</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="onProgressIssueModal" tabindex="-1" role="dialog" aria-labelledby="onProgressIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeIssueModalLabel">On Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk mengisi reason close -->
                <form action="{{ route('issue.onprogress', $issue) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <textarea class="form-control" id="closed_reason" name="onprogress_reason" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">On Progress Issue</button>
                </form>
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
    document.getElementById('toggleDataBtn2').addEventListener('click', function() {
        if ("{{ $issue->status }}" !== 'On Progress') {
            Swal({
                title: "Are you sure?",
                text: "You are about to change the issue status to On Progress?",
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
                    swal("Success! The issue's status has been changed to On Progress'.", {
                        icon: "success",
                    })
                    .then(() => {
                        window.location.reload(); // Memuat ulang halaman setelah issue ditutup
                    });
                } else {
                    // Jika pengguna memilih untuk membatalkan
                    swal("The issue's status not changed.", {
                        icon: "info",
                    });
                }
            });
        } else {
            // Jika status sudah "Close", maka tombol akan dinonaktifkan
            swal("The issue is already On Progress.", {
                icon: "warning",
            });
        }
    });
</script>

@endsection
