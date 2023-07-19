@extends('template')
@section('header')
    <h1>Preview Question</h1>
@endsection

@section('content')
  <style>
    .duplicate-question {
      border: 2px solid red;
      border-radius: 0;
    }
  </style>

  <div class="form-group">
    <form action="{{ route('question.numberingUpdate', $area) }}" method="POST">
      @csrf
      @foreach ($questions as $index => $question)
        <label for="question{{ $index }}">Question number {{ $index + 1 }}</label>
        <select class="custom-select form-control-border question-select" id="question{{ $index }}" name="questions[{{ $index }}][id]" onchange="checkDuplicate()">
          <option value="{{ $question->id }}" selected>{{ $question->question }}</option>
          @foreach ($questions as $item)
            <option value="{{ $item->id }}">{{ $item->question }}</option>
          @endforeach
        </select>
      @endforeach

      <button type="submit" class="btn btn-primary" id="updateBtn">Update Numbering</button>
    </form>
  </div>

  <script>
    function checkDuplicate() {
      var selects = document.querySelectorAll('.question-select');
      var updateBtn = document.getElementById('updateBtn');
      var duplicateValues = [];

      selects.forEach(function(select) {
        var value = select.value;

        if (duplicateValues.includes(value)) {
          select.classList.add('duplicate-question');
        } else {
          select.classList.remove('duplicate-question');
        }
      });

      duplicateValues = Array.from(selects, function(select) {
        return select.value;
      }).filter(function(value, index, self) {
        return self.indexOf(value) !== index;
      });

      if (duplicateValues.length > 0) {
        selects.forEach(function(select) {
          if (duplicateValues.includes(select.value)) {
            select.classList.add('duplicate-question');
          } else {
            select.classList.remove('duplicate-question');
          }
        });

        updateBtn.setAttribute('disabled', 'disabled');
      } else {
        selects.forEach(function(select) {
          select.classList.remove('duplicate-question');
        });

        updateBtn.removeAttribute('disabled');
      }
    }
  </script>
@endsection
