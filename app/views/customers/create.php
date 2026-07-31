<div class="container mt-4">

    <h2>Add New Customer</h2>

    <form method="POST" action="save_customer.php">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input
                    type="text"
                    name="first_name"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input
                    type="text"
                    name="last_name"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input
                    type="text"
                    name="phone"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>Street Address</label>
                <input
                    type="text"
                    name="street_address"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-4 mb-3">
                <label>City</label>
                <input
                    type="text"
                    name="city"
                    class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>State</label>
                <input
                    type="text"
                    name="state"
                    class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Country</label>
                <input
                    type="text"
                    name="country"
                    class="form-control"
                    value="Nigeria">
            </div>

            <input type="hidden" name="latitude">
            <input type="hidden" name="longitude">

        </div>

        <button class="btn btn-primary">
            Save Customer
        </button>

    </form>

</div>