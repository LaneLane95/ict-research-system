<form action="{{ route('research.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>Main Category</label>
        <select name="category" id="category" class="form-control" onchange="updateForm()">
            <option value="">-- Select Category --</option>
            <option value="DepEd">DepEd Research</option>
            <option value="Non-DepEd">Non-DepEd Research</option>
            <option value="Innovation">Innovation</option>
        </select>
    </div>

    <div class="form-group" id="sub_type_container" style="display:none;">
        <label id="sub_type_label">Classification</label>
        <select name="sub_type" id="sub_type" class="form-control">
            </select>
    </div>

    <div id="common_fields" style="display:none;">
        <input type="date" name="date_received" placeholder="Date Received" class="form-control mt-2">
        <input type="text" name="school_id" placeholder="School ID" class="form-control mt-2">
        <input type="text" name="school_name" placeholder="School Name" class="form-control mt-2">
        <input type="text" name="district" placeholder="District" class="form-control mt-2">
        <input type="text" name="author" placeholder="Author" class="form-control mt-2">
        <textarea name="title" placeholder="Title" class="form-control mt-2"></textarea>
        <input type="text" name="type_of_research" placeholder="Type of Research" class="form-control mt-2">
        <input type="text" name="theme" placeholder="Theme" class="form-control mt-2">
        <label class="mt-2">Endorsement Date</label>
        <input type="date" name="endorsement_date" class="form-control">
        <label class="mt-2">Released Date</label>
        <input type="date" name="released_date" class="form-control">
        <label class="mt-2">Completion Date</label>
        <input type="date" name="completion_date" class="form-control">

        <div id="coc_field" style="display:none;">
            <label class="mt-2">COC Date</label>
            <input type="date" name="coc_date" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Save Data</button>
    </div>
</form>

<script>
function updateForm() {
    const cat = document.getElementById('category').value;
    const subTypeContainer = document.getElementById('sub_type_container');
    const subTypeSelect = document.getElementById('sub_type');
    const commonFields = document.getElementById('common_fields');
    const cocField = document.getElementById('coc_field');

    if(cat === "") {
        commonFields.style.display = "none";
        subTypeContainer.style.display = "none";
        return;
    }

    commonFields.style.display = "block";
    subTypeSelect.innerHTML = ""; // Clear options

    if (cat === "DepEd") {
        subTypeContainer.style.display = "block";
        subTypeSelect.innerHTML = '<option value="Proposal">Proposal</option><option value="Ongoing">Ongoing</option>';
        cocField.style.display = "block";
    } else if (cat === "Non-DepEd") {
        subTypeContainer.style.display = "block";
        subTypeSelect.innerHTML = '<option value="Thesis">Thesis</option><option value="Dissertation">Dissertation</option>';
        cocField.style.display = "none";
    } else if (cat === "Innovation") {
        subTypeContainer.style.display = "none"; // Walang dropdown based sa request mo
        cocField.style.display = "block";
    }
}
</script>