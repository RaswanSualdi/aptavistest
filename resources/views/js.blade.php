
{{-- warning input nama club --}}
<script>
    const clubNameInput = document.getElementById("club_name");
    const nameFeedback = document.getElementById("name-feedback");
    const existingNames = Array.from(document.querySelectorAll("tbody td:nth-child(2)")).map(td => td.textContent.trim().toLowerCase());

    function updateValidityState() {
        const newName = clubNameInput.value.trim().toLowerCase();

        if (newName === "") {
            nameFeedback.innerHTML = "Nama klub tidak boleh kosong.";
            clubNameInput.setAttribute("class", "form-control is-invalid");
        } else if (existingNames.includes(newName)) {
            nameFeedback.innerHTML = "Nama klub sudah ada pada tabel.";
            clubNameInput.setAttribute("class", "form-control is-invalid");
        } else {
            nameFeedback.innerHTML = "";
            clubNameInput.setAttribute("class", "form-control is-valid");
        }
    }

    clubNameInput.addEventListener("input", updateValidityState);
</script>

{{-- untuk tambah match --}}
<script>
    const addMatchBtn = document.getElementById('addMatchBtn');
    const matchRow = document.querySelector('.match-row');

    addMatchBtn.addEventListener('click', () => {
        const newRow = matchRow.cloneNode(true);
        matchRow.parentNode.insertBefore(newRow, matchRow.nextSibling);
    });
</script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/app.js"></script>


