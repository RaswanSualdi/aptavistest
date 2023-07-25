@extends('index')
@section('content')
<div class="container">
<form method="POST" action="{{ route('skor.store') }}">
    @csrf
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="klub_id_1">Klub 1:</label>
            <select class="form-control"  id="klub_id_1" name="klub_id_1" required>
                @foreach($klubs as $klub)
                    <option value="{{ $klub->id }}">{{ $klub->nama_klub }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="klub_id_2">Klub 2:</label>
            <select class="form-control" id="klub_id_2" name="klub_id_2" required>
                @foreach($klubs as $klub)
                    <option value="{{ $klub->id }}">{{ $klub->nama_klub }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="score_1">Score Klub 1:</label>
            <input class="form-control"  type="number" id="score_1" name="score_1" required>
        </div>
    
        <div class="col-md-2">
            <label for="score_2">Score Klub 2:</label>
            <input class="form-control"  type="number" id="score_2" name="score_2" required>
        </div>
    
</div>
<button class="btn btn-success" type="submit">Save</button>
</form>

<h2>Input Multiple Skor Pertandingan</h2>
<form id="multipleForm" method="POST" action="{{ route('skor.storeMultiple') }}">
    @csrf
    <div id="scoresContainer">
        <!-- div scores akan dimunculkan disini -->
    </div>
    <button id="saveMultipleButton" class="btn btn-success mb-3" type="submit" style="display: none">Save Multiple Scores</button>
</form>

<button class="btn btn-primary "onclick="addScoreInput()">Add Score</button>

</div>


{{-- untuk menambahkan div scores jika tombol add score ditekan --}}
<script>
    let scoreCounter = 0;
    const klubIds = @json($klubs->pluck('id'));

    function addScoreInput() {
        scoreCounter++;

        const scoresContainer = document.getElementById('scoresContainer');

        const scoreInput = `
            <div id="score-${scoreCounter}">
                <div class="row mb-3">
                <div class="col-md-4">
                <label for="scores[${scoreCounter}][klub_id_1]">Klub 1:</label>
                <select class="form-control" id="scores[${scoreCounter}][klub_id_1]" name="scores[${scoreCounter}][klub_id_1]" required>
                    @foreach($klubs as $klub)
                        <option value="{{ $klub->id }}">{{ $klub->nama_klub }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="scores[${scoreCounter}][klub_id_2]">Klub 2:</label>
                <select class="form-control" id="scores[${scoreCounter}][klub_id_2]" name="scores[${scoreCounter}][klub_id_2]" required>
                    @foreach($klubs as $klub)
                        <option value="{{ $klub->id }}">{{ $klub->nama_klub }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="scores[${scoreCounter}][score_1]">Score Klub 1:</label>
                <input class="form-control" type="number" id="scores[${scoreCounter}][score_1]" name="scores[${scoreCounter}][score_1]" required>
            </div>
            <div class="col-md-2">
                <label for="scores[${scoreCounter}][score_2]">Score Klub 2:</label>
                <input class="form-control" type="number" id="scores[${scoreCounter}][score_2]" name="scores[${scoreCounter}][score_2]" required>
            </div>
        </div>
                <button type="button" class="btn btn-danger mb-3" onclick="removeScoreInput(${scoreCounter})">Remove</button>
            </div>
        `;

        scoresContainer.insertAdjacentHTML('beforeend', scoreInput);
        toggleSaveMultipleButton();
    }

    // fungsi untuk tombol remove score input
    function removeScoreInput(scoreIndex) {
        const scoreElement = document.getElementById(`score-${scoreIndex}`);
        scoreElement.remove();
        toggleSaveMultipleButton();
    }

   
</script>


{{-- untuk menampilkan alert jika ada data yang sama pada pertandingan --}}
{{-- <script>
    function showAlert(message) {
        alert(message);
    }
     document.getElementById('multipleForm').addEventListener('submit', function (event) {
        const selectedKlubIds = new Set();
        const duplicateKlubs = [];

        document.querySelectorAll('[name^="scores"]').forEach(scoreInput => {
            const klubId1 = scoreInput.querySelector('[name$="[klub_id_1]"]').value;
            const klubId2 = scoreInput.querySelector('[name$="[klub_id_2]"]').value;

            if (selectedKlubIds.has(klubId1) || selectedKlubIds.has(klubId2)) {
                duplicateKlubs.push(klubId1, klubId2);
            }

            selectedKlubIds.add(klubId1);
            selectedKlubIds.add(klubId2);
        });

        if (duplicateKlubs.length > 0) {
            event.preventDefault();
            const duplicateKlubNames = duplicateKlubs.map(klubId => klubIds.find(id => id === klubId)).join(', ');
            showAlert(`Klub tidak dapat memainkan dua laga sekaligus: ${duplicateKlubNames}`);
        }
    });
</script> --}}

{{-- kalau sudah menekan tombol add scores maka tombol save multiple score akan muncul --}}
<script>
       function toggleSaveMultipleButton() {
        const saveMultipleButton = document.getElementById('saveMultipleButton');
        saveMultipleButton.style.display = scoreCounter > 0 ? 'block' : 'none';

        // kalau inputan multiple scores tidak ada maka save multiple scores dihilangkan
        const scoresContainer = document.getElementById('scoresContainer');
        const scoreInputs = scoresContainer.querySelectorAll('[id^="score-"]');
        const hasInputs = scoreInputs.length > 0;
        saveMultipleButton.style.display = hasInputs ? 'block' : 'none';
    }

// load fungsi toggleSaveMultipleButton
    window.onload = function () {
        toggleSaveMultipleButton();
    };
</script>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@endsection
