<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Add Customer</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>
                <i class="bi bi-person-plus-fill me-2"></i>
                Add Customer
            </h2>

            <p class="text-muted mb-0">
                Enter the customer's information below.
            </p>
        </div>

        <!-- Back to Dashboard -->
        <a href="index.php?page=dashboard"
           class="btn btn-outline-primary">

            <i class="bi bi-arrow-left me-2"></i>
            Back to Dashboard

        </a>

    </div>


    <!-- Success Message -->
    <?php if (!empty($_SESSION['success'])): ?>

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            <?= htmlspecialchars($_SESSION['success']) ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>


    <!-- Error Message -->
    <?php if (!empty($_SESSION['error'])): ?>

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            <?= htmlspecialchars($_SESSION['error']) ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>


    <!-- Customer Form -->
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">

            <i class="bi bi-person-vcard me-2"></i>
            Customer Information

        </div>

        <div class="card-body">

            <form method="POST"
                  action="save_customer.php">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            First Name
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            class="form-control"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="last_name"
                            class="form-control"
                            required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Phone
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control">

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Street Address
                        </label>

                        <input
                            type="text"
                            name="street_address"
                            class="form-control"
                            required>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            class="form-control">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            State
                        </label>

                        <input
                            type="text"
                            name="state"
                            class="form-control">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Country
                        </label>

                        <input
                            type="text"
                            name="country"
                            class="form-control">

                    </div>


                    <input type="hidden"
                           name="latitude">

                    <input type="hidden"
                           name="longitude">

                </div>


                <!-- Buttons -->
                <div class="d-flex justify-content-between mt-3">

                    <a href="index.php?page=dashboard"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-2"></i>
                        Cancel

                    </a>


                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-lg me-2"></i>
                        Save Customer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Bootstrap JavaScript -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>
```
