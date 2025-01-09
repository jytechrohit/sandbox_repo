<div class="form-group">
    <label>First Name</label>
    <input type="text" name="first_name" class="form-control"
        value="{{ old('first_name', $customer->first_name ?? '') }}" required>
</div>
<div class="form-group">
    <label>Last Name</label>
    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $customer->last_name ?? '') }}"
        required>
</div>
<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email ?? '') }}"
        required>
</div>
<div class="form-group">
    <label>Age</label>
    <input type="number" name="age" class="form-control" value="{{ old('age', $customer->age ?? '') }}" required>
</div>
<div class="form-group">
    <label>Date of Birth</label>
    <input type="date" name="dob" class="form-control"
        value="{{ old('dob', optional($customer->dob)->format('Y-m-d') ?? '') }}" required>
</div>
